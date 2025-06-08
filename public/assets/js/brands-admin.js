class BrandManager {
    constructor() {
        this.init();
        this.bindEvents();
        this.initComponents();
    }

    init() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        this.apiEndpoints = {
            toggle: '/admin/api/brands/{id}/toggle',
            toggleFeatured: '/admin/api/brands/{id}/toggle-featured',
            get: '/admin/api/brands/{id}',
            checkSlug: '/admin/api/brands/check-slug',
            stats: '/admin/api/brands/{id}/stats',
            bulkAction: '/admin/brands/bulk-action'
        };
    }

    bindEvents() {
        // Toggle status buttons
        $(document).on('click', '.toggle-status', this.handleToggleStatus.bind(this));

        // Toggle featured buttons
        $(document).on('click', '.toggle-featured', this.handleToggleFeatured.bind(this));

        // View brand details
        $(document).on('click', '.view-brand', this.handleViewBrand.bind(this));

        // Bulk actions
        $(document).on('change', '.bulk-checkbox', this.handleBulkCheckbox.bind(this));
        $(document).on('click', '.select-all-brands', this.handleSelectAll.bind(this));
        $(document).on('click', '.bulk-action-btn', this.handleBulkAction.bind(this));

        // Search and filters
        $(document).on('input', '.search-input', this.debounce(this.handleSearch.bind(this), 500));
        $(document).on('change', '.filter-select', this.handleFilter.bind(this));

        // Image preview in forms
        $(document).on('change', '#imageInput', this.handleImagePreview.bind(this));

        // Slug generation
        $(document).on('input', '#name', this.debounce(this.handleSlugGeneration.bind(this), 300));
        $(document).on('blur', '#slug', this.handleSlugValidation.bind(this));

        // Form submission
        $(document).on('submit', '#brandForm', this.handleFormSubmission.bind(this));

        // Quick actions
        $(document).on('click', '.quick-edit', this.handleQuickEdit.bind(this));
        $(document).on('click', '.quick-stats', this.handleQuickStats.bind(this));
    }

    initComponents() {
        // Initialize tooltips
        if (typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Initialize select2 if available
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Initialize data tables if available
        if ($.fn.DataTable) {
            this.initDataTable();
        }

        // Initialize image upload dropzone
        this.initImageUpload();
    }

    // ====================================================================================================
    // Event Handlers
    // ====================================================================================================

    handleToggleStatus(e) {
        e.preventDefault();

        const button = $(e.currentTarget);
        const brandId = button.data('id');
        const currentStatus = button.data('status') === 'true';
        const newStatus = !currentStatus;
        const actionText = newStatus ? 'mengaktifkan' : 'menonaktifkan';

        Swal.fire({
            title: 'Konfirmasi Perubahan Status',
            text: `Apakah Anda yakin ingin ${actionText} merek ini?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: `Ya, ${actionText.charAt(0).toUpperCase() + actionText.slice(1)}!`,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.toggleBrandStatus(brandId, button);
            }
        });
    }

    handleToggleFeatured(e) {
        e.preventDefault();

        const button = $(e.currentTarget);
        const brandId = button.data('id');

        this.toggleBrandFeatured(brandId, button);
    }

    handleViewBrand(e) {
        e.preventDefault();

        const brandId = $(e.currentTarget).data('id');
        this.showBrandDetails(brandId);
    }

    handleBulkCheckbox(e) {
        const checkedBoxes = $('.bulk-checkbox:checked').length;
        const totalBoxes = $('.bulk-checkbox').length;

        // Update select all checkbox
        const selectAllCheckbox = $('.select-all-brands');
        selectAllCheckbox.prop('indeterminate', checkedBoxes > 0 && checkedBoxes < totalBoxes);
        selectAllCheckbox.prop('checked', checkedBoxes === totalBoxes);

        // Show/hide bulk actions
        this.toggleBulkActions(checkedBoxes > 0);
    }

    handleSelectAll(e) {
        const isChecked = $(e.currentTarget).prop('checked');
        $('.bulk-checkbox').prop('checked', isChecked);
        this.toggleBulkActions(isChecked);
    }

    handleBulkAction(e) {
        e.preventDefault();

        const action = $(e.currentTarget).data('action');
        const selectedIds = $('.bulk-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire({
                title: 'Tidak Ada Merek Dipilih',
                text: 'Silakan pilih minimal satu merek untuk melakukan aksi.',
                icon: 'warning',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        this.executeBulkAction(action, selectedIds);
    }

    handleSearch(e) {
        const searchTerm = $(e.currentTarget).val();
        this.performSearch(searchTerm);
    }

    handleFilter(e) {
        const filterType = $(e.currentTarget).data('filter');
        const filterValue = $(e.currentTarget).val();
        this.applyFilter(filterType, filterValue);
    }

    handleImagePreview(e) {
        const file = e.target.files[0];
        if (file) {
            this.previewImage(file);
        }
    }

    handleSlugGeneration(e) {
        const name = $(e.currentTarget).val();
        const slug = this.generateSlug(name);
        $('#slug').val(slug);
        this.validateSlug(slug);
    }

    handleSlugValidation(e) {
        const slug = $(e.currentTarget).val();
        this.validateSlug(slug);
    }

    handleFormSubmission(e) {
        e.preventDefault();
        this.submitForm($(e.currentTarget));
    }

    handleQuickEdit(e) {
        e.preventDefault();
        const brandId = $(e.currentTarget).data('id');
        this.showQuickEditModal(brandId);
    }

    handleQuickStats(e) {
        e.preventDefault();
        const brandId = $(e.currentTarget).data('id');
        this.showStatsModal(brandId);
    }

    // ====================================================================================================
    // API Methods
    // ====================================================================================================

    async toggleBrandStatus(brandId, button) {
        try {
            this.showLoading();

            const response = await $.ajax({
                url: this.getApiUrl('toggle', brandId),
                method: 'PATCH',
                dataType: 'json'
            });

            if (response.success) {
                // Update button
                button.data('status', response.data.is_active);
                button.find('i').removeClass().addClass(
                    response.data.is_active ? 'icon-eye-off' : 'icon-eye'
                );
                button.find('span').text(
                    response.data.is_active ? 'Nonaktifkan' : 'Aktifkan'
                );

                // Update status badge
                const statusBadge = button.closest('tr').find('.status-badge');
                statusBadge.removeClass('status-active status-inactive')
                    .addClass(response.data.is_active ? 'status-active' : 'status-inactive')
                    .html(response.data.is_active ?
                        '<i class="icon-check"></i> Aktif' :
                        '<i class="icon-close"></i> Nonaktif'
                    );

                this.showSuccess(response.message);
            }
        } catch (error) {
            this.handleError(error);
        } finally {
            this.hideLoading();
        }
    }

    async toggleBrandFeatured(brandId, button) {
        try {
            const response = await $.ajax({
                url: this.getApiUrl('toggleFeatured', brandId),
                method: 'PATCH',
                dataType: 'json'
            });

            if (response.success) {
                button.find('i').toggleClass('icon-star icon-star-o');
                this.showSuccess(response.message);
            }
        } catch (error) {
            this.handleError(error);
        }
    }

    async showBrandDetails(brandId) {
        try {
            this.showLoading();

            const response = await $.ajax({
                url: this.getApiUrl('get', brandId),
                method: 'GET',
                dataType: 'json'
            });

            if (response.success) {
                this.displayBrandModal(response.data);
            }
        } catch (error) {
            this.handleError(error);
        } finally {
            this.hideLoading();
        }
    }

    async validateSlug(slug, excludeId = null) {
        if (!slug) return;

        try {
            const response = await $.ajax({
                url: this.apiEndpoints.checkSlug,
                method: 'POST',
                data: {
                    slug: slug,
                    exclude_id: excludeId
                },
                dataType: 'json'
            });

            const slugInput = $('#slug');
            const feedback = slugInput.next('.feedback');

            if (feedback.length === 0) {
                slugInput.after('<div class="feedback"></div>');
            }

            if (response.available) {
                slugInput.removeClass('is-invalid').addClass('is-valid');
                slugInput.next('.feedback').removeClass('invalid-feedback')
                    .addClass('valid-feedback').text(response.message);
            } else {
                slugInput.removeClass('is-valid').addClass('is-invalid');
                slugInput.next('.feedback').removeClass('valid-feedback')
                    .addClass('invalid-feedback').text(response.message);
            }
        } catch (error) {
            console.error('Slug validation error:', error);
        }
    }

    async executeBulkAction(action, selectedIds) {
        let confirmText = '';
        let confirmButtonColor = '#007bff';

        switch (action) {
            case 'activate':
                confirmText = `Aktifkan ${selectedIds.length} merek terpilih?`;
                confirmButtonColor = '#28a745';
                break;
            case 'deactivate':
                confirmText = `Nonaktifkan ${selectedIds.length} merek terpilih?`;
                confirmButtonColor = '#ffc107';
                break;
            case 'delete':
                confirmText = `Hapus ${selectedIds.length} merek terpilih? Aksi ini tidak dapat dibatalkan.`;
                confirmButtonColor = '#dc3545';
                break;
        }

        const result = await Swal.fire({
            title: 'Konfirmasi Aksi Massal',
            text: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            try {
                this.showLoading();

                const response = await $.ajax({
                    url: this.apiEndpoints.bulkAction,
                    method: 'POST',
                    data: {
                        action: action,
                        brand_ids: selectedIds
                    },
                    dataType: 'json'
                });

                if (response.success) {
                    this.showSuccess(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            } catch (error) {
                this.handleError(error);
            } finally {
                this.hideLoading();
            }
        }
    }

    // ====================================================================================================
    // Helper Methods
    // ====================================================================================================

    getApiUrl(endpoint, id = null) {
        let url = this.apiEndpoints[endpoint];
        if (id && url.includes('{id}')) {
            url = url.replace('{id}', id);
        }
        return url;
    }

    generateSlug(text) {
        return text.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }

    previewImage(file) {
        // Validate file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                title: 'Format File Tidak Valid',
                text: 'Silakan upload file dengan format PNG, JPG, atau JPEG.',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal adalah 2MB.',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImg').attr('src', e.target.result);
            $('#uploadContent').hide();
            $('#imagePreview').show();

            // Show compare if in edit mode
            if ($('#imageCompare').length) {
                $('#compareNewImg').attr('src', e.target.result);
                $('#imageCompare').show();
            }
        };
        reader.readAsDataURL(file);
    }

    displayBrandModal(brand) {
        const modalHtml = `
            <div class="modal fade" id="brandDetailModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="icon-credit-card"></i> Detail Merek
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="${brand.image_url}" alt="${brand.name}"
                                         class="img-fluid rounded mb-3" style="max-height: 200px;">
                                </div>
                                <div class="col-md-8">
                                    <h4>${brand.name}</h4>
                                    <p class="text-muted">${brand.slug}</p>
                                    <p>${brand.description || 'Tidak ada deskripsi'}</p>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">${brand.products_count}</h5>
                                                    <p class="card-text">Total Produk</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">${brand.active_products_count}</h5>
                                                    <p class="card-text">Produk Aktif</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="/admin/brand/edit/${brand.id}" class="btn btn-primary">Edit Merek</a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal
        $('#brandDetailModal').remove();

        // Add new modal and show
        $('body').append(modalHtml);
        $('#brandDetailModal').modal('show');
    }

    toggleBulkActions(show) {
        const bulkActions = $('.bulk-actions');
        if (show) {
            bulkActions.slideDown();
        } else {
            bulkActions.slideUp();
        }
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    showLoading() {
        $('#loadingOverlay').show();
    }

    hideLoading() {
        $('#loadingOverlay').hide();
    }

    showSuccess(message) {
        Swal.fire({
            title: 'Berhasil!',
            text: message,
            icon: 'success',
            confirmButtonColor: '#28a745',
            timer: 3000,
            timerProgressBar: true
        });
    }

    showError(message) {
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
    }

    handleError(error) {
        console.error('Error:', error);

        let message = 'Terjadi kesalahan yang tidak terduga.';

        if (error.responseJSON && error.responseJSON.message) {
            message = error.responseJSON.message;
        } else if (error.statusText) {
            message = error.statusText;
        }

        this.showError(message);
    }

    initDataTable() {
        if ($('#brandsTable').length) {
            $('#brandsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [-1] } // Disable sorting on action column
                ],
                language: {
                    url: '/assets/admin/js/datatables-id.json' // Indonesian language file
                }
            });
        }
    }

    initImageUpload() {
        // Drag and drop functionality
        const uploadSection = $('#uploadSection');

        if (uploadSection.length) {
            uploadSection.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });

            uploadSection.on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
            });

            uploadSection.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');

                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    const fileInput = $('#imageInput')[0];
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            });
        }
    }
}

// Initialize when document is ready
$(document).ready(function() {
    window.brandManager = new BrandManager();
});

// Expose utility functions globally
window.BrandUtils = {
    generateSlug: function(text) {
        return window.brandManager.generateSlug(text);
    },

    validateSlug: function(slug, excludeId = null) {
        return window.brandManager.validateSlug(slug, excludeId);
    },

    previewImage: function(file) {
        return window.brandManager.previewImage(file);
    }
};

/**
 * Category Management JavaScript
 * Script untuk mengelola kategori dengan fitur-fitur lanjutan
 */

class CategoryManager {
    constructor() {
        this.init();
    }

    init() {
        this.initEventListeners();
        this.initBulkActions();
        this.initDragAndDrop();
        this.initRealTimeValidation();
        this.initImageUpload();
        this.initTooltips();
    }

    // ====================================================================================================
    // Event Listeners
    // ====================================================================================================
    initEventListeners() {
        // Toggle featured status
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('toggle-featured')) {
                this.toggleFeatured(e.target.dataset.categoryId);
            }
        });

        // Preview category
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('preview-category')) {
                this.previewCategory(e.target.dataset.categoryId);
            }
        });

        // Duplicate category
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('duplicate-category')) {
                this.duplicateCategory(e.target.dataset.categoryId);
            }
        });

        // View category stats
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('view-stats')) {
                this.viewCategoryStats(e.target.dataset.categoryId);
            }
        });
    }

    // ====================================================================================================
    // Bulk Actions
    // ====================================================================================================
    initBulkActions() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const bulkActionBtn = document.getElementById('bulkActionBtn');
        const bulkActionSelect = document.getElementById('bulkAction');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => {
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
                this.updateBulkActionButton();
            });
        }

        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.updateBulkActionButton();
                this.updateSelectAllState();
            });
        });

        if (bulkActionBtn) {
            bulkActionBtn.addEventListener('click', () => {
                this.executeBulkAction();
            });
        }
    }

    updateBulkActionButton() {
        const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
        const bulkActionContainer = document.getElementById('bulkActionContainer');
        const selectedCount = document.getElementById('selectedCount');

        if (checkedBoxes.length > 0) {
            bulkActionContainer.style.display = 'block';
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkActionContainer.style.display = 'none';
        }
    }

    updateSelectAllState() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');

        if (selectAllCheckbox) {
            if (checkedBoxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedBoxes.length === categoryCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
    }

    executeBulkAction() {
        const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
        const bulkAction = document.getElementById('bulkAction').value;

        if (checkedBoxes.length === 0) {
            Swal.fire('Peringatan', 'Pilih minimal satu kategori', 'warning');
            return;
        }

        if (!bulkAction) {
            Swal.fire('Peringatan', 'Pilih aksi yang akan dilakukan', 'warning');
            return;
        }

        const categoryIds = Array.from(checkedBoxes).map(cb => cb.value);

        let confirmText = '';
        let actionText = '';

        switch (bulkAction) {
            case 'delete':
                confirmText = `Hapus ${categoryIds.length} kategori yang dipilih?`;
                actionText = 'Data yang dihapus tidak dapat dikembalikan.';
                break;
            case 'feature':
                confirmText = `Tandai ${categoryIds.length} kategori sebagai unggulan?`;
                actionText = 'Kategori unggulan akan ditampilkan di homepage.';
                break;
            case 'unfeature':
                confirmText = `Hapus ${categoryIds.length} kategori dari unggulan?`;
                actionText = 'Kategori tidak akan lagi ditampilkan di homepage.';
                break;
            case 'export':
                confirmText = `Export ${categoryIds.length} kategori yang dipilih?`;
                actionText = 'Data akan didownload dalam format Excel.';
                break;
        }

        Swal.fire({
            title: 'Konfirmasi Aksi',
            text: confirmText,
            html: `<p>${confirmText}</p><small class="text-muted">${actionText}</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#007bff'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submitBulkAction(bulkAction, categoryIds);
            }
        });
    }

    submitBulkAction(action, categoryIds) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/categories/bulk-action';

        // CSRF Token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfToken);

        // Action
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        form.appendChild(actionInput);

        // Category IDs
        categoryIds.forEach(id => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'categories[]';
            idInput.value = id;
            form.appendChild(idInput);
        });

        // Loading indicator
        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        document.body.appendChild(form);
        form.submit();
    }

    // ====================================================================================================
    // Drag & Drop Sorting
    // ====================================================================================================
    initDragAndDrop() {
        const tableBody = document.querySelector('#categoryTable tbody');
        if (!tableBody) return;

        // Initialize Sortable.js if available
        if (typeof Sortable !== 'undefined') {
            new Sortable(tableBody, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: (evt) => {
                    this.updateCategoryOrder();
                }
            });
        }
    }

    updateCategoryOrder() {
        const rows = document.querySelectorAll('#categoryTable tbody tr');
        const categories = [];

        rows.forEach((row, index) => {
            const categoryId = row.dataset.categoryId;
            if (categoryId) {
                categories.push({
                    id: categoryId,
                    sort_order: index
                });
            }
        });

        fetch('/admin/categories/reorder', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ categories })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showToast('Urutan kategori berhasil diperbarui', 'success');
            } else {
                this.showToast('Gagal mengubah urutan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showToast('Terjadi kesalahan', 'error');
        });
    }

    // ====================================================================================================
    // Real-time Validation
    // ====================================================================================================
    initRealTimeValidation() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        if (nameInput) {
            nameInput.addEventListener('input', this.debounce(() => {
                this.validateName(nameInput.value);
                if (!slugInput.dataset.manual) {
                    const slug = this.generateSlug(nameInput.value);
                    slugInput.value = slug;
                    this.validateSlug(slug);
                }
            }, 500));
        }

        if (slugInput) {
            slugInput.addEventListener('input', this.debounce(() => {
                slugInput.dataset.manual = 'true';
                this.validateSlug(slugInput.value);
            }, 500));

            slugInput.addEventListener('blur', () => {
                const cleanSlug = this.cleanSlug(slugInput.value);
                slugInput.value = cleanSlug;
                this.validateSlug(cleanSlug);
            });
        }
    }

    validateName(name) {
        const nameInput = document.getElementById('name');
        const feedback = document.getElementById('nameFeedback');

        if (name.length < 3) {
            this.setInputState(nameInput, 'invalid', 'Nama kategori minimal 3 karakter');
        } else if (name.length > 100) {
            this.setInputState(nameInput, 'invalid', 'Nama kategori maksimal 100 karakter');
        } else {
            this.setInputState(nameInput, 'valid', 'Nama kategori valid');
        }
    }

    validateSlug(slug) {
        const slugInput = document.getElementById('slug');
        const categoryId = document.getElementById('categoryId')?.value;

        if (!slug) {
            this.setInputState(slugInput, 'invalid', 'Slug tidak boleh kosong');
            return;
        }

        if (!/^[a-z0-9-]+$/.test(slug)) {
            this.setInputState(slugInput, 'invalid', 'Slug hanya boleh huruf kecil, angka, dan tanda (-)');
            return;
        }

        // Check availability via AJAX
        const params = new URLSearchParams({ slug });
        if (categoryId) params.append('id', categoryId);

        fetch(`/admin/category/check-slug?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    this.setInputState(slugInput, 'valid', 'Slug tersedia');
                } else {
                    this.setInputState(slugInput, 'invalid', data.message);
                    if (data.suggested) {
                        this.showSlugSuggestion(data.suggested);
                    }
                }
            })
            .catch(error => {
                console.error('Error checking slug:', error);
            });
    }

    setInputState(input, state, message) {
        const validationIcon = input.parentElement.querySelector('.validation-icon');
        const feedback = document.getElementById(input.id + 'Feedback');

        input.classList.remove('is-valid', 'is-invalid');

        if (state === 'valid') {
            input.classList.add('is-valid');
            if (validationIcon) {
                validationIcon.innerHTML = '<i class="icon-check text-success"></i>';
            }
        } else if (state === 'invalid') {
            input.classList.add('is-invalid');
            if (validationIcon) {
                validationIcon.innerHTML = '<i class="icon-close text-danger"></i>';
            }
        }

        if (feedback) {
            feedback.textContent = message;
            feedback.className = `form-text ${state === 'valid' ? 'text-success' : 'text-danger'}`;
        }
    }

    showSlugSuggestion(suggestedSlug) {
        const slugInput = document.getElementById('slug');
        const suggestion = document.createElement('div');
        suggestion.className = 'slug-suggestion mt-1';
        suggestion.innerHTML = `
            <small class="text-info">
                Saran: <span class="suggested-slug" style="cursor: pointer; text-decoration: underline;">${suggestedSlug}</span>
            </small>
        `;

        // Remove existing suggestion
        const existingSuggestion = slugInput.parentElement.querySelector('.slug-suggestion');
        if (existingSuggestion) {
            existingSuggestion.remove();
        }

        slugInput.parentElement.appendChild(suggestion);

        // Click to use suggestion
        suggestion.querySelector('.suggested-slug').addEventListener('click', () => {
            slugInput.value = suggestedSlug;
            slugInput.dataset.manual = 'true';
            this.validateSlug(suggestedSlug);
            suggestion.remove();
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (suggestion.parentElement) {
                suggestion.remove();
            }
        }, 5000);
    }

    // ====================================================================================================
    // Image Upload Enhancement
    // ====================================================================================================
    initImageUpload() {
        const fileInput = document.getElementById('myFile');
        const uploadContainer = document.getElementById('uploadContainer');
        const previewContainer = document.getElementById('previewContainer');

        if (!fileInput || !uploadContainer) return;

        // Enhanced drag and drop
        uploadContainer.addEventListener('dragenter', (e) => {
            e.preventDefault();
            uploadContainer.classList.add('drag-over');
        });

        uploadContainer.addEventListener('dragleave', (e) => {
            e.preventDefault();
            if (!uploadContainer.contains(e.relatedTarget)) {
                uploadContainer.classList.remove('drag-over');
            }
        });

        uploadContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        uploadContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadContainer.classList.remove('drag-over');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                this.handleFileSelection(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                this.handleFileSelection(e.target.files[0]);
            }
        });
    }

    handleFileSelection(file) {
        // Validate file
        const validation = this.validateImageFile(file);
        if (!validation.valid) {
            Swal.fire('File Tidak Valid', validation.message, 'error');
            return;
        }

        // Show preview
        this.showImagePreview(file);
    }

    validateImageFile(file) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!allowedTypes.includes(file.type)) {
            return {
                valid: false,
                message: 'File harus berupa gambar (JPEG, PNG, WEBP)'
            };
        }

        if (file.size > maxSize) {
            return {
                valid: false,
                message: 'Ukuran file maksimal 2MB'
            };
        }

        return { valid: true };
    }

    showImagePreview(file) {
        const reader = new FileReader();
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const previewInfo = document.getElementById('previewInfo');
        const uploadContainer = document.getElementById('uploadContainer');

        reader.onload = (e) => {
            previewImage.src = e.target.result;

            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            previewInfo.innerHTML = `
                <strong>${file.name}</strong><br>
                Ukuran: ${fileSize} MB<br>
                <small class="text-muted">Preview gambar yang akan diupload</small>
            `;

            if (uploadContainer) uploadContainer.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

    // ====================================================================================================
    // Feature Methods
    // ====================================================================================================
    toggleFeatured(categoryId) {
        fetch(`/admin/category/${categoryId}/toggle-featured`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const toggleBtn = document.querySelector(`[data-category-id="${categoryId}"]`);
                if (toggleBtn) {
                    toggleBtn.innerHTML = data.featured
                        ? '<i class="icon-star"></i>'
                        : '<i class="icon-star-o"></i>';
                    toggleBtn.classList.toggle('text-warning', data.featured);
                }
                this.showToast(data.message, 'success');
            } else {
                this.showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showToast('Terjadi kesalahan', 'error');
        });
    }

    duplicateCategory(categoryId) {
        Swal.fire({
            title: 'Duplikasi Kategori',
            text: 'Kategori akan diduplikasi dengan nama "(Copy)". Anda bisa mengeditnya setelah duplikasi.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Duplikasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/admin/category/${categoryId}/duplicate`;
            }
        });
    }

    viewCategoryStats(categoryId) {
        fetch(`/api/admin/categories/${categoryId}/stats`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.showStatsModal(data.data);
                } else {
                    this.showToast('Gagal memuat statistik', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToast('Terjadi kesalahan', 'error');
            });
    }

    showStatsModal(stats) {
        const modalContent = `
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-item">
                        <h4>${stats.total_products}</h4>
                        <p>Total Produk</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-item">
                        <h4>${stats.active_products}</h4>
                        <p>Produk Aktif</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-item">
                        <h4>Rp ${this.formatNumber(stats.total_value)}</h4>
                        <p>Total Nilai</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-item">
                        <h4>Rp ${this.formatNumber(stats.average_price)}</h4>
                        <p>Rata-rata Harga</p>
                    </div>
                </div>
            </div>
        `;

        Swal.fire({
            title: 'Statistik Kategori',
            html: modalContent,
            width: 600,
            confirmButtonText: 'Tutup'
        });
    }

    // ====================================================================================================
    // Utility Methods
    // ====================================================================================================
    generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    cleanSlug(slug) {
        return slug
            .toLowerCase()
            .replace(/[^a-z0-9-]/g, '')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
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

    formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    showToast(message, type = 'info') {
        // Using SweetAlert2 toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: type,
            title: message
        });
    }

    initTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined') {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new CategoryManager();
});

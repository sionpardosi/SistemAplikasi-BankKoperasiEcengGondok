document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Penjadwalan JavaScript loaded');

    // Initialize all features
    initializeTooltips();
    initializeBulkSelection();
    initializeQuickStatusButtons();
    initializeSmartScheduling();
    initializeRouteOptimization();
    initializeAdvancedSearch();
    initializeAutoRefresh();
    initializeCalendar();
    loadDashboardStats();

    // Show success/error messages from session
    showSessionMessages();
});

// Initialize Bootstrap tooltips
function initializeTooltips() {
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        console.log('Tooltips initialized');
    }
}

// Initialize bulk selection functionality
function initializeBulkSelection() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkActionPanel = document.getElementById('bulkActionPanel');
    const bulkActionForm = document.getElementById('bulkActionForm');

    if (selectAllCheckbox && itemCheckboxes.length > 0) {
        selectAllCheckbox.addEventListener('change', function(e) {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
            updateBulkActionPanel();
        });

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionPanel);
        });

        // Handle bulk action form submission
        if (bulkActionForm) {
            bulkActionForm.addEventListener('submit', handleBulkAction);
        }

        // Handle action change for conditional inputs
        const actionSelect = document.querySelector('select[name="action"]');
        if (actionSelect) {
            actionSelect.addEventListener('change', function() {
                const statusSelect = document.getElementById('statusSelect');
                const dateInput = document.getElementById('dateInput');

                // Hide all conditional inputs
                if (statusSelect) statusSelect.style.display = 'none';
                if (dateInput) dateInput.style.display = 'none';

                // Show relevant input based on selected action
                switch(this.value) {
                    case 'update_status':
                        if (statusSelect) statusSelect.style.display = 'block';
                        break;
                    case 'reschedule':
                        if (dateInput) dateInput.style.display = 'block';
                        break;
                }
            });
        }

        console.log('Bulk selection initialized');
    }
}

function updateBulkActionPanel() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const bulkActionPanel = document.getElementById('bulkActionPanel');
    const selectedCountEl = document.getElementById('selectedCount');

    if (bulkActionPanel) {
        if (checkedBoxes.length > 0) {
            bulkActionPanel.style.display = 'block';
            if (selectedCountEl) {
                selectedCountEl.textContent = checkedBoxes.length;
            }
        } else {
            bulkActionPanel.style.display = 'none';
        }
    }
}

async function handleBulkAction(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const selectedIds = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                            .map(cb => cb.value);

    if (selectedIds.length === 0) {
        showToast('Pilih minimal satu jadwal', 'warning');
        return;
    }

    const action = formData.get('action');
    if (!action) {
        showToast('Pilih aksi yang akan dilakukan', 'warning');
        return;
    }

    let confirmMessage = `Yakin ingin melakukan aksi ini pada ${selectedIds.length} jadwal?`;
    if (action === 'delete') {
        confirmMessage = `Yakin ingin menghapus ${selectedIds.length} jadwal? Aksi ini tidak dapat dibatalkan.`;
    }

    const result = await Swal.fire({
        title: 'Konfirmasi Bulk Action',
        text: confirmMessage,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch('/admin/penjadwalan-penjemputan/bulk-actions', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: action,
                'schedule_ids[]': selectedIds,
                new_status: formData.get('new_status') || '',
                new_date: formData.get('new_date') || ''
            })
        });

        const result = await response.json();

        if (result.success) {
            showToast('Bulk action berhasil dilakukan', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(result.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Bulk action error:', error);
        showToast('Error: ' + error.message, 'error');
    }
}

// Initialize quick status buttons (✓ Selesai, ✗ Batal)
function initializeQuickStatusButtons() {
    document.addEventListener('click', async function(e) {
        if (e.target.classList.contains('quick-status-btn')) {
            e.preventDefault();

            const button = e.target;
            const scheduleId = button.dataset.scheduleId;
            const newStatus = button.dataset.status;
            const originalText = button.dataset.originalText || button.textContent;

            if (!scheduleId || !newStatus) {
                showToast('Data tidak lengkap', 'error');
                return;
            }

            // Confirm action
            const statusText = newStatus === 'dijemput' ? 'selesai dijemput' : 'dibatalkan';
            const result = await Swal.fire({
                title: 'Konfirmasi',
                text: `Yakin ingin menandai jadwal ini sebagai ${statusText}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            });

            if (!result.isConfirmed) return;

            try {
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                const response = await fetch(`/api/admin/schedule/${scheduleId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                // TAMBAHAN: Check response sebelum parsing JSON
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`HTTP ${response.status}: ${errorText}`);
                }

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const errorText = await response.text();
                    throw new Error(`Expected JSON response but got: ${contentType}. Response: ${errorText.substring(0, 200)}...`);
                }

                const result = await response.json();

                if (result.success) {
                    // Update UI
                    const currentRow = button.closest('tr');
                    const statusCell = currentRow.querySelector('.status-cell');
                    if (statusCell) {
                        statusCell.innerHTML = result.schedule.status_badge;
                    }

                    // Remove quick action buttons if status changed
                    const actionGroup = button.closest('.action-group');
                    const quickButtons = actionGroup.querySelectorAll('.quick-status-btn');
                    quickButtons.forEach(btn => btn.remove());

                    showToast('Status berhasil diperbarui', 'success');

                    // Refresh dashboard stats
                    loadDashboardStats();
                } else {
                    throw new Error(result.message || 'Gagal memperbarui status');
                }
            } catch (error) {
                console.error('Quick status update error:', error);
                showToast('Error: ' + error.message, 'error');

                // Restore button state
                button.disabled = false;
                button.innerHTML = originalText;
            }
        }
    });

    console.log('Quick status buttons initialized');
}

// Initialize smart scheduling
function initializeSmartScheduling() {
    const smartScheduleBtn = document.getElementById('smartScheduleBtn');
    if (smartScheduleBtn) {
        smartScheduleBtn.addEventListener('click', openSmartSchedulingModal);
        console.log('Smart scheduling initialized');
    }
}

async function openSmartSchedulingModal() {
    try {
        const response = await fetch('/api/admin/available-requests');
        const requests = await response.json();

        if (requests.error) {
            throw new Error(requests.error);
        }

        if (requests.length === 0) {
            showToast('Tidak ada permintaan yang tersedia untuk dijadwalkan', 'info');
            return;
        }

        // Create modal content
        let modalContent = `
            <div class="smart-scheduling-modal">
                <h5>Pilih Permintaan untuk Dijadwalkan</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" id="smartStartDate" class="form-control" value="${new Date().toISOString().split('T')[0]}">
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" id="smartEndDate" class="form-control" value="${new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0]}">
                    </div>
                </div>
                <div class="request-selection" style="max-height: 300px; overflow-y: auto;">
        `;

        requests.forEach(req => {
            modalContent += `
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="${req.id}" id="req_${req.id}">
                    <label class="form-check-label" for="req_${req.id}">
                        <strong>${req.nama}</strong> - ${req.kecamatan}, ${req.desa} (${req.estimasi_kg} kg)
                        <br><small class="text-muted">${req.email} | ${req.insentif === 'diskon' ? 'Diskon' : 'Uang Tunai'}</small>
                    </label>
                </div>
            `;
        });

        modalContent += `
                </div>
            </div>
        `;

        Swal.fire({
            title: 'Smart Scheduling',
            html: modalContent,
            width: '800px',
            showCancelButton: true,
            confirmButtonText: 'Generate Jadwal Optimal',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                const selectedIds = Array.from(document.querySelectorAll('.request-selection input:checked'))
                                       .map(cb => cb.value);
                const startDate = document.getElementById('smartStartDate').value;
                const endDate = document.getElementById('smartEndDate').value;

                if (selectedIds.length === 0) {
                    Swal.showValidationMessage('Pilih minimal satu permintaan');
                    return false;
                }

                return { selectedIds, startDate, endDate };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                generateSmartSchedule(result.value);
            }
        });

    } catch (error) {
        console.error('Smart scheduling error:', error);
        showToast('Error loading requests: ' + error.message, 'error');
    }
}

// Ganti fungsi generateSmartSchedule (sekitar baris 280)
async function generateSmartSchedule(params) {
    try {
        // Debug: log the request
        console.log('Sending request to smart scheduling...', params);

        const response = await fetch('/admin/penjadwalan-penjemputan/smart-scheduling', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                supplier_request_ids: params.selectedIds,
                preferred_date_range: {
                    start: params.startDate,
                    end: params.endDate
                }
            })
        });

        // Debug: log response details
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));

        // Check if response is HTML (error page)
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('text/html')) {
            const htmlText = await response.text();
            console.error('Received HTML instead of JSON:', htmlText.substring(0, 500));
            throw new Error('Server returned HTML error page. Check browser console for details.');
        }

        // Check if response is ok
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP ${response.status}: ${errorText}`);
        }

        const result = await response.json();
        console.log('Smart scheduling result:', result);

        if (result.success) {
            showSchedulingSuggestions(result);
        } else {
            throw new Error(result.message || 'Gagal generate jadwal');
        }

    } catch (error) {
        console.error('Generate schedule error:', error);
        showToast('Error generating schedule: ' + error.message, 'error');
    }
}

function showSchedulingSuggestions(data) {
    let content = '<div class="scheduling-suggestions">';
    content += `<div class="alert alert-info">
        <strong>Ringkasan:</strong> ${data.summary.total_requests} permintaan,
        ${data.summary.total_weight} kg total, ${data.summary.location_groups} kelompok lokasi
    </div>`;

    data.suggestions.forEach((group, index) => {
        content += `
            <div class="suggestion-group mb-3 p-3 border rounded">
                <h6>Kelompok ${index + 1}: ${group.location}</h6>
                <p><strong>Tanggal Optimal:</strong> ${new Date(group.suggested_date).toLocaleDateString('id-ID')}</p>
                <p><strong>Total Berat:</strong> ${group.total_weight} kg | <strong>Skor Efisiensi:</strong> ${group.efficiency_score}</p>
                <div class="requests">
        `;

        group.requests.forEach(req => {
            content += `
                <div class="request-item border-bottom py-1">
                    <small><strong>${req.nama}</strong> (${req.estimasi_kg} kg) - Priority: ${req.priority_score}</small>
                </div>
            `;
        });

        content += '</div></div>';
    });

    content += '</div>';

    Swal.fire({
        title: 'Saran Penjadwalan Optimal',
        html: content,
        width: '900px',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Tutup'
    });
}

// Initialize route optimization
function initializeRouteOptimization() {
    const optimizeRouteBtn = document.getElementById('optimizeRouteBtn');
    if (optimizeRouteBtn) {
        optimizeRouteBtn.addEventListener('click', optimizeRoute);
        console.log('Route optimization initialized');
    }
}

async function optimizeRoute() {
    const selectedDate = document.getElementById('routeOptimizationDate')?.value || new Date().toISOString().split('T')[0];

    try {
        const response = await fetch(`/admin/penjadwalan-penjemputan/optimize-route?date=${selectedDate}`);
        const result = await response.json();

        if (result.success) {
            if (result.optimized_route.length === 0) {
                showToast('Tidak ada jadwal untuk tanggal tersebut', 'info');
                return;
            }
            showOptimizedRoute(result);
        } else {
            throw new Error(result.message || 'Gagal optimasi rute');
        }

    } catch (error) {
        console.error('Route optimization error:', error);
        showToast('Error optimizing route: ' + error.message, 'error');
    }
}

function showOptimizedRoute(routeData) {
    let content = `
        <div class="route-optimization">
            <div class="route-summary mb-3 p-3 bg-light rounded">
                <h6>Ringkasan Rute ${routeData.date}</h6>
                <div class="row">
                    <div class="col-6"><strong>Total Stop:</strong> ${routeData.summary.total_stops}</div>
                    <div class="col-6"><strong>Total Berat:</strong> ${routeData.summary.total_weight} kg</div>
                    <div class="col-6"><strong>Estimasi Waktu:</strong> ${routeData.summary.estimated_total_time} menit</div>
                    <div class="col-6"><strong>Skor Efisiensi:</strong> ${routeData.summary.efficiency_score}</div>
                </div>
            </div>
            <div class="route-steps">
    `;

    routeData.optimized_route.forEach(step => {
        content += `
            <div class="route-step d-flex align-items-center mb-2 p-2 border-bottom">
                <div class="step-number me-3">
                    <span class="badge bg-primary">${step.sequence}</span>
                </div>
                <div class="step-details flex-grow-1">
                    <strong>${step.supplier_name}</strong>
                    <br><small>${step.location} (${step.estimasi_kg} kg)</small>
                    <br><small class="text-muted">Tiba: ${step.arrival_time} | Berangkat: ${step.departure_time}</small>
                    ${step.phone !== '-' ? `<br><small class="text-info">📞 ${step.phone}</small>` : ''}
                </div>
                <div class="step-time text-end">
                    <small>${step.estimated_pickup_time} min</small>
                </div>
            </div>
        `;
    });

    content += '</div></div>';

    Swal.fire({
        title: 'Rute Optimal',
        html: content,
        width: '800px',
        confirmButtonText: 'OK',
        showCancelButton: false
    });
}

// Initialize advanced search
function initializeAdvancedSearch() {
    const searchInput = document.getElementById('scheduleSearch');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(e.target.value);
            }, 300);
        });
        console.log('Advanced search initialized');
    }
}

async function performSearch(query) {
    const resultsContainer = document.getElementById('searchResults');
    if (!resultsContainer) return;

    if (query.length < 2) {
        resultsContainer.innerHTML = '';
        resultsContainer.style.display = 'none';
        return;
    }

    try {
        const response = await fetch(`/api/admin/search-schedules?search=${encodeURIComponent(query)}`);
        const results = await response.json();

        if (results.error) {
            throw new Error(results.error);
        }

        displaySearchResults(results, resultsContainer);

    } catch (error) {
        console.error('Search error:', error);
        resultsContainer.innerHTML = '<p class="p-2 text-danger">Error: ' + error.message + '</p>';
        resultsContainer.style.display = 'block';
    }
}

function displaySearchResults(results, container) {
    if (results.length === 0) {
        container.innerHTML = '<p class="p-2 text-muted">Tidak ada hasil ditemukan</p>';
        container.style.display = 'block';
        return;
    }

    let html = '<div class="search-results">';
    results.forEach(schedule => {
        html += `
            <div class="search-result-item p-2 border-bottom" style="cursor: pointer;" onclick="window.location.href='/admin/penjadwalan-penjemputan/${schedule.id}/edit'">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${schedule.supplier_name}</strong>
                        <br><small>${schedule.location} | ${schedule.estimasi_kg} kg</small>
                        <br><small class="text-muted">${schedule.tanggal_jemput}</small>
                    </div>
                    <div>
                        <span class="badge bg-${schedule.status_color}">${schedule.status}</span>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';

    container.innerHTML = html;
    container.style.display = 'block';
}

// Initialize auto refresh
function initializeAutoRefresh() {
    const autoRefreshToggle = document.getElementById('autoRefreshToggle');
    if (autoRefreshToggle) {
        autoRefreshToggle.addEventListener('change', function(e) {
            if (e.target.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });
        console.log('Auto refresh initialized');
    }
}

let autoRefreshInterval;

function startAutoRefresh() {
    autoRefreshInterval = setInterval(() => {
        loadDashboardStats();
        console.log('Auto refresh: Dashboard stats updated');
    }, 60000); // Refresh every minute
    showToast('Auto refresh diaktifkan', 'info');
}

function stopAutoRefresh() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
    showToast('Auto refresh dinonaktifkan', 'info');
}

// Load dashboard statistics
async function loadDashboardStats() {
    try {
        const response = await fetch('/api/admin/dashboard-stats');
        const stats = await response.json();

        if (stats.error) {
            throw new Error(stats.error);
        }

        updateStatCards(stats);
    } catch (error) {
        console.error('Error loading dashboard stats:', error);
    }
}

function updateStatCards(stats) {
    // Update today's stats
    const todayTotalEl = document.getElementById('todayTotal');
    const todayCompletedEl = document.getElementById('todayCompleted');
    const todayPendingEl = document.getElementById('todayPending');

    if (todayTotalEl) todayTotalEl.textContent = stats.today.total;
    if (todayCompletedEl) todayCompletedEl.textContent = stats.today.completed;
    if (todayPendingEl) todayPendingEl.textContent = stats.today.pending;

    // Update week stats
    const weekTotalEl = document.getElementById('weekTotal');
    const weekWeightEl = document.getElementById('weekWeight');

    if (weekTotalEl) weekTotalEl.textContent = stats.this_week.total;
    if (weekWeightEl) weekWeightEl.textContent = stats.this_week.weight + ' kg';

    // Update month stats
    const monthTotalEl = document.getElementById('monthTotal');
    const monthRevenueEl = document.getElementById('monthRevenue');

    if (monthTotalEl) monthTotalEl.textContent = stats.this_month.total;
    if (monthRevenueEl) {
        monthRevenueEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(stats.this_month.revenue);
    }

    // Update alerts
    const overdueEl = document.getElementById('overdueCount');
    const upcomingEl = document.getElementById('upcomingCount');

    if (overdueEl) {
        overdueEl.textContent = stats.overdue;
        const alertEl = overdueEl.closest('.alert-overdue');
        if (alertEl) {
            alertEl.style.display = stats.overdue > 0 ? 'block' : 'none';
        }
    }

    if (upcomingEl) {
        upcomingEl.textContent = stats.upcoming_week;
        const alertEl = upcomingEl.closest('.alert-upcoming');
        if (alertEl) {
            alertEl.style.display = stats.upcoming_week > 0 ? 'block' : 'none';
        }
    }
}

// Initialize calendar (basic version without FullCalendar)
function initializeCalendar() {
    const calendarEl = document.getElementById('scheduleCalendar');
    if (!calendarEl) {
        console.log('Calendar element not found');
        return;
    }

    // Function untuk check FullCalendar dengan retry
    function checkAndInitCalendar(retryCount = 0) {
        console.log(`Checking FullCalendar availability, attempt: ${retryCount + 1}`);

        if (typeof FullCalendar !== 'undefined') {
            console.log('FullCalendar is available, initializing...');

            try {
                // Clear any existing content
                calendarEl.innerHTML = '';

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    height: 'auto',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listWeek'
                    },
                    events: async function(fetchInfo, successCallback, failureCallback) {
                        try {
                            console.log('Loading calendar events...');

                            // Load demo data dulu
                            const demoEvents = generateDemoEvents();
                            successCallback(demoEvents);

                            // Kemudian load real data
                            /*
                            const response = await fetch('/admin/calendar-events?' + new URLSearchParams({
                                start: fetchInfo.startStr,
                                end: fetchInfo.endStr
                            }));

                            if (response.ok) {
                                const data = await response.json();
                                successCallback(data);
                            } else {
                                failureCallback('Failed to load events');
                            }
                            */
                        } catch (error) {
                            console.error('Error loading events:', error);
                            // Load demo data sebagai fallback
                            const demoEvents = generateDemoEvents();
                            successCallback(demoEvents);
                        }
                    },
                    eventClick: function(info) {
                        showEventDetails(info.event);
                    },
                    dayMaxEvents: 3,
                    moreLinkClick: 'listWeek',
                    eventDisplay: 'block',
                    eventDidMount: function(info) {
                        console.log('Event mounted:', info.event.title);
                    }
                });

                calendar.render();
                console.log('✅ FullCalendar initialized successfully');

                // Update tampilan sukses
                const calendarContainer = calendarEl.closest('.calendar-section');
                if (calendarContainer) {
                    const header = calendarContainer.querySelector('.calendar-title');
                    if (header) {
                        header.innerHTML = '<i class="icon-calendar"></i> Kalender Penjemputan <span class="badge bg-success ms-2">Active</span>';
                    }
                }

            } catch (error) {
                console.error('❌ Error initializing FullCalendar:', error);
                showCalendarError(calendarEl, error.message);
            }

        } else {
            console.log('FullCalendar not available yet...');

            if (retryCount < 10) { // Max 10 attempts
                setTimeout(() => {
                    checkAndInitCalendar(retryCount + 1);
                }, 500); // Wait 500ms before retry
            } else {
                console.error('❌ FullCalendar failed to load after 10 attempts');
                showCalendarError(calendarEl, 'FullCalendar library failed to load');
            }
        }
    }

    // Start checking
    checkAndInitCalendar();
}

// Function untuk generate demo events
function generateDemoEvents() {
    const events = [];
    const today = new Date();

    // Generate beberapa event demo
    for (let i = 0; i < 10; i++) {
        const eventDate = new Date(today);
        eventDate.setDate(today.getDate() + (i * 2) - 5); // Events around today

        const statuses = ['terjadwal', 'dijemput', 'dibatalkan'];
        const status = statuses[i % 3];

        const colors = {
            'terjadwal': '#ffc107',
            'dijemput': '#28a745',
            'dibatalkan': '#dc3545'
        };

        events.push({
            id: `demo-${i}`,
            title: `Pemasok ${i + 1} (${10 + i}kg)`,
            start: eventDate.toISOString().split('T')[0],
            backgroundColor: colors[status],
            borderColor: colors[status],
            textColor: '#ffffff',
            extendedProps: {
                supplier_name: `Pemasok Demo ${i + 1}`,
                location: `Kecamatan ${i + 1}, Desa ${i + 1}`,
                weight: `${10 + i} kg`,
                status: status,
                phone: `0812345678${i}`,
                email: `pemasok${i + 1}@demo.com`,
            }
        });
    }

    console.log('Generated demo events:', events);
    return events;
}


// Function untuk show error
function showCalendarError(calendarEl, errorMessage) {
    calendarEl.innerHTML = `
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="icon-alert-triangle" style="font-size: 64px; color: #dc3545;"></i>
            </div>
            <h5 class="text-danger">Kalender Error</h5>
            <p class="text-muted">${errorMessage}</p>
            <div class="mt-3">
                <button type="button" class="btn btn-danger btn-sm me-2" onclick="initializeCalendar()">
                    <i class="icon-refresh"></i> Coba Lagi
                </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="showCalendarFallback()">
                    <i class="icon-list"></i> Lihat List
                </button>
            </div>
        </div>
    `;
}

// Function untuk show fallback calendar
function showCalendarFallback() {
    const calendarEl = document.getElementById('scheduleCalendar');
    if (!calendarEl) return;

    calendarEl.innerHTML = `
        <div class="text-center py-4">
            <h6>Jadwal Mendatang</h6>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="card border-warning">
                        <div class="card-body p-2">
                            <small class="text-warning">15 Jun 2025</small><br>
                            <strong>Pemasok A</strong><br>
                            <small>Kec. Balige (15kg)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card border-success">
                        <div class="card-body p-2">
                            <small class="text-success">16 Jun 2025</small><br>
                            <strong>Pemasok B</strong><br>
                            <small>Kec. Laguboti (25kg)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card border-warning">
                        <div class="card-body p-2">
                            <small class="text-warning">17 Jun 2025</small><br>
                            <strong>Pemasok C</strong><br>
                            <small>Kec. Silaen (20kg)</small>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="initializeCalendar()">
                <i class="icon-refresh"></i> Coba Load Kalender Lagi
            </button>
        </div>
    `;
}

// Pastikan showEventDetails tersedia
function showEventDetails(event) {
    const props = event.extendedProps;

    Swal.fire({
        title: props.supplier_name,
        html: `
            <div class="text-start">
                <p><strong>📅 Tanggal:</strong> ${event.start.toLocaleDateString('id-ID')}</p>
                <p><strong>📍 Lokasi:</strong> ${props.location}</p>
                <p><strong>⚖️ Berat:</strong> ${props.weight}</p>
                <p><strong>📋 Status:</strong> <span class="badge bg-${getStatusColor(props.status)}">${props.status}</span></p>
                <p><strong>📞 Telepon:</strong> ${props.phone}</p>
                <p><strong>📧 Email:</strong> ${props.email}</p>
            </div>
        `,
        confirmButtonText: 'OK',
        confirmButtonColor: '#007bff'
    });
}

function getStatusColor(status) {
    switch (status.toLowerCase()) {
        case 'terjadwal': return 'warning';
        case 'dijemput': return 'success';
        case 'dibatalkan': return 'danger';
        default: return 'secondary';
    }
}

// Tambahkan atau pastikan fungsi ini ada
function showEventDetails(event) {
    const props = event.extendedProps;

    Swal.fire({
        title: props.supplier_name,
        html: `
            <div class="text-start">
                <p><strong>📅 Tanggal:</strong> ${event.start.toLocaleDateString('id-ID')}</p>
                <p><strong>📍 Lokasi:</strong> ${props.location}</p>
                <p><strong>⚖️ Berat:</strong> ${props.weight}</p>
                <p><strong>📋 Status:</strong> <span class="badge bg-${getStatusColor(props.status)}">${props.status}</span></p>
                <p><strong>📞 Telepon:</strong> ${props.phone}</p>
                <p><strong>📧 Email:</strong> ${props.email}</p>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Edit Jadwal',
        cancelButtonText: 'Tutup',
        confirmButtonColor: '#007bff'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/admin/penjadwalan-penjemputan/${event.id}/edit`;
        }
    });
}

function getStatusColor(status) {
    switch (status.toLowerCase()) {
        case 'terjadwal': return 'warning';
        case 'dijemput': return 'success';
        case 'dibatalkan': return 'danger';
        default: return 'secondary';
    }
}

function getStatusColor(status) {
    switch (status.toLowerCase()) {
        case 'terjadwal': return 'warning';
        case 'dijemput': return 'success';
        case 'dibatalkan': return 'danger';
        default: return 'secondary';
    }
}

// Show session messages (success/error from Laravel)
function showSessionMessages() {
    // These will be handled by blade template script tags
}

// Toast notification function
function showToast(message, type = 'info') {
    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: type,
            title: message
        });
    } else {
        // Fallback alert
        alert(message);
    }
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }
});

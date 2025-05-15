@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title fw-bold mb-4">Edit Alamat</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('layouts.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__address">
                        <div class="mb-4">
                            <a href="{{ route('user.address.account-address') }}"
                                class="btn btn-outline-secondary rounded-pill px-4" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Kembali ke daftar alamat">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>

                        <div class="card shadow-sm border-0 rounded-lg">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <h5 class="mb-0 fw-bold">Informasi Alamat</h5>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('user.address.update-address', $address->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Personal Information -->
                                    <div class="section-form mb-4">
                                        <h6 class="text-muted mb-3 border-bottom pb-2">Detail Kontak</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" placeholder="Masukkan nama lengkap"
                                                        value="{{ old('name', $address->name) }}" required>
                                                    <label for="name">Nama Lengkap <span
                                                            class="text-danger">*</span></label>
                                                    @error('name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        id="phone" name="phone" placeholder="Masukkan nomor telepon"
                                                        value="{{ old('phone', $address->phone) }}" required>
                                                    <label for="phone">Nomor Telepon <span
                                                            class="text-danger">*</span></label>
                                                    @error('phone')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Location Information -->
                                    <div class="section-form mb-4">
                                        <h6 class="text-muted mb-3 border-bottom pb-2">Detail Lokasi</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('state') is-invalid @enderror"
                                                        id="state" name="state" placeholder="Masukkan provinsi"
                                                        value="{{ old('state', $address->state) }}" required>
                                                    <label for="state">Provinsi <span
                                                            class="text-danger">*</span></label>
                                                    @error('state')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('city') is-invalid @enderror"
                                                        id="city" name="city" placeholder="Masukkan kota/kabupaten"
                                                        value="{{ old('city', $address->city) }}" required>
                                                    <label for="city">Kota / Kabupaten <span
                                                            class="text-danger">*</span></label>
                                                    @error('city')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('zip') is-invalid @enderror"
                                                        id="zip" name="zip" placeholder="Masukkan kode pos"
                                                        value="{{ old('zip', $address->zip) }}" required>
                                                    <label for="zip">Kode Pos <span
                                                            class="text-danger">*</span></label>
                                                    @error('zip')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        id="address" name="address"
                                                        placeholder="Masukkan nomor rumah/gedung"
                                                        value="{{ old('address', $address->address) }}" required>
                                                    <label for="address">Nomor Rumah, Nama Gedung <span
                                                            class="text-danger">*</span></label>
                                                    @error('address')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('locality') is-invalid @enderror"
                                                        id="locality" name="locality" placeholder="Masukkan nama jalan"
                                                        value="{{ old('locality', $address->locality) }}" required>
                                                    <label for="locality">Nama Jalan, Area, Kelurahan <span
                                                            class="text-danger">*</span></label>
                                                    @error('locality')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text"
                                                        class="form-control @error('landmark') is-invalid @enderror"
                                                        id="landmark" name="landmark"
                                                        placeholder="Masukkan patokan lokasi"
                                                        value="{{ old('landmark', $address->landmark) }}" required>
                                                    <label for="landmark">Patokan <span
                                                            class="text-danger">*</span></label>
                                                    @error('landmark')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-text text-muted">Contoh: Dekat Rumah Listra yang Jelek</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information -->
                                    <div class="section-form mb-4">
                                        <h6 class="text-muted mb-3 border-bottom pb-2">Informasi Tambahan</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="type" name="type">
                                                        <option value="home"
                                                            {{ old('type', $address->type) == 'home' ? 'selected' : '' }}>
                                                            Rumah</option>
                                                        <option value="office"
                                                            {{ old('type', $address->type) == 'office' ? 'selected' : '' }}>
                                                            Kantor</option>
                                                        <option value="other"
                                                            {{ old('type', $address->type) == 'other' ? 'selected' : '' }}>
                                                            Lainnya</option>
                                                    </select>
                                                    <label for="type">Tipe Alamat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="country"
                                                        name="country" placeholder="Masukkan negara"
                                                        value="{{ old('country', $address->country) }}">
                                                    <label for="country">Negara</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="isdefault" name="isdefault" value="1"
                                                {{ old('isdefault', $address->isdefault) ? 'checked' : '' }}
                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="Alamat ini akan digunakan secara default saat checkout">
                                            <label class="form-check-label" for="isdefault">
                                                Jadikan sebagai alamat utama
                                                @if (old('isdefault', $address->isdefault))
                                                    <span class="badge bg-primary ms-2">Alamat Utama</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                        <a href="{{ route('user.address.account-address') }}"
                                            class="btn btn-light me-md-2 px-4">Batal</a>
                                        <button type="submit" class="btn btn-primary px-4" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Simpan perubahan alamat">
                                            <i class="fas fa-check me-2"></i>Perbarui Alamat
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize all tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });

                // Add nice hover effects to inputs
                const formControls = document.querySelectorAll('.form-control, .form-select');
                formControls.forEach(element => {
                    element.addEventListener('focus', function() {
                        this.parentElement.classList.add('input-highlight');
                    });
                    element.addEventListener('blur', function() {
                        this.parentElement.classList.remove('input-highlight');
                    });
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Form styling */
            .form-floating>.form-control:focus~label,
            .form-floating>.form-control:not(:placeholder-shown)~label {
                color: #956a3b;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #956a3b;
                box-shadow: 0 0 0 0.25rem rgba(149, 106, 59, 0.25);
            }

            .input-highlight {
                transition: all 0.3s ease;
            }

            /* Button styling */
            .btn-primary {
                background-color: #956a3b;
                border-color: #956a3b;
            }

            .btn-primary:hover,
            .btn-primary:focus {
                background-color: #7d582f;
                border-color: #7d582f;
            }

            .btn-outline-secondary:hover {
                background-color: #f8f9fa;
                color: #212529;
            }

            /* Card styling */
            .card {
                transition: all 0.3s ease;
            }

            /* Badge styling */
            .badge.bg-primary {
                background-color: #956a3b !important;
            }

            /* Form switch styling */
            .form-check-input:checked {
                background-color: #956a3b;
                border-color: #956a3b;
            }

            /* Section styling */
            .section-form {
                padding-bottom: 1rem;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .card-body {
                    padding: 1.25rem;
                }
            }
        </style>
    @endpush
@endsection

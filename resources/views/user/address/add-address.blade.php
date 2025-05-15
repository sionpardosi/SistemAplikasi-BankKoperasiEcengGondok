@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Tambah Alamat Baru</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('layouts.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__address">
                        <div class="mb-4">
                            <a href="{{ route('user.address.account-address') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Alamat
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('user.address.store-address') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Lengkap <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                    name="phone" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip">Kode Pos <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('zip') is-invalid @enderror" id="zip"
                                                    name="zip" value="{{ old('zip') }}" required>
                                                @error('zip')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">Provinsi <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('state') is-invalid @enderror" id="state"
                                                    name="state" value="{{ old('state') }}" required>
                                                @error('state')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">Kota / Kabupaten <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('city') is-invalid @enderror" id="city"
                                                    name="city" value="{{ old('city') }}" required>
                                                @error('city')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Nomor Rumah, Nama Gedung <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    id="address" name="address" value="{{ old('address') }}" required>
                                                @error('address')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="locality">Nama Jalan, Area, Kelurahan <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('locality') is-invalid @enderror"
                                                    id="locality" name="locality" value="{{ old('locality') }}" required>
                                                @error('locality')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="landmark">Patokan <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('landmark') is-invalid @enderror"
                                                    id="landmark" name="landmark" value="{{ old('landmark') }}" required>
                                                @error('landmark')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">Tipe Alamat</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="home" {{ old('type') == 'home' ? 'selected' : '' }}>
                                                        Rumah</option>
                                                    <option value="office"
                                                        {{ old('type') == 'office' ? 'selected' : '' }}>Kantor</option>
                                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>
                                                        Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Negara</label>
                                                <input type="text" class="form-control" id="country" name="country"
                                                    value="{{ old('country', 'Indonesia') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="isdefault"
                                                name="isdefault" value="1" {{ old('isdefault') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="isdefault">Jadikan sebagai alamat
                                                utama</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: #956a3b; border-color: #956a3b;">Simpan
                                            Alamat</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        /* Tambahkan CSS ini ke file CSS utama Anda atau buat file CSS baru */

/* Style untuk halaman alamat */
.my-account__address .notice {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.my-account__address-item {
    margin-bottom: 20px;
    border: 1px solid #eaeaea;
    border-radius: 5px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.my-account__address-item:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.my-account__address-item__title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #f8f8f8;
    border-bottom: 1px solid #eaeaea;
}

.my-account__address-item__title h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.my-account__address-item__title h5 .badge {
    font-size: 12px;
    margin-left: 10px;
}

.my-account__address-item__title a {
    color: #956a3b;
    font-size: 14px;
    font-weight: 500;
}

.my-account__address-item__detail {
    padding: 15px;
}

.my-account__address-item__detail p {
    margin-bottom: 5px;
    font-size: 14px;
    color: #333;
}

/* Responsive styling */
@media (max-width: 767px) {
    .my-account__address-item {
        margin-bottom: 15px;
    }
}

/* Form styling */
.form-floating {
    position: relative;
    margin-bottom: 20px;
}

.form-floating input,
.form-floating select {
    height: calc(3.5rem + 2px);
    padding: 1rem 0.75rem;
}

.form-floating label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem 0.75rem;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
}

.form-floating input:focus ~ label,
.form-floating input:not(:placeholder-shown) ~ label,
.form-floating select:focus ~ label,
.form-floating select:not(:placeholder-shown) ~ label {
    opacity: 0.65;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Style tombol */
.btn-primary {
    background-color: #956a3b;
    border-color: #956a3b;
}

.btn-primary:hover {
    background-color: #7d592f;
    border-color: #7d592f;
}
    </style>
@endsection

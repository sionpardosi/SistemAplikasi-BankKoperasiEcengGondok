@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Create Informasi Halaman Deskripsi Pemasok</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.supplier.index') }}">
                            <div class="text-tiny">Pemasok</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Create</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="wg-box-content">
                    <form action="{{ route('admin.adminsupplier.informasi_supplier.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Informasi Dasar</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" rows="5"
                                        class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="image">Gambar Utama</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*"
                                        onchange="previewImage(this)" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Video Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Informasi Video</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="video_type">Jenis Video</label>
                                    <select name="video_type" id="video_type" class="form-control"
                                        onchange="toggleVideoInputs()">
                                        <option value="">-- Pilih Jenis Video --</option>
                                        <option value="local" {{ old('video_type') == 'local' ? 'selected' : '' }}>Video
                                            Lokal</option>
                                        <option value="instagram" {{ old('video_type') == 'instagram' ? 'selected' : '' }}>
                                            Video Instagram</option>
                                    </select>
                                </div>

                                <!-- Local Video Upload -->
                                <div id="localVideoSection" class="mt-3" style="display: none;">
                                    <div class="form-group">
                                        <label for="video_file">Upload Video</label>
                                        <input type="file" name="video_file" id="video_file"
                                            class="form-control @error('video_file') is-invalid @enderror"
                                            accept="video/mp4,video/mov,video/avi">
                                        @error('video_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format yang didukung: MP4, MOV, AVI </small>
                                    </div>
                                    <div id="videoPreview" class="mt-2"></div>
                                </div>

                                <!-- Instagram Video -->
                                <div id="instagramVideoSection" class="mt-3" style="display: none;">
                                    <div class="form-group">
                                        <label for="instagram_url">URL Video Instagram</label>
                                        <input type="url" name="instagram_url" id="instagram_url"
                                            class="form-control @error('instagram_url') is-invalid @enderror"
                                            value="{{ old('instagram_url') }}"
                                            placeholder="https://www.instagram.com/p/XXXXXXXXXXXX/">
                                        @error('instagram_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Masukkan URL dari video/post/reel
                                            Instagram</small>
                                    </div>
                                </div>

                                <!-- Video Caption & Details (for both types) -->
                                <div id="videoDetailsSection" class="mt-3" style="display: none;">
                                    <div class="form-group">
                                        <label for="video_caption">Caption Video</label>
                                        <input type="text" name="video_caption" id="video_caption"
                                            class="form-control @error('video_caption') is-invalid @enderror"
                                            value="{{ old('video_caption') }}">
                                        @error('video_caption')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="video_thumbnail">Thumbnail Video (Custom)</label>
                                        <input type="file" name="video_thumbnail" id="video_thumbnail"
                                            class="form-control @error('video_thumbnail') is-invalid @enderror"
                                            accept="image/*" onchange="previewThumbnail(this)">
                                        @error('video_thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Opsional. Untuk video Instagram, default
                                            thumbnail akan diambil dari Instagram</small>
                                        <div id="thumbnailPreview" class="mt-2"></div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="video_duration">Durasi Video</label>
                                        <input type="text" name="video_duration" id="video_duration"
                                            class="form-control @error('video_duration') is-invalid @enderror"
                                            value="{{ old('video_duration') }}" placeholder="01:30">
                                        @error('video_duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format: MM:SS (contoh: 01:30 untuk 1 menit 30
                                            detik)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Settings -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Pengaturan Tambahan</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="order">Urutan</label>
                                    <input type="number" name="order" id="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', 0) }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Angka lebih kecil akan ditampilkan lebih
                                        dulu</small>
                                </div>

                                <div class="form-check mt-3">
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                        {{ old('is_active') ? 'checked' : '' }} value="1">
                                    <label for="is_active" class="form-check-label">Aktif</label>
                                    <small class="form-text text-muted d-block">Jika dicentang, informasi ini akan
                                        ditampilkan di halaman publik</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.adminsupplier.informasi_supplier.index') }}"
                                class="btn btn-danger mr-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for form functionality -->
    <script>
        // Function to toggle video inputs based on selected type
        function toggleVideoInputs() {
            const videoType = document.getElementById('video_type').value;
            const localVideoSection = document.getElementById('localVideoSection');
            const instagramVideoSection = document.getElementById('instagramVideoSection');
            const videoDetailsSection = document.getElementById('videoDetailsSection');

            if (videoType === 'local') {
                localVideoSection.style.display = 'block';
                instagramVideoSection.style.display = 'none';
                videoDetailsSection.style.display = 'block';
            } else if (videoType === 'instagram') {
                localVideoSection.style.display = 'none';
                instagramVideoSection.style.display = 'block';
                videoDetailsSection.style.display = 'block';
            } else {
                localVideoSection.style.display = 'none';
                instagramVideoSection.style.display = 'none';
                videoDetailsSection.style.display = 'none';
            }
        }

        // Function to preview the selected image
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    img.className = 'img-thumbnail';
                    preview.appendChild(img);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Function to preview the selected thumbnail
        function previewThumbnail(input) {
            const preview = document.getElementById('thumbnailPreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    img.className = 'img-thumbnail';
                    preview.appendChild(img);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize form state on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleVideoInputs();
        });
    </script>
@endsection

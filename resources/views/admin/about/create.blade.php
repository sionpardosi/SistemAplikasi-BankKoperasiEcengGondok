@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <h3>{{ isset($about) ? 'Edit Tentang Kami' : 'Tambah Tentang Kami' }}</h3>
        <form action="{{ isset($about) ? route('admin.about.update', $about) : route('admin.about.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($about))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Judul <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required
                    value="{{ old('title', $about->title ?? '') }}">
            </div>

            <div class="form-group">
                <label>Our Story</label>
                <textarea name="story" class="form-control" rows="4">{{ old('story', $about->story ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Vision</label>
                <textarea name="vision" class="form-control" rows="3">{{ old('vision', $about->vision ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Mission</label>
                <textarea name="mission" class="form-control" rows="3">{{ old('mission', $about->mission ?? '') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Founder</label>
                    <input type="text" name="founder" class="form-control"
                        value="{{ old('founder', $about->founder ?? '') }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Established Date</label>
                    <input type="date" name="established_date" class="form-control"
                        value="{{ old('established_date', $about->established_date ?? '') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $about->address ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label>Embed Peta (iframe)</label>
                    <textarea name="map_embed"
                              class="form-control"
                              rows="3"
                              placeholder="Paste kode &lt;iframe&gt; di sini">{{ old('map_embed', $about->map_embed ?? '') }}</textarea>
                    <small class="form-text text-muted">
                        Masukkan lengkap tag &lt;iframe&gt;…&lt;/iframe&gt; dari Google Maps.
                    </small>
                </div>


            <div class="form-group">
                <label>Contact Info</label>
                <textarea name="contact_info" class="form-control" rows="2">{{ old('contact_info', $about->contact_info ?? '') }}</textarea>
            </div>

            @foreach ([1, 2] as $n)
                <div class="form-group">
                    <label>Gambar {{ $n }}</label>
                    @if (isset($about) && $about->{"image{$n}"})
                        <div class="mb-2">
                            <img src="{{ asset($about->{"image{$n}"}) }}" alt="{{ $about->{"image{$n}_alt"} }}"
                                width="180">
                        </div>
                    @endif
                    {{-- harus image1 dan image2, bukan gambar1 --}}
                    <input type="file" name="image{{ $n }}" class="form-control mb-1">
                    <input type="text" name="image{{ $n }}_caption" class="form-control mb-1"
                        placeholder="Caption" value="{{ old("image{$n}_caption", $about->{"image{$n}_caption"} ?? '') }}">
                    <input type="text" name="image{{ $n }}_alt" class="form-control" placeholder="Alt text"
                        value="{{ old("image{$n}_alt", $about->{"image{$n}_alt"} ?? '') }}">
                </div>
            @endforeach

            <div class="form-group form-check">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                    {{ old('is_active', $about->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Tampilkan</label>
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                    {{ old('is_active', $about->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Tampilkan</label>
            </div>
            <button type="submit" class="btn btn-success">
                {{ isset($about) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.about.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <style>
                /* Custom divider style */
                .divider-hr {
                    width: 60px;
                    border-top: 4px solid #6b4e2e !important;
                    margin: 1rem auto 2rem;
                    position: relative;
                    z-index: 2;
                }

                .justify-text {
                    text-align: justify;
                }
            </style>

            <div class="mw-930 text-center mb-4">
                {{-- Judul halaman turun sedikit --}}
                <h2 class="page-title fw-bold text-primary pt-4">{{ $about->title }}</h2>
                {{-- Meta informasi --}}
                @if ($about->founder || $about->established_date)
                    <p class="text-muted mt-2">
                        @if ($about->founder)
                            <span>Didirikan oleh <strong>{{ $about->founder }}</strong></span>
                        @endif
                        @if ($about->founder && $about->established_date)
                            &nbsp;&middot;&nbsp;
                        @endif
                        @if ($about->established_date)
                            <span>Sejak {{ \Carbon\Carbon::parse($about->established_date)->format('Y') }}</span>
                        @endif
                    </p>
                    <hr class="divider-hr">
                @endif
            </div>

            <div class="about-us__content pb-5 mb-5">
                {{-- Banner image1 ukuran dikurangi --}}
                <p class="mb-5">
                    @if ($about->image1)
                        <img loading="lazy" class="w-100 h-auto d-block rounded shadow-sm" src="{{ asset($about->image1) }}"
                            alt="{{ $about->image1_alt ?? $about->title }}" style="max-height:400px;object-fit:cover;" />
                    @else
                        <img loading="lazy" class="w-100 h-auto d-block rounded shadow-sm"
                            src="{{ asset('assets/images/shop/shop_banner3 - Copy.jpg') }}"
                            style="max-height:400px;object-fit:cover;" alt="" />
                    @endif
                </p>

                <div class="mw-930 mx-auto">
                    {{-- CERITA KAMI --}}
                    <div class="mb-5">
                        <h3 class="mb-3 text-secondary">CERITA KAMI</h3>
                        <div class="fs-6 fw-normal justify-text">
                            {!! nl2br(e($about->story)) !!}
                        </div>
                    </div>

                    {{-- Misi & Visi --}}
                    <div class="row mb-5">
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-brown">Misi Kami</h5>
                                    <p class="card-text">{!! nl2br(e($about->mission)) !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-brown">Visi Kami</h5>
                                    <p class="card-text">{!! nl2br(e($about->vision)) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mw-930 mx-auto d-lg-flex align-items-lg-start">
                    {{-- Gambar kedua --}}
                    <div class="image-wrapper col-lg-6 mb-4 mb-lg-0">
                        @if ($about->image2)
                            <img class="img-fluid rounded shadow-sm" loading="lazy" src="{{ asset($about->image2) }}"
                                alt="{{ $about->image2_alt ?? 'About image 2' }}"
                                style="max-height:350px;object-fit:cover;">
                            @if ($about->image2_caption)
                                <p class="text-center text-muted fst-italic mt-1">{{ $about->image2_caption }}</p>
                            @endif
                        @else
                            <img class="img-fluid rounded shadow-sm" loading="lazy"
                                src="{{ asset('assets/images/about/about-1.jpg') }}" alt=""
                                style="max-height:350px;object-fit:cover;">
                        @endif
                    </div>

                    {{-- TENTANG PERUSAHAAN & Kontak --}}
                    <div class="content-wrapper col-lg-6 px-lg-4 mt-lg-n4">
                        <h5 class="mb-3 text-secondary">ALAMAT PERUSAHAAN</h5>
                        <p class="text-justify mb-4">{!! nl2br(e($about->address)) !!}</p>
                        @if ($about->contact_info)
                            <div class="border-top pt-3">
                                <h6 class="text-muted">Informasi Kontak</h6>
                                <p class="mb-0">{!! nl2br(e($about->contact_info)) !!}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Embeddable Map --}}
                @if ($about->map_embed)
                    <div class="mw-930 mx-auto mt-5 text-center">
                        <h3 class="mb-3 text-secondary">PETA LOKASI</h3>
                        <div class="ratio ratio-16x9 rounded shadow-sm">
                            {!! $about->map_embed !!}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

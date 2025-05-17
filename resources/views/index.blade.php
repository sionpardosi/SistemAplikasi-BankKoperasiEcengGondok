@extends('layouts.app')
@section('content')
    <style>
        /* Warna merah untuk prosentase dan kata “Diskon” */
        .discount-text {
            color: #e53935;
            /* merah e-commerce khas */
            font-weight: 600;
            /* tebal agar menonjol */
        }

        /* Styling untuk section Tentang singkat */
        .about-snippet {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .about-snippet img {
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .about-snippet img:hover {
            transform: scale(1.05);
        }

        .about-snippet .btn-readmore {
            color: #6b4e2e;
            border: 1px solid #6b4e2e;
            padding: 0.5rem 1.25rem;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .about-snippet .btn-readmore:hover {
            background-color: #6b4e2e;
            color: #fff;
        }
    </style>

    <style>
        /* Perbaikan untuk slider pada tampilan mobile - letakkan di bagian <style> */
        @media (max-width: 767.98px) {

            /* Mengatur tinggi slider & memindahkan ke atas */
            .swiper-container.slideshow {
                min-height: 420px !important;
                margin-top: -20px !important;
                /* Geser ke atas */
            }

            /* Memindahkan konten teks ke atas */
            .slideshow-text.container {
                top: 35% !important;
                /* Pindahkan dari 50% ke 35% */
                transform: translate(-50%, -35%) !important;
                padding: 0 15px !important;
                width: 100% !important;
            }

            /* Menyesuaikan ukuran teks */
            .slideshow-text h6.text_dash {
                font-size: 0.8rem !important;
                margin-bottom: 5px !important;
            }

            .slideshow-text h2.h1 {
                font-size: 1.5rem !important;
                line-height: 1.2 !important;
                margin-bottom: 8px !important;
            }

            /* Mengatur posisi gambar */
            .slideshow-character {
                bottom: 0 !important;
                width: 45% !important;
                right: 0 !important;
            }

            .slideshow-character__img {
                max-height: 220px !important;
                object-fit: contain !important;
            }

            /* Pindahkan pagination ke atas sedikit */
            /* .slideshow-pagination.slideshow-number-pagination {
                bottom: 10px !important;
                margin-bottom: 10px !important;
            } */

            /* Mengatur tinggi slide */
            /* .swiper-slide .overflow-hidden {
                height: 420px !important;
            } */
        }
    </style>
    <main>

        <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow"
            data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <div class="overflow-hidden position-relative h-100">
                            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                                <img loading="lazy" src="{{ asset('uploads/slides') }}/{{ $slide->image }}" alt="picture slide"
                                    class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto">

                                <div class="character_markup type2">
                                    <p
                                        class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                                        {{ $slide->tagline }}</p>
                                </div>
                            </div>
                            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                                <h6
                                    class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                                    {{ $slide->tagline }}</h6>
                                <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">
                                    {{ $slide->title }}
                                </h2>
                                <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">
                                    {{ $slide->subtitle }}</h2>
                                <a href="{{ $slide->link }}"
                                    class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">BELANJA
                                    SEKARANG!</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="container">
                <div
                    class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
                </div>
            </div>
        </section>
        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="category-carousel container">
                <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Pilihan untuk Anda</h2>

                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                <div class="swiper-slide">
                                    <img loading="lazy" class="w-100 h-auto mb-3"
                                        src="{{ asset('uploads/categories') }}/{{ $category->image }}" width="124"
                                        height="124" alt="" />
                                    <div class="text-center">
                                        <a href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                            class="menu-link fw-medium">{{ $category->name }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->


                    <div
                        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->
                </div><!-- /.position-relative -->
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="hot-deals container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Penawaran Spesial</h2>
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                        <h2>Untuk Anda!</h2>
                        <h2 class="fw-bold">DISKON Hingga 60%</h2>

                        <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                            data-date="18-3-2024" data-time="06:50">
                            <div class="day countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Days</span>
                            </div>

                            <div class="hour countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Hours</span>
                            </div>

                            <div class="min countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Mins</span>
                            </div>

                            <div class="sec countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Sec</span>
                            </div>
                        </div>

                        <a href="{{ route('shop.index') }}"
                            class="btn-link default-underline text-uppercase fw-medium mt-3">Lihat Semua</a>
                    </div>
                    <div class="col-md-6 col-lg-8 col-xl-80per">
                        <div class="position-relative">
                            <div class="swiper-container js-swiper-slider"
                                data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                                <div class="swiper-wrapper">
                                    @foreach ($sproducts as $sproduct)
                                        {{-- Skip products without discount --}}
                                        @continue($sproduct->sale_price >= $sproduct->regular_price)

                                        <div class="swiper-slide product-card product-card_style3">
                                            <div class="pc__img-wrapper">
                                                <a
                                                    href="{{ route('shop.product.details', ['product_slug' => $sproduct->slug]) }}">
                                                    <img loading="lazy"
                                                        src="{{ asset('uploads/products/' . $sproduct->image) }}"
                                                        width="258" height="313" alt="{{ $sproduct->name }}"
                                                        class="pc__img">

                                                    <img loading="lazy"
                                                        src="{{ asset('uploads/products/' . trim(explode(',', $sproduct->images)[0])) }}"
                                                        width="330" height="400" alt="{{ $sproduct->name }}"
                                                        class="pc__img pc__img-second">
                                                </a>
                                            </div>

                                            <div class="pc__info position-relative">
                                                <h6 class="pc__title">
                                                    <a
                                                        href="{{ route('shop.product.details', ['product_slug' => $sproduct->slug]) }}">
                                                        {{ $sproduct->name }}
                                                    </a>
                                                </h6>

                                                <div class="product-card__price d-flex">
                                                    <span class="money price text-secondary">
                                                        <!-- Harga reguler dicoret -->
                                                        <s>
                                                            Rp{{ number_format($sproduct->regular_price, 0, ',', '.') }}
                                                        </s>
                                                        <!-- Harga jual dengan kelas .sale-price -->
                                                        <span class="text-dark">
                                                            Rp{{ number_format($sproduct->sale_price, 0, ',', '.') }}
                                                        </span>
                                                        <!-- Prosentase dan kata “Diskon” dengan kelas .discount-text -->
                                                        <span class="discount-text">
                                                            {{ round((($sproduct->regular_price - $sproduct->sale_price) * 100) / $sproduct->regular_price) }}%
                                                            DISKON
                                                        </span>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!-- /.swiper-container js-swiper-slider -->
                        </div><!-- /.position-relative -->
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-banner container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto" src="{{ asset('assets/images/shop/shop_banner4.jpg') }}"
                                width="690" height="665" alt="" />
                            <div class="category-banner__item-mark">
                                Harga Spesial Rp 47.000
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">Tas Anyaman Eceng Gondok Samosir</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Beli
                                    Sekarang</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto"
                                src="{{ asset('assets/images/products/produk_topi.jpg') }}" width="690"
                                height="665" alt="" />
                            <div class="category-banner__item-mark">
                                Harga Spesial Rp 50.000
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">Topi Anyaman Eceng Gondok Samosir</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Beli
                                    Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section id="produk-unggulan" class="products-grid container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Produk Unggulan</h2>

                <div class="row">
                    @foreach ($fproducts as $fproduct)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $fproduct->slug]) }}">
                                        <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $fproduct->image }}"
                                            width="330" height="400" alt="{{ $fproduct->name }}" class="pc__img">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a
                                            href="{{ route('shop.product.details', ['product_slug' => $fproduct->slug]) }}">{{ $fproduct->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex align-items-center">
                                        <span class="money price text-secondary">
                                            @if ($fproduct->sale_price && $fproduct->sale_price < $fproduct->regular_price)
                                                {{-- Harga lama dicoret --}}
                                                <s>Rp{{ number_format($fproduct->regular_price, 0, ',', '.') }}</s>
                                                {{-- Harga sale dengan text-dark --}}
                                                <span class="text-dark">
                                                    Rp{{ number_format($fproduct->sale_price, 0, ',', '.') }}
                                                </span>
                                            @else
                                                {{-- Harga reguler (default hitam) --}}
                                                <span class="text-dark">
                                                    Rp{{ number_format($fproduct->regular_price, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.row -->

                <div class="text-center mt-2">
                    <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium"
                        href="{{ route('shop.index') }}">Lihat Lebih
                        Banyak</a>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            @isset($about)
                {{-- Cuplikan Singkat Tentang yang diperindah --}}
                <section class="container mt-5 mb-5 about-snippet">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            @if ($about->image1)
                                <img src="{{ asset($about->image1) }}" alt="Gambar Tentang"
                                    class="img-fluid w-100 h-auto" />
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <h2 class="section-title text-center text-lg-start mb-3">Tentang Bank Koperasi Eceng Gondok Samosir
                            </h2>
                            <p class="text-justify mb-4">
                                {!! \Illuminate\Support\Str::limit(e($about->story), 250) !!}
                            </p>
                            <div class="text-center text-lg-start">
                                <a href="{{ route('user.about.index') }}" class="btn-readmore">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

                {{-- Peta Lokasi --}}
                <section id="lokasi-kami" class="container mt-5">
                    <h2 class="section-title text-center mb-4">Lokasi Kami</h2>
                    <div class="ratio ratio-4x3 rounded shadow-sm" style="max-height:500px; overflow:hidden;">
                        {!! $about->map_embed !!}
                    </div>
                </section>
            @endisset

        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>
@endsection

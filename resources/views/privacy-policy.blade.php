@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">Kebijakan &amp; Privasi</h2>
            </div>
        </section>

        <div class="mb-5 pb-4"></div>

        <!-- Custom CSS for Privacy Policy Page -->
        <style>
            .privacy-section {
                transition: all 0.3s ease;
                border-radius: 8px;
                padding: 25px;
                margin-bottom: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                border-left: 4px solid #8B4513;
                background-color: #fff;
            }

            .privacy-section:hover {
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }

            .privacy-title {
                color: #000;
                font-weight: 600;
                position: relative;
                padding-bottom: 10px;
                margin-bottom: 20px;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .privacy-title::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: 0;
                width: 50px;
                height: 3px;
                background-color: #8B4513;
                transition: width 0.3s ease;
            }

            .privacy-section:hover .privacy-title::after {
                width: 100px;
            }

            .section-content {
                display: none;
                padding-top: 15px;
            }

            .section-content.active {
                display: block;
                animation: fadeIn 0.5s ease;
            }

            .section-content p,
            .section-content li {
                color: #555;
                line-height: 1.8;
            }

            .section-content h4 {
                color: #8B4513;
                margin-top: 20px;
                margin-bottom: 10px;
                font-weight: 500;
            }

            .section-content strong {
                color: #8B4513;
            }

            .section-content a {
                color: #8B4513;
                text-decoration: none;
                border-bottom: 1px dotted #8B4513;
                transition: all 0.3s ease;
            }

            .section-content a:hover {
                color: #5D2906;
                border-bottom: 1px solid #5D2906;
            }

            .toggle-icon {
                font-size: 20px;
                transition: transform 0.3s ease;
            }

            .rotate {
                transform: rotate(180deg);
            }

            .document-link {
                display: inline-block;
                margin: 10px 0;
                padding: 10px 15px;
                background-color: #f9f1ed;
                border-left: 3px solid #8B4513;
                border-radius: 4px;
                transition: all 0.3s ease;
                color: #8B4513;
                text-decoration: none;
                width: 100%;
            }

            .document-link:hover {
                background-color: #f0e0d6;
                transform: translateX(5px);
            }

            .document-link i {
                margin-right: 10px;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .progress-container {
                position: fixed;
                top: 0;
                width: 100%;
                height: 5px;
                z-index: 1000;
            }

            .progress-bar {
                height: 5px;
                background-color: #8B4513;
                width: 0%;
            }

            .contact-method {
                display: flex;
                align-items: center;
                margin: 15px 0;
            }

            .contact-icon {
                width: 40px;
                height: 40px;
                background-color: #f9f1ed;
                color: #8B4513;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 15px;
            }

            .back-to-top {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
                background-color: #8B4513;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: 999;
            }

            .back-to-top.visible {
                opacity: 1;
            }
        </style>

        <!-- Progress Reading Bar -->
        <div class="progress-container">
            <div class="progress-bar" id="myBar"></div>
        </div>

        <!-- Back to Top Button -->
        <div class="back-to-top" id="backToTop">
            <i class="fas fa-arrow-up"></i>
        </div>

        <section class="container mw-930 lh-30">
            <!-- Section 1 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="1">
                    1. Pendahuluan
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content active" id="section1">
                    <p>Selamat datang di Bank Koperasi Eceng Gondok. Kami menghargai privasi Anda dan berkomitmen untuk
                        melindungi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan,
                        menggunakan, menyimpan, dan melindungi data Anda ketika Anda berinteraksi dengan website kami.</p>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="2">
                    2. Definisi
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section2">
                    <ul>
                        <li><strong>"Data Pribadi"</strong> adalah setiap informasi yang dapat diidentifikasi langsung atau
                            tidak langsung kepada Anda.</li>
                        <li><strong>"Pengguna"</strong> adalah orang atau entitas yang mengakses atau menggunakan layanan
                            kami.</li>
                        <li><strong>"Cookie"</strong> adalah berkas kecil yang ditempatkan pada perangkat Anda untuk
                            menyimpan preferensi.</li>
                    </ul>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="3">
                    3. Data yang Kami Kumpulkan
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section3">
                    <h4>a. Data yang Anda Berikan secara Langsung</h4>
                    <ul>
                        <li>Nama lengkap, alamat email, nomor telepon, dan alamat pengiriman.</li>
                        <li>Detail pembayaran (kartu kredit/debit), hanya untuk keperluan transaksi.</li>
                        <li>Dokumen identitas jika diperlukan untuk verifikasi keanggotaan koperasi.</li>
                    </ul>
                    <h4>b. Data yang Dikumpulkan Otomatis</h4>
                    <ul>
                        <li>Alamat IP, jenis perangkat, sistem operasi, dan browser.</li>
                        <li>Log aktivitas pengunjung (halaman yang dikunjungi, waktu kunjungan).</li>
                        <li>Cookie dan teknologi pelacakan sejenis.</li>
                    </ul>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="4">
                    4. Tujuan Penggunaan Data
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section4">
                    <ul>
                        <li><strong>Penyediaan Layanan:</strong> Memproses pesanan, pengiriman, dan layanan purna jual.</li>
                        <li><strong>Komunikasi:</strong> Mengirim notifikasi, penawaran, dan informasi penting terkait akun
                            Anda.</li>
                        <li><strong>Personalisasi:</strong> Menyajikan rekomendasi produk sesuai preferensi Anda.</li>
                        <li><strong>Keamanan:</strong> Mendeteksi dan mencegah aktivitas yang mencurigakan.</li>
                        <li><strong>Analisis dan Pengembangan:</strong> Menganalisis tren penggunaan untuk meningkatkan
                            layanan.</li>
                    </ul>
                </div>
            </div>

            <!-- Section 5 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="5">
                    5. Dasar Hukum Pemrosesan
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section5">
                    <ul>
                        <li>Persetujuan Anda (Pasal 26 UU ITE).</li>
                        <li>Perlaksanaan kontrak (Pasal 28 UU PDP).</li>
                        <li>Kepatuhan terhadap kewajiban hukum (Pasal 29 UU PDP).</li>
                        <li>Interes sah kami (Pasal 30 UU PDP), seperti keamanan dan pengembangan layanan.</li>
                    </ul>
                </div>
            </div>

            <!-- Section 6 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="6">
                    6. Penyimpanan dan Pengamanan Data
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section6">
                    <p>Data Anda disimpan dalam server yang dilengkapi proteksi enkripsi AES-256, akses terbatas, serta
                        sistem firewall dan IDS/IPS. Kami melakukan backup rutin dan review keamanan berkala.</p>
                </div>
            </div>

            <!-- Section 7 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="7">
                    7. Berbagi Data dengan Pihak Ketiga
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section7">
                    <ul>
                        <li><strong>Penyedia Logistik:</strong> Untuk pengiriman barang.</li>
                        <li><strong>Pemroses Pembayaran:</strong> Bank atau payment gateway.</li>
                        <li><strong>Otoritas Hukum:</strong> Jika diwajibkan oleh peraturan perundang‑undangan.</li>
                    </ul>
                </div>
            </div>

            <!-- Section 8 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="8">
                    8. Cookie dan Teknologi Sejenis
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section8">
                    <p>Kami menggunakan cookie untuk mengingat preferensi, menganalisis trafik, dan menampilkan iklan yang
                        relevan. Anda dapat menolak cookie melalui pengaturan browser, namun beberapa fitur mungkin tidak
                        berfungsi optimal.</p>
                </div>
            </div>

            <!-- Section 9 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="9">
                    9. Hak Anda atas Data Pribadi
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section9">
                    <ul>
                        <li><strong>Akses:</strong> Meminta salinan data pribadi Anda.</li>
                        <li><strong>Perbaikan:</strong> Memperbaiki data yang tidak akurat atau tidak lengkap.</li>
                        <li><strong>Penghapusan:</strong> Mengajukan penghapusan data (right to be forgotten).</li>
                        <li><strong>Penolakan:</strong> Menolak pemrosesan berdasarkan kepentingan sah.</li>
                        <li><strong>Pembatasan:</strong> Membatasi pemrosesan data tertentu.</li>
                        <li><strong>Portabilitas:</strong> Meminta ekspor data dalam format terstruktur.</li>
                    </ul>
                    <p>Untuk mengajukan hak di atas, silakan hubungi kami melalui WhatsApp di <a
                            href="https://wa.me/6281376809200">+62 813-7680-9200</a>.</p>
                </div>
            </div>

            <!-- Section 10 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="10">
                    10. Perubahan Kebijakan
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section10">
                    <p>Kami dapat memperbarui Kebijakan &amp; Privasi ini dari waktu ke waktu. Setiap perubahan akan
                        diumumkan di halaman ini dengan tanggal berlaku terbaru.</p>
                </div>
            </div>

            <!-- Section 11 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="11">
                    11. Kontak
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section11">
                    <p>Apabila Anda memiliki pertanyaan atau keluhan terkait Kebijakan &amp; Privasi, silakan menghubungi
                        kami:</p>

                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <strong>WhatsApp:</strong>
                                <a href="https://wa.me/6281376809200">+62 813-7680-9200</a>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <div>
                                <strong>Instagram:</strong>
                                <a href="https://www.instagram.com/bank_ecenggondok/" target="_blank">bank_ecenggondok</a>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="far fa-envelope"></i>
                            </div>
                            <div>
                                <strong>Email:</strong>
                                privacy@bankecenggondok.co.id
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 12 -->
            <div class="privacy-section">
                <h3 class="privacy-title" data-section="12">
                    12. Lampiran Dokumen
                    <span class="toggle-icon">▼</span>
                </h3>
                <div class="section-content" id="section12">
                    <p>Berikut dokumen terkait yang dapat Anda unduh:</p>

                    <a href="{{ asset('docs/Form_Permohonan_Hapus_Data.pdf') }}" target="_blank" class="document-link">
                        <i class="far fa-file-pdf"></i> Form Permohonan Penghapusan Data
                    </a>

                    <a href="{{ asset('docs/Pernyataan_Persetujuan_Pemrosesan_Data.pdf') }}" target="_blank"
                        class="document-link">
                        <i class="far fa-file-pdf"></i> Pernyataan Persetujuan Pemrosesan Data
                    </a>

                    <a href="{{ asset('docs/Kebijakan_Cookie.pdf') }}" target="_blank" class="document-link">
                        <i class="far fa-file-pdf"></i> Kebijakan Cookie Lengkap
                    </a>

                    <a href="{{ asset('docs/Perjanjian_DPIA.pdf') }}" target="_blank" class="document-link">
                        <i class="far fa-file-pdf"></i> Data Protection Impact Assessment (DPIA)
                    </a>
                </div>
            </div>
        </section>

        <!-- JavaScript for Interactivity -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add Font Awesome for icons
                if (!document.getElementById('fontawesome-css')) {
                    const fontAwesome = document.createElement('link');
                    fontAwesome.id = 'fontawesome-css';
                    fontAwesome.rel = 'stylesheet';
                    fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
                    document.head.appendChild(fontAwesome);
                }

                // Toggle sections
                const titles = document.querySelectorAll('.privacy-title');
                titles.forEach(title => {
                    title.addEventListener('click', function() {
                        const sectionId = 'section' + this.getAttribute('data-section');
                        const content = document.getElementById(sectionId);
                        const icon = this.querySelector('.toggle-icon');

                        content.classList.toggle('active');
                        icon.classList.toggle('rotate');
                    });
                });

                // Progress bar
                window.onscroll = function() {
                    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    const scrolled = (winScroll / height) * 100;
                    document.getElementById("myBar").style.width = scrolled + "%";

                    // Back to top button
                    const backToTop = document.getElementById('backToTop');
                    if (winScroll > 300) {
                        backToTop.classList.add('visible');
                    } else {
                        backToTop.classList.remove('visible');
                    }
                };

                // Back to top functionality
                document.getElementById('backToTop').addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                // Open first section by default
                document.getElementById('section1').classList.add('active');
            });
        </script>
    </main>
@endsection

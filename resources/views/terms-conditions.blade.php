@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">Syarat & Ketentuan</h2>
            </div>
        </section>

        <div class="mb-5 pb-4"></div>
        <section class="container mw-930 lh-30 terms-section">
            <!-- Introduction Card -->
            <div class="card shadow-sm mb-5 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-handshake text-primary me-3 fa-2x"></i>
                        <h3 class="mb-0">Syarat & Ketentuan</h3>
                    </div>
                    <p class="lead">Dengan mengakses dan menggunakan layanan Bank Koperasi Eceng Gondok ("Kami"), Anda ("Pengguna") secara otomatis menyetujui dan terikat oleh Syarat & Ketentuan yang tercantum di bawah ini. Pastikan Anda telah membaca, memahami, dan menyetujui semua ketentuan sebelum menggunakan layanan Kami.</p>
                </div>
            </div>

            <!-- Accordion for Terms -->
            <div class="accordion" id="termsAccordion">
                <!-- Item 1 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading1">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            <i class="fas fa-check-circle text-primary me-2"></i> 1. Penerimaan Ketentuan
                        </button>
                    </h4>
                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Dengan menggunakan layanan Kami, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui untuk terikat oleh Syarat & Ketentuan ini. Jika Anda tidak setuju dengan ketentuan ini, Anda tidak diperbolehkan menggunakan layanan Kami.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <i class="fas fa-file-contract text-primary me-2"></i> 2. Pembentukan Kontrak
                        </button>
                    </h4>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Setiap transaksi yang terjadi melalui layanan Kami merupakan kontrak yang sah antara Pengguna dan Bank Koperasi Eceng Gondok. Dengan menyelesaikan proses pendaftaran atau transaksi, Pengguna dianggap telah memberikan persetujuan untuk terikat oleh kontrak ini.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading3">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <i class="fas fa-user-shield text-primary me-2"></i> 3. Hak dan Kewajiban Pengguna
                        </button>
                    </h4>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-start border-primary border-3 shadow-sm mb-3 mb-md-0">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Pengguna berhak untuk:</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-angle-right text-primary me-2"></i>Menggunakan layanan Kami sesuai dengan ketentuan yang telah ditetapkan</li>
                                                <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-angle-right text-primary me-2"></i>Menerima informasi tentang layanan, promosi, dan update</li>
                                                <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-angle-right text-primary me-2"></i>Mengajukan pertanyaan atau keluhan melalui saluran resmi</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-start border-primary border-3 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Pengguna wajib untuk:</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-angle-right text-primary me-2"></i>Memberikan informasi yang benar, akurat, dan lengkap</li>
                                                <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-angle-right text-primary me-2"></i>Menggunakan layanan Kami untuk tujuan yang sah dan tidak melanggar hukum</li>
                                                <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-angle-right text-primary me-2"></i>Mematuhi semua ketentuan yang berlaku</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <i class="fas fa-building text-primary me-2"></i> 4. Tanggung Jawab Bank
                        </button>
                    </h4>
                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p>Bank Koperasi Eceng Gondok bertanggung jawab untuk:</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-shield-alt text-primary me-2"></i>Memberikan layanan yang profesional dan sesuai dengan standar</li>
                                        <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-lock text-primary me-2"></i>Memastikan keamanan transaksi dan data Pengguna</li>
                                        <li class="list-group-item bg-transparent border-0 ps-0"><i class="fas fa-info-circle text-primary me-2"></i>Memberikan informasi yang jelas dan akurat tentang layanan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <i class="fas fa-credit-card text-primary me-2"></i> 5. Kebijakan Pembayaran
                        </button>
                    </h4>
                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Kami menerima pembayaran melalui berbagai metode, termasuk:</p>
                            <div class="row text-center mb-3">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="card h-100 border-0 shadow-sm transition-hover">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <i class="fas fa-university text-primary fa-3x mb-3"></i>
                                            <h5 class="card-title">Transfer Bank</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="card h-100 border-0 shadow-sm transition-hover">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <i class="fas fa-store text-primary fa-3x mb-3"></i>
                                            <h5 class="card-title">Gerai Retail</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm transition-hover">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <i class="fas fa-wallet text-primary fa-3x mb-3"></i>
                                            <h5 class="card-title">Dompet Digital</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>Setiap transaksi harus dilakukan sesuai dengan prosedur yang telah ditetapkan. Bank Koperasi Eceng Gondok tidak bertanggung jawab atas kerugian yang timbul akibat kesalahan dalam melakukan pembayaran.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading6">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            <i class="fas fa-exchange-alt text-primary me-2"></i> 6. Kebijakan Pengembalian dan Penggantian
                        </button>
                    </h4>
                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Pengembalian dan penggantian barang atau jasa dapat dilakukan sesuai dengan kebijakan yang berlaku. Pengguna wajib mengajukan permohonan pengembalian atau penggantian dalam waktu yang telah ditentukan.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 7 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading7">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            <i class="fas fa-shield-alt text-primary me-2"></i> 7. Kebijakan Keamanan
                        </button>
                    </h4>
                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Kami menggunakan teknologi keamanan yang memadai untuk melindungi data dan transaksi Pengguna. Namun, Kami tidak bertanggung jawab atas kerugian yang timbul akibat tindakan Pengguna yang tidak sesuai dengan prosedur keamanan yang telah ditetapkan.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 8 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading8">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            <i class="fas fa-sync-alt text-primary me-2"></i> 8. Perubahan Ketentuan
                        </button>
                    </h4>
                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Kami berhak untuk memperbarui Syarat & Ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Perubahan akan berlaku efektif pada tanggal yang ditentukan dalam versi terbaru Syarat & Ketentuan.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 9 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading9">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            <i class="fas fa-gavel text-primary me-2"></i> 9. Penyelesaian Sengketa
                        </button>
                    </h4>
                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Setiap sengketa yang timbul akibat penggunaan layanan Kami akan diselesaikan melalui musyawarah untuk mencapai mufakat. Jika tidak tercapai kesepakatan, sengketa akan diselesaikan melalui instansi peradilan yang berwenang.</p>
                        </div>
                    </div>
                </div>

                <!-- Item 10 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading10">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            <i class="fas fa-phone-alt text-primary me-2"></i> 10. Kontak Kami
                        </button>
                    </h4>
                    <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Jika Anda memiliki pertanyaan atau kekhawatiran tentang Syarat & Ketentuan ini, silakan hubungi Kami:</p>
                            <div class="row mt-4">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="card border-0 shadow-sm h-100 text-center transition-hover">
                                        <div class="card-body">
                                            <i class="fab fa-whatsapp text-primary fa-3x mb-3"></i>
                                            <h5>WhatsApp</h5>
                                            <p class="mb-0"><a href="https://wa.me/+6281376809200" class="text-primary text-decoration-none">+62 813-7680-9200</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="card border-0 shadow-sm h-100 text-center transition-hover">
                                        <div class="card-body">
                                            <i class="fab fa-instagram text-primary fa-3x mb-3"></i>
                                            <h5>Instagram</h5>
                                            <p class="mb-0"><a href="https://www.instagram.com/bank_ecenggondok/" class="text-primary text-decoration-none">@bank_ecenggondok</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100 text-center transition-hover">
                                        <div class="card-body">
                                            <i class="fas fa-envelope text-primary fa-3x mb-3"></i>
                                            <h5>Email</h5>
                                            <p class="mb-0">[masukkan alamat email resmi]</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <a href="#" class="btn btn-outline-primary"><i class="fas fa-download me-2"></i>Unduh versi PDF</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 11 -->
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h4 class="accordion-header" id="heading11">
                        <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            <i class="fas fa-check text-primary me-2"></i> 11. Persetujuan
                        </button>
                    </h4>
                    <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>Dengan menggunakan layanan Kami, Anda memberikan persetujuan kepada Kami untuk mematuhi dan terikat oleh Syarat & Ketentuan ini.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Call to action -->
            <div class="card border-0 shadow-sm bg-light mt-5 text-center">
                <div class="card-body p-4">
                    <h5 class="mb-3">Sudah membaca Syarat & Ketentuan?</h5>
                    <button class="btn btn-primary me-2" id="agreeButton"><i class="fas fa-check-circle me-2"></i>Saya Setuju</button>
                    <a href="#" class="btn btn-outline-secondary"><i class="fas fa-question-circle me-2"></i>Punya Pertanyaan?</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        .terms-section {
            color: #333;
        }

        .page-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .page-title:after {
            content: "";
            position: absolute;
            width: 60%;
            height: 3px;
            background-color: #6c757d;
            bottom: -10px;
            left: 0;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #0d6efd;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }

        .accordion-item {
            border-radius: 8px !important;
            overflow: hidden;
        }

        .transition-hover {
            transition: all 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        }

        .text-primary {
            color: #6a3515 !important; /* Brown color for the primary text */
        }

        .btn-primary, .bg-primary, .border-primary {
            background-color: #6a3515 !important; /* Brown color for buttons and backgrounds */
            border-color: #6a3515 !important;
        }

        .btn-outline-primary {
            color: #6a3515 !important;
            border-color: #6a3515 !important;
        }

        .btn-outline-primary:hover {
            background-color: #6a3515 !important;
            color: #fff !important;
        }

        /* Animation for the accordion */
        .accordion-button {
            transition: all 0.3s ease;
        }

        .accordion-button:hover {
            background-color: #f8f9fa;
        }

        /* Custom animation for the active accordion item */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(106, 53, 21, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(106, 53, 21, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(106, 53, 21, 0);
            }
        }

        .accordion-button:not(.collapsed) {
            animation: pulse 1.5s infinite;
        }
    </style>

    <!-- Simple JavaScript for interaction -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open the first accordion item by default
            document.querySelector('#collapse1').classList.add('show');
            document.querySelector('#heading1 .accordion-button').classList.remove('collapsed');
            document.querySelector('#heading1 .accordion-button').setAttribute('aria-expanded', 'true');

            // Smooth scroll to sections when clicking links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add animation when agreeing to terms
            const agreeButton = document.getElementById('agreeButton');
            if (agreeButton) {
                agreeButton.addEventListener('click', function() {
                    this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Terima Kasih!';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    setTimeout(() => {
                        alert('Terima kasih telah menyetujui Syarat & Ketentuan kami!');
                    }, 500);
                });
            }
        });
    </script>
@endsection

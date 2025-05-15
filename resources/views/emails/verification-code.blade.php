<!DOCTYPE html>
<html>
<head>
    <title>Kode Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .container {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 6px;
            color: #3490dc;
            margin: 20px 0;
            padding: 10px;
            background-color: #f8fafc;
            border-radius: 5px;
        }
        .expiry {
            text-align: center;
            font-style: italic;
            color: #e3342f;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Kode Verifikasi Email</h2>
        </div>

        <p>Halo <strong>{{ $name }}</strong>,</p>

        <p>Terima kasih telah mendaftar di website kami. Untuk melanjutkan proses pendaftaran, silakan masukkan kode verifikasi berikut:</p>

        <div class="code">{{ $token }}</div>

        <p class="expiry">Kode verifikasi ini akan kedaluwarsa pada: {{ $expiresAt->format('d M Y H:i') }} WIB</p>

        <p>Jika Anda tidak mengajukan pendaftaran ini, silakan abaikan email ini.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Bank Koperasi Eceng Gondok. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis, mohon untuk tidak membalas.</p>
        </div>
    </div>
</body>
</html>

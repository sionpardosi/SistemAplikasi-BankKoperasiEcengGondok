<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Posisi Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        h2, h3 { text-align: center; margin: 4px 0; }
        .sub { text-align: center; color: #666; font-size: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        .section-header td { background: #f0f0f0; font-weight: bold; padding: 6px 12px; }
        td { padding: 6px 12px; border-bottom: 1px solid #eee; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .grand-total td { background: #d4edda; font-weight: bold;
                          font-size: 14px; border-top: 3px solid #333; }
        .text-right { text-align: right; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 30px; }
    </style>
</head>
<body>
    <h2>UMKM Lettes Eceng Gondok</h2>
    <h3>Laporan Posisi Keuangan</h3>
    <div class="sub">Per Tanggal {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</div>

    <table>
        <tr class="section-header"><td colspan="2">ASET</td></tr>
        <tr><td>Kas</td>
            <td class="text-right">Rp {{ number_format($kas,0,',','.') }}</td></tr>
        <tr><td>Piutang Usaha</td>
            <td class="text-right">Rp {{ number_format($piutangUsaha,0,',','.') }}</td></tr>
        <tr><td>Persediaan Bahan Baku</td>
            <td class="text-right">Rp {{ number_format($persediaanBahanBaku,0,',','.') }}</td></tr>
        <tr class="total-row"><td>Total Aset</td>
            <td class="text-right">Rp {{ number_format($totalAset,0,',','.') }}</td></tr>

        <tr style="height:8px"><td colspan="2"></td></tr>
        <tr class="section-header"><td colspan="2">LIABILITAS</td></tr>
        <tr><td>Utang Usaha</td>
            <td class="text-right">Rp {{ number_format($utangUsaha,0,',','.') }}</td></tr>
        <tr class="total-row"><td>Total Liabilitas</td>
            <td class="text-right">Rp {{ number_format($totalLiabilitas,0,',','.') }}</td></tr>

        <tr style="height:8px"><td colspan="2"></td></tr>
        <tr class="section-header"><td colspan="2">EKUITAS</td></tr>
        <tr><td>Modal Pemilik</td>
            <td class="text-right">Rp {{ number_format($modalPemilik,0,',','.') }}</td></tr>
        <tr><td>Laba Ditahan</td>
            <td class="text-right">Rp {{ number_format($labaDitahan,0,',','.') }}</td></tr>
        <tr><td>Laba Berjalan</td>
            <td class="text-right">Rp {{ number_format($labaBerjalan,0,',','.') }}</td></tr>
        <tr class="total-row"><td>Total Ekuitas</td>
            <td class="text-right">Rp {{ number_format($totalEkuitas,0,',','.') }}</td></tr>

        <tr style="height:8px"><td colspan="2"></td></tr>
        <tr class="grand-total">
            <td>TOTAL LIABILITAS + EKUITAS</td>
            <td class="text-right">Rp {{ number_format($totalLiabilitasEkuitas,0,',','.') }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y, H:i') }} WIB | Berdasarkan SAK EMKM
    </div>
</body>
</html>

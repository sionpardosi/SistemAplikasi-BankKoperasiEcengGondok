<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        h2, h3 { text-align: center; margin: 4px 0; }
        .sub { text-align: center; color: #666; font-size: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2377FC; color: #fff; padding: 7px 12px; text-align: left; }
        td { padding: 6px 12px; border-bottom: 1px solid #eee; }
        .section-header td { background: #f0f0f0; font-weight: bold; padding: 6px 12px; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .laba-row td { background: #d4edda; font-weight: bold; font-size: 14px; border-top: 3px solid #333; }
        .rugi-row td { background: #f8d7da; font-weight: bold; font-size: 14px; border-top: 3px solid #333; }
        .text-right { text-align: right; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 30px; }
    </style>
</head>
<body>
    <h2>UMKM Lettes Eceng Gondok</h2>
    <h3>Laporan Laba Rugi</h3>
    <div class="sub">
        Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }}
        s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}
    </div>

    <table>
        <tr class="section-header"><td colspan="2">PENDAPATAN</td></tr>
        <tr><td>Pendapatan Penjualan Online</td>
            <td class="text-right">Rp {{ number_format($pendapatanOnline, 0, ',', '.') }}</td></tr>
        <tr><td>Pendapatan Penjualan Offline</td>
            <td class="text-right">Rp {{ number_format($pendapatanOffline, 0, ',', '.') }}</td></tr>
        <tr class="total-row"><td>Total Pendapatan</td>
            <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td></tr>

        <tr style="height:10px"><td colspan="2"></td></tr>
        <tr class="section-header"><td colspan="2">BEBAN USAHA</td></tr>
        <tr><td>Beban Bahan Baku</td>
            <td class="text-right">Rp {{ number_format($bebanBahanBaku, 0, ',', '.') }}</td></tr>
        <tr><td>Beban Operasional</td>
            <td class="text-right">Rp {{ number_format($bebanOperasional, 0, ',', '.') }}</td></tr>
        <tr><td>Beban Lain-lain</td>
            <td class="text-right">Rp {{ number_format($bebanLainLain, 0, ',', '.') }}</td></tr>
        <tr class="total-row"><td>Total Beban</td>
            <td class="text-right">Rp {{ number_format($totalBeban, 0, ',', '.') }}</td></tr>

        <tr style="height:10px"><td colspan="2"></td></tr>
        <tr class="{{ $labaBersih >= 0 ? 'laba-row' : 'rugi-row' }}">
            <td>{{ $labaBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}</td>
            <td class="text-right">Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y, H:i') }} WIB | Berdasarkan SAK EMKM
    </div>
</body>
</html>

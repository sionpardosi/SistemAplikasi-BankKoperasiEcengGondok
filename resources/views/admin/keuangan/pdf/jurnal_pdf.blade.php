<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jurnal Umum — UMKM Lettes Eceng Gondok</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            background: #fff;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            padding-bottom: 14px;
            border-bottom: 2px solid #1e293b;
            margin-bottom: 12px;
        }

        .header .org-name {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: .5px;
        }

        .header .doc-title {
            font-size: 12px;
            font-weight: bold;
            color: #2377FC;
            margin-top: 3px;
        }

        .header .period {
            font-size: 9.5px;
            color: #64748b;
            margin-top: 3px;
        }

        .header .sak-note {
            display: inline-block;
            margin-top: 5px;
            font-size: 8.5px;
            color: #64748b;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 2px 8px;
        }

        /* ===== SUMMARY BAR ===== */
        .summary-bar {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }

        .summary-cell {
            display: table-cell;
            text-align: center;
            padding: 7px 10px;
            border-right: 1px solid #e2e8f0;
            width: 25%;
        }

        .summary-cell:last-child {
            border-right: none;
        }

        .summary-cell .s-label {
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .5px;
            display: block;
        }

        .summary-cell .s-value {
            font-size: 10px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 2px;
            display: block;
        }

        .summary-cell.s-debit .s-value {
            color: #1d4ed8;
        }

        .summary-cell.s-kredit .s-value {
            color: #059669;
        }

        .summary-cell.s-balance-ok {
            background: #f0fdf4;
        }

        .summary-cell.s-balance-fail {
            background: #fff7ed;
        }

        .summary-cell.s-balance-ok .s-value {
            color: #16a34a;
        }

        .summary-cell.s-balance-fail .s-value {
            color: #ea580c;
        }

        /* ===== TABLE ===== */
        table.jurnal {
            width: 100%;
            border-collapse: collapse;
        }

        /* Kolom lebar fixed */
        col.c-tgl {
            width: 68px;
        }

        col.c-no {
            width: 110px;
        }

        col.c-ket {
            width: auto;
        }

        col.c-src {
            width: 50px;
        }

        col.c-dbt {
            width: 96px;
        }

        col.c-krd {
            width: 96px;
        }

        table.jurnal thead tr {
            background: #1e293b;
        }

        table.jurnal thead th {
            padding: 7px 8px;
            font-size: 8.5px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: none;
        }

        table.jurnal thead th.text-right {
            text-align: right;
        }

        table.jurnal thead th.text-center {
            text-align: center;
        }

        /* Row header jurnal */
        tr.row-hdr td {
            background: #f8fafc;
            border-top: 1.5px solid #cbd5e1;
            border-bottom: 1px solid #e2e8f0;
            padding: 6px 8px;
            vertical-align: middle;
        }

        tr.row-hdr:first-of-type td {
            border-top: none;
        }

        .no-jurnal {
            font-family: monospace;
            font-size: 9px;
            font-weight: bold;
            color: #2377FC;
        }

        .ket-text {
            font-size: 9.5px;
            font-weight: bold;
            color: #1e293b;
        }

        .badge-online {
            color: #1d4ed8;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-offline {
            color: #15803d;
            font-size: 8px;
            font-weight: bold;
        }

        /* Row detail akun */
        tr.row-det td {
            background: #fff;
            padding: 4px 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .akun-debit {
            font-size: 9px;
            color: #374151;
            padding-left: 8px !important;
            border-left: 2px solid #2377FC;
        }

        .akun-kredit {
            font-size: 9px;
            color: #374151;
            padding-left: 8px !important;
            border-left: 2px solid #10b981;
            margin-left: 16px;
        }

        .akun-kode {
            font-weight: bold;
            color: #94a3b8;
        }

        /* Nominal */
        td.num {
            text-align: right;
            font-size: 9.5px;
            font-weight: 600;
            white-space: nowrap;
            padding-right: 10px !important;
        }

        td.num-debit {
            color: #1d4ed8;
        }

        td.num-kredit {
            color: #059669;
        }

        /* Footer */
        tfoot tr td {
            background: #1e293b;
            color: #f1f5f9;
            font-size: 9.5px;
            font-weight: bold;
            padding: 8px 8px;
        }

        tfoot td.lbl {
            text-align: right;
            color: #94a3b8;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        tfoot td.ttl-d {
            text-align: right;
            color: #93c5fd;
            padding-right: 10px !important;
        }

        tfoot td.ttl-k {
            text-align: right;
            color: #6ee7b7;
            padding-right: 10px !important;
        }

        /* Unbalanced warning */
        .unbalanced {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-top: none;
            padding: 6px 10px;
            color: #9a3412;
            font-size: 9px;
            font-weight: bold;
        }

        /* ===== FOOTER ===== */
        .doc-footer {
            margin-top: 18px;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            display: table;
            width: 100%;
        }

        .doc-footer .left {
            display: table-cell;
            font-size: 8.5px;
            color: #94a3b8;
        }

        .doc-footer .right {
            display: table-cell;
            text-align: right;
            font-size: 8.5px;
            color: #94a3b8;
        }
    </style>
</head>

<body>

    {{-- ===== HEADER ===== --}}
    <div class="header">
        <div class="org-name">UMKM LETTES ECENG GONDOK</div>
        <div class="doc-title">JURNAL UMUM</div>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM YYYY') }}
            sampai dengan {{ \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM YYYY') }}
        </div>
        <span class="sak-note">Berdasarkan SAK EMKM (Standar Akuntansi Keuangan EMKM)</span>
    </div>

    {{-- ===== SUMMARY BAR ===== --}}
    <div class="summary-bar">
        <div class="summary-cell">
            <span class="s-label">Jumlah Entri</span>
            <span class="s-value">{{ $jurnals->count() }}</span>
        </div>
        <div class="summary-cell s-debit">
            <span class="s-label">Total Debit</span>
            <span class="s-value">Rp {{ number_format($totalDebit, 0, ',', '.') }}</span>
        </div>
        <div class="summary-cell s-kredit">
            <span class="s-label">Total Kredit</span>
            <span class="s-value">Rp {{ number_format($totalKredit, 0, ',', '.') }}</span>
        </div>
        @php $balanced = round($totalDebit, 2) === round($totalKredit, 2); @endphp
        <div class="summary-cell {{ $balanced ? 's-balance-ok' : 's-balance-fail' }}">
            <span class="s-label">Status</span>
            <span class="s-value">{{ $balanced ? '✓ Balanced' : '⚠ Tidak Balance' }}</span>
        </div>
    </div>

    {{-- ===== TABEL ===== --}}
    <table class="jurnal">
        <colgroup>
            <col class="c-tgl">
            <col class="c-no">
            <col class="c-ket">
            <col class="c-src">
            <col class="c-dbt">
            <col class="c-krd">
        </colgroup>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Jurnal</th>
                <th>Keterangan / Akun</th>
                <th class="text-center">Sumber</th>
                <th class="text-right">Debit (Rp)</th>
                <th class="text-right">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $jurnal)

                {{-- Header Jurnal --}}
                <tr class="row-hdr">
                    <td style="font-size:9.5px; font-weight:600; color:#374151; white-space:nowrap">
                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}
                    </td>
                    <td><span class="no-jurnal">{{ $jurnal->no_jurnal }}</span></td>
                    <td colspan="2"><span class="ket-text">{{ $jurnal->keterangan }}</span></td>
                    <td class="num" style="color:#64748b; font-size:8.5px">
                        <span class="{{ $jurnal->sumber === 'online' ? 'badge-online' : 'badge-offline' }}">
                            {{ strtoupper($jurnal->sumber) }}
                        </span>
                    </td>
                    <td></td>
                </tr>

                {{-- Detail Lines --}}
                @foreach ($jurnal->lines->sortBy(fn($l) => $l->posisi === 'debit' ? 0 : 1) as $line)
                    <tr class="row-det">
                        <td></td>
                        <td></td>
                        <td style="{{ $line->posisi === 'kredit' ? 'padding-left:24px!important' : '' }}">
                            @if ($line->posisi === 'debit')
                                <span class="akun-debit">
                                    <span class="akun-kode">{{ $line->account->kode ?? '' }}</span>
                                    — {{ $line->account->nama ?? '-' }}
                                </span>
                            @else
                                <span class="akun-kredit">
                                    <span class="akun-kode">{{ $line->account->kode ?? '' }}</span>
                                    — {{ $line->account->nama ?? '-' }}
                                </span>
                            @endif
                        </td>
                        <td></td>
                        <td class="num {{ $line->posisi === 'debit' ? 'num-debit' : '' }}">
                            @if ($line->posisi === 'debit')
                                {{ number_format($line->jumlah, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="num {{ $line->posisi === 'kredit' ? 'num-kredit' : '' }}">
                            @if ($line->posisi === 'kredit')
                                {{ number_format($line->jumlah, 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                @endforeach

            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:24px; color:#94a3b8; font-size:10px">
                        Tidak ada jurnal pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="lbl">TOTAL PERIODE</td>
                <td class="ttl-d">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                <td class="ttl-k">{{ number_format($totalKredit, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if (!$balanced)
        <div class="unbalanced">
            ⚠ Perhatian: Total debit dan kredit tidak seimbang.
            Selisih: Rp {{ number_format(abs($totalDebit - $totalKredit), 0, ',', '.') }}
        </div>
    @endif

    {{-- ===== FOOTER ===== --}}
    <div class="doc-footer">
        <div class="left">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
        <div class="right">Sistem Informasi Akuntansi — UMKM Lettes Eceng Gondok &nbsp;|&nbsp; SAK EMKM</div>
    </div>

</body>

</html>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Logbook BSI</title>
    <style>
        /* Reset Dasar */
        body { font-family: sans-serif; font-size: 12px; color: #333; }

        /* Kop Surat */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #00a39e; /* Garis bawah warna BSI */
            padding-bottom: 15px;
        }
        .logo {
            max-height: 70px;
            margin-bottom: 10px;
        }
        .title { font-size: 18px; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .subtitle { font-size: 14px; margin: 0; font-weight: normal; }
        .period { font-style: italic; color: #666; margin-top: 5px; }

        /* Tabel Data */
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td {
            border: 1px solid #000; /* Border hitam tegas untuk print */
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #00a39e; /* Header Tabel Warna BSI */
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        .table tr:nth-child(even) { background-color: #f9f9f9; } /* Zebra striping */

        /* Status Badge Text */
        .status-selesai { color: #198754; font-weight: bold; }
        .status-aktif { color: #dc3545; font-weight: bold; }

        /* Footer Halaman */
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            font-size: 10px;
            text-align: right;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/img/logo-bsi.png') }}" class="logo" alt="Logo BSI">

        <div class="title">Laporan Kunjungan Ruang Server</div>
        <div class="subtitle">Bank Syariah Indonesia KCP Bandung Kopo</div>
        <div class="period">Periode Data: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="15%">Jam</th>
                <th width="20%">Nama Tamu</th>
                <th width="20%">Instansi</th>
                <th width="20%">Tujuan</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $log)
            <tr>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($log->check_in)->format('d/m/Y') }}</td>
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($log->check_in)->format('H:i') }} -
                    {{ $log->check_out ? \Carbon\Carbon::parse($log->check_out)->format('H:i') : '...' }}
                </td>
                <td>{{ $log->guest->name }}</td>
                <td>{{ $log->guest->institution }}</td>
                <td>{{ $log->purpose->name }}</td>
                <td style="text-align: center;">
                    @if($log->status == 'Selesai')
                        <span class="status-selesai">Selesai</span>
                    @else
                        <span class="status-aktif">Aktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data kunjungan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem Logbook Digital pada {{ date('d F Y H:i') }}
    </div>
</body>
</html>

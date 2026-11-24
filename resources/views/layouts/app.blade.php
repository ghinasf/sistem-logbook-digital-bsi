<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Logbook Digital - BSI KCP Bandung Kopo</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-bsi.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Warna Identitas BSI */
        .bsi-color { color: #00a39e; }
        .bg-bsi { background-color: #00a39e; }

        .btn-bsi {
            background-color: #00a39e;
            color: white;
            border: none;
        }
        .btn-bsi:hover {
            background-color: #008f8a;
            color: white;
        }

        /* Efek Kartu */
        .card-shadow {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: none;
            border-radius: 10px;
        }

        /* Spacing Text */
        .spacing-2 { letter-spacing: 2px; }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo-bsi.png') }}" alt="Logo BSI" style="max-height: 80px;" class="mb-2">

            <h4 class="fw-bold text-secondary mb-0" style="letter-spacing: 1px;">SISTEM LOGBOOK DIGITAL</h4>
            <p class="text-muted small">Ruang Server BSI KCP Bandung Kopo</p>
        </div>

        @yield('content')

        <div class="text-center mt-5 text-muted small">
            &copy; {{ date('Y') }} Bank Syariah Indonesia KCP Bandung Kopo
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin-top: 190px;
            margin-left: 60px;
            margin-right: 60px;
            margin-bottom: 0px;
        }

        body {
            font-family: "Helvetica", sans-serif;
            line-height: 1.55;
            font-size: 13px;
            text-align: justify;
            position: relative;
        }

        .background {
            position: fixed;
            top: -190px;
            left: -60px;
            right: -60px;
            bottom: 0px;
            z-index: -1;
        }

        .background img {
            width: 100%;
            height: 100%;
        }

        main {
            padding-bottom: 120px;
        }

        .fecha {
            text-align: right;
            font-size: 13px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        h1 {
            font-family: sans-serif !important;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 25px;
            letter-spacing: 0.2px;
            color: #000;
        }

        h2 {
            font-size: 15px;
            font-weight: 700;
            margin-top: 28px;
            margin-bottom: 10px;
            color: #09B451;
            border-bottom: none !important;
        }

        h3 {
            font-size: 14px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 6px;
            color: #000;
        }

        p {
            margin-bottom: 10px;
        }

        ul,
        ol {
            margin: 8px 0 12px 20px;
        }

        hr {
            border: none !important;
            height: 0;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }

        table thead {
            background: #09B451;
            color: white;
            font-weight: bold;
        }

        table th,
        table td {
            border: 1px solid #cccccc;
            padding: 6px 8px;
            text-align: left;
        }

        table tbody tr:nth-child(even) {
            background: #f5f5f5;
        }
    </style>

</head>

<body>

    <div class="background">
        <img src="{{ public_path('imgs/membrete.png') }}" />
    </div>

    <main>

        <div class="fecha">
            @php \Carbon\Carbon::setLocale('es'); @endphp
            Neiva, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
        </div>

        <h1>Informe Inteligente – Portal EGRESADOS 360</h1>

        {!! $contenido !!}

    </main>

</body>

</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Inteligente - Egresados 360</title>

    <style>
        @page {
            margin: 80px 60px;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            font-size: 13px;
            line-height: 1.6;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            border-bottom: 2px solid #09B451;
        }

        header img {
            height: 45px;
            margin-top: 5px;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }

        h1, h2, h3 {
            color: #333;
            font-weight: bold;
        }

        h1 {
            font-size: 20px;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        h2 {
            font-size: 16px;
            margin-top: 25px;
            margin-bottom: 8px;
            border-bottom: 1px solid #09B451;
            padding-bottom: 4px;
        }

        h3 {
            font-size: 14px;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        p {
            text-align: justify;
            margin-bottom: 8px;
        }

        ul {
            margin-left: 25px;
            margin-bottom: 10px;
        }

        b, strong {
            color: #000;
        }

        .contenido {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('logo.png') }}" alt="Fundación Escuela Tecnológica de Neiva">
    </header>

    <footer>
        Portal Egresados 360 — Fundación Escuela Tecnológica de Neiva "Jesús Oviedo Pérez"  
        <br>Informe generado el {{ $fecha }}
    </footer>

    <main class="contenido">
        <h1>Informe Inteligente del Portal Egresados 360</h1>
        <div>{!! $contenido !!}</div>
    </main>
</body>
</html>

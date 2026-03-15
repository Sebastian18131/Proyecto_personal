<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>{{ $data['tipo_documento'] ?? 'Comunicación Oficial' }}</title>
    <style>
        @page { margin: 2cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }
        .header-container { width: 100%; margin-bottom: 30px; }
        .logo { float: left; width: 100px; max-height: 100px; object-fit: contain; }
        .header-text {
            float: right;
            width: 70%;
            text-align: right;
            font-size: 9pt;
            color: #555;
        }
        .radicado-box {
            border: 1px solid #000;
            padding: 10px;
            width: 250px;
            float: right;
            margin-bottom: 20px;
            font-size: 9pt;
            text-align: center;
        }
        .qr-code { width: 80px; height: 80px; margin-bottom: 5px; }
        .main-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin: 40px 0 20px 0;
            clear: both;
            text-transform: uppercase;
        }
        .info-grid { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-grid td { padding: 5px 0; vertical-align: top; }
        .label { font-weight: bold; }
        .text-content { text-align: justify; margin: 30px 0; min-height: 200px; }
        .signature-section { margin-top: 50px; }
        .signature-img { width: 150px; height: auto; margin-bottom: 5px; }
        .signature-line { width: 250px; border-top: 1px solid #000; padding-top: 5px; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .clearfix::after { content: ""; clear: both; display: table; }
        
        /* Reduced farewell lines */
        .farewell { margin-top: 20px; line-height: 1.2; }
    </style>
</head>
<body>

    <div class="header-container clearfix">
        @php
            $logo = \App\Models\Setting::get('company_logo');
            $logoPath = $logo ? public_path('storage/' . $logo) : public_path('images/sena-logo.png');
        @endphp
        <img src="{{ $logoPath }}" alt="Logo" class="logo">
        
        <div class="radicado-box">
            @if(isset($data['radicado']) || isset($data['consecutivo']))
                @php
                    $radNumber = $data['radicado'] ?? $data['consecutivo'];
                    $qrUrl = url('/v/' . base64_encode($radNumber));
                    $qrSource = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode($qrUrl) . "&choe=UTF-8";
                @endphp
                <img src="{{ $qrSource }}" class="qr-code" alt="QR"><br>
                <strong>RADICADO No: {{ $radNumber }}</strong><br>
                Fecha: {{ $data['fecha'] ?? date('d/m/Y') }}
            @endif
        </div>
    </div>

    <div class="main-title">
        {{ $data['tipo_documento'] ?? 'Comunicación' }}
    </div>

    <table class="info-grid">
        <tr>
            <td width="50%">
                <span class="label">Lugar:</span> {{ $data['lugar'] ?? 'Pereira' }}<br>
                <span class="label">Fecha:</span> {{ $data['fecha'] ?? date('d/m/Y') }}<br>
                <span class="label">Dependencia:</span> {{ $data['dependencia_name'] ?? '' }}
            </td>
            <td width="50%">
                <span class="label">Serie:</span> {{ $data['serie'] ?? '' }}<br>
                <span class="label">Subserie:</span> {{ $data['subserie'] ?? '' }}<br>
                <span class="label">Código Acta:</span> {{ $data['codigo'] ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <div class="destinatario" style="margin-top: 20px;">
        <div class="line">{{ $data['tratamiento'] ?? '' }}</div>
        <div class="label" style="font-size: 12pt;">{{ $data['nombres'] ?? '' }}</div>
        <div class="line">{{ $data['cargo'] ?? '' }}</div>
        <div class="line">{{ $data['empresa'] ?? '' }}</div>
        <div class="line">{{ $data['ciudad'] ?? '' }}</div>
    </div>

    <div style="margin-top: 30px;">
        <span class="label">Asunto:</span> {{ $data['asunto'] ?? '' }}
    </div>

    <div class="text-content">
        <div style="margin-bottom: 20px;">{{ $data['saludo'] ?? 'Cordial saludo,' }}</div>
        {!! nl2br(e($data['texto'] ?? '')) !!}
    </div>

    <div class="farewell">
        {{ $data['despedida'] ?? 'Atentamente,' }}
    </div>

    <div class="signature-section">
        @if(isset($data['firma_digital_path']))
            <img src="{{ public_path('storage/' . $data['firma_digital_path']) }}" class="signature-img">
        @endif
        <div class="signature-line">
            <div class="label">{{ $data['firma_nombres'] ?? '' }}</div>
            <div class="line">{{ $data['firma_cargo'] ?? '' }}</div>
        </div>
    </div>

    <div class="footer">
        {!! \App\Models\Setting::get('footer_text', 'SENA - Servicio Nacional de Aprendizaje. Regional Risaralda.') !!}
        <br>
        &copy; Gedocs {{ date('Y') }}
    </div>

</body>
</html>
y>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Comunicación Oficial</title>
    <style>
        /* Optimización para PDF */
        @page {
            margin: 2cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }

        .header-container {
            width: 100%;
            height: 80px;
            margin-bottom: 20px;
        }

        .logo {
            float: left;
            width: 80px;
            height: 80px;
        }

        .header-text {
            float: left;
            width: 60%;
            padding-left: 20px;
            padding-top: 15px;
            font-size: 10pt;
            color: #555;
        }

        /* Barra decorativa superior (basada en la imagen) */
        .top-bar {
            width: 100%;
            height: 15px;
            margin-bottom: 40px;
        }
        .bar-SenaGreen { width: 30%; height: 100%; background-color: #0FB849; float: left; }
        .bar-blue { width: 40%; height: 100%; background-color: #2c3e50; float: left; }
        .bar-SenaGreen-right { width: 30%; height: 100%; background-color: #0FB849; float: left; }

        /* Título Principal */
        .main-title {
            text-align: right;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 10px;
            clear: both;
        }

        .radicado {
            text-align: right;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* Bloques de sección */
        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            display: block;
        }

        .line {
            display: block;
        }

        /* Contenedor de datos del destinatario */
        .destinatario {
            margin: 30px 0;
        }

        /* Área de texto justificada */
        .text-content {
            text-align: justify;
            margin-top: 15px;
            margin-bottom: 30px;
        }

        /* Estructura de Firma al pie */
        .signature-container {
            margin-top: 60px;
            width: 100%;
        }
        .signature-line {
            width: 250px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer-notes {
            margin-top: 40px;
            font-size: 10pt;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .footer{
            text-align: center; 
            font-size: 10pt; 
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header-container clearfix">
        <!-- Logo (Replace with appropriate base64 or absolute path in production if available) -->
        <!-- Usa un logo local si está disponible en public/images/sena-logo.png -->
        <img src="{{ public_path('images/sena-logo.png') }}" alt="Logo SENA" class="logo" onerror="this.style.display='none'">
        <div class="header-text">
            SENA - Servicio Nacional de Aprendizaje<br>
            Centro de Comercio y Servicios - Regional Pereira<br>
            Sistema de Gestión Documental
        </div>
    </div>

    <!-- Si pasamos el radicado o consecutivo que lo muestre -->
    @if(isset($data['radicado']))
    <div class="radicado">
        Radicado: {{ $data['radicado'] }}
    </div>
    @endif
    
    @if(isset($data['consecutivo']))
    <div class="radicado" style="margin-top: -20px;">
        Consecutivo: {{ $data['consecutivo'] }}
    </div>
    @endif

    <div class="main-title">
        {{ $data['tipo_documento'] ?? 'Comunicación Oficial' }}
    </div>

    <div class="section">
        <div class="line">Código de acta: {{ $data['codigo'] ?? 'S/N' }}</div>
        <div class="label">Lugar y fecha de elaboración</div>
        <div class="line">{{ $data['lugar'] ?? '' }}</div>
        <div class="line">{{ $data['fecha'] ?? '' }}</div>
    </div>

    <div class="destinatario">
        <div class="line">{{ $data['tratamiento'] ?? '' }}</div>
        <div class="label">{{ $data['nombres'] ?? '' }}</div>
        <div class="line">{{ $data['cargo'] ?? '' }}</div>
        <div class="line">{{ $data['empresa'] ?? '' }}</div>
        <div class="line">{{ $data['direccion'] ?? '' }}</div>
        <div class="line">{{ $data['ciudad'] ?? '' }}</div>
    </div>

    <div class="section">
        <span class="label" style="display: inline;">Asunto:</span>
        <span>{{ $data['asunto'] ?? '' }}</span>
    </div>

    <div class="section">
        <div class="line">{{ $data['saludo'] ?? '' }}</div>
        <div class="text-content">
            {!! nl2br(e($data['texto'] ?? '')) !!}
        </div>
    </div>

    <div class="section">
        <div class="line">{{ $data['despedida1'] ?? '' }}</div>
        <div class="line">{{ $data['despedida2'] ?? '' }}</div>
        <div class="line">{{ $data['despedida3'] ?? '' }}</div>
    </div>

    <div class="signature-container">
        <div style="margin-bottom: 5px;">
            <img src="{{ public_path('images/signature-placeholder.png') }}" alt="Firma" style="width: 200px; height: 60px;" onerror="this.style.display='none'">
        </div>
        <div class="signature-line">
            <div class="label">{{ $data['firma_nombres'] ?? '' }}</div>
            <div class="line">{{ $data['firma_cargo'] ?? '' }}</div>
        </div>
    </div>

    <div class="footer-notes">
        @if(!empty($data['anexo']))
            <div><strong>Anexo:</strong> {{ $data['anexo'] }}</div>
        @endif
        @if(!empty($data['copia']))
            <div><strong>Copia:</strong> {{ $data['copia'] }}</div>
        @endif
        @if(!empty($data['transcriptor']))
            <div style="margin-top: 10px;"><strong>Transcriptor:</strong> {{ $data['transcriptor'] }}</div>
        @endif
    </div>

    <!-- <div class="top-bar clearfix">
        <div class="bar-SenaGreen"></div>
        <div class="bar-blue"></div>
        <div class="bar-SenaGreen-right"></div>
    </div> -->
    <br>
    <div class="footer">
        <div>
            SENA - Centro de comercio y servicios - Area de gestion documental<br>
            &copy; Gedocs {{ date('Y') }} Todos los derechos reservados.
        </div>
    </div>

</body>
</html>
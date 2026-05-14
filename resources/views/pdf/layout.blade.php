<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte - {{ config('app.name') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #2563eb; font-size: 22px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; height: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f8fafc; color: #475569; font-weight: bold; text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 10px; }
        td { padding: 10px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .status { padding: 3px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .status-paid { background-color: #dcfce7; color: #166534; }
        .status-pending { background-color: #fef9c3; color: #854d0e; }
        .summary-box { background-color: #f8fafc; border-radius: 10px; padding: 15px; margin-top: 20px; border: 1px solid #e2e8f0; }
        .summary-box h3 { margin: 0 0 10px; font-size: 14px; border-bottom: 1px solid #cbd5e1; padding-bottom: 5px; }
        .bcv-rate { font-size: 9px; color: #64748b; margin-top: 10px; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Taller Automotriz Inversiones Dios es Amor 31 C. A.</h1>
        <p>Reporte Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @yield('content')

    <div class="footer">
        © {{ date('Y') }} Inversiones Dios es Amor 31 C. A. - Software de Gestión de Taller
    </div>
</body>
</html>

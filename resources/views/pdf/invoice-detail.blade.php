@extends('pdf.layout')

@section('content')
    <div style="margin-bottom: 40px;">
        <div style="float: left; width: 50%;">
            <h2 style="margin: 0; color: #2563eb;">FACTURA</h2>
            <p style="font-weight: bold; font-size: 14px; margin: 5px 0;">{{ $invoice->number }}</p>
            <p style="color: #666;">Fecha de Emisión: {{ $invoice->issue_date }}</p>
        </div>
        <div style="float: right; width: 40%; text-align: right;">
            <div style="padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc;">
                <span class="status {{ $invoice->status == 'paid' ? 'status-paid' : 'status-pending' }}" style="font-size: 12px; padding: 5px 15px;">
                    {{ $invoice->status == 'paid' ? 'PAGADA' : 'PENDIENTE' }}
                </span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div style="margin-bottom: 30px; border-top: 1px solid #eee; pt-20">
        <div style="float: left; width: 45%;">
            <p class="font-bold" style="text-transform: uppercase; font-size: 10px; color: #666; margin-bottom: 5px;">Cliente</p>
            <p style="font-size: 14px; margin: 0;">{{ $invoice->serviceOrder->customer->name }}</p>
            <p style="color: #666; margin: 2px 0;">{{ $invoice->serviceOrder->customer->phone }}</p>
            <p style="color: #666; margin: 2px 0;">{{ $invoice->serviceOrder->customer->email }}</p>
        </div>
        <div style="float: right; width: 45%; text-align: right;">
            <p class="font-bold" style="text-transform: uppercase; font-size: 10px; color: #666; margin-bottom: 5px;">Vehículo</p>
            <p style="font-size: 14px; margin: 0;">{{ $invoice->serviceOrder->vehicle->make }} {{ $invoice->serviceOrder->vehicle->model }}</p>
            <p style="color: #2563eb; font-weight: bold; margin: 2px 0;">Placa: {{ $invoice->serviceOrder->vehicle->license_plate }}</p>
            <p style="color: #666; margin: 2px 0;">Año: {{ $invoice->serviceOrder->vehicle->year }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <h3 style="border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-top: 40px;">Detalles del Servicio</h3>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th class="text-center">Cant.</th>
                <th class="text-right">Precio Unit. ($)</th>
                <th class="text-right">Total ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->serviceOrder->workItems as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">${{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="float: right; width: 40%; margin-top: 20px;">
        <table style="border: none;">
            <tr>
                <td style="border: none;" class="font-bold">Total Factura:</td>
                <td style="border: none;" class="text-right font-bold">${{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;" class="font-bold text-green-400">Total Pagado:</td>
                <td style="border: none;" class="text-right font-bold text-green-400">${{ number_format($invoice->payments->sum('amount'), 2) }}</td>
            </tr>
            <tr style="border-top: 2px solid #2563eb;">
                <td style="border: none; font-size: 16px;" class="font-bold">SALDO:</td>
                <td style="border: none; font-size: 16px;" class="text-right font-bold">${{ number_format($invoice->total - $invoice->payments->sum('amount'), 2) }}</td>
            </tr>
        </table>
    </div>
    <div style="clear: both;"></div>

    <div class="summary-box" style="margin-top: 50px;">
        <p style="font-size: 10px; color: #666;"><strong>Equivalente en Bolívares:</strong></p>
        <p style="font-size: 18px; font-weight: black; color: #1e293b; margin: 5px 0;">
            Bs. {{ number_format($invoice->total * $rate, 2) }}
        </p>
        <p class="bcv-rate">Calculado a tasa BCV de Bs. {{ number_format($rate, 2) }}</p>
    </div>
@endsection

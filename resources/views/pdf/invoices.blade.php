@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Reporte de Facturación</h2>

    <table>
        <thead>
            <tr>
                <th>Factura</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th class="text-right">Total ($)</th>
                <th class="text-right">Cobrado ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                @php $paid = $invoice->payments->sum('amount'); @endphp
                <tr>
                    <td class="font-bold">{{ $invoice->number }}</td>
                    <td>{{ $invoice->serviceOrder->customer->name }}</td>
                    <td>{{ $invoice->issue_date }}</td>
                    <td class="text-center">
                        <span class="status {{ $invoice->status == 'paid' ? 'status-paid' : 'status-pending' }}">
                            {{ $invoice->status == 'paid' ? 'PAGADA' : 'PENDIENTE' }}
                        </span>
                    </td>
                    <td class="text-right">
                        ${{ number_format($invoice->total, 2) }}<br>
                        <span style="font-size: 8px; color: #64748b;">Bs. {{ number_format($invoice->total * $rate, 2) }}</span>
                    </td>
                    <td class="text-right">
                        ${{ number_format($paid, 2) }}<br>
                        <span style="font-size: 8px; color: #64748b;">Bs. {{ number_format($paid * $rate, 2) }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <h3>Resumen de Caja</h3>
        @php 
            $totalInvoiced = $invoices->sum('total');
            $totalPaid = $invoices->flatMap->payments->sum('amount');
        @endphp
        <table>
            <tr>
                <td><strong>Total Facturado:</strong><br>${{ number_format($totalInvoiced, 2) }}<br><span style="font-size: 8px;">Bs. {{ number_format($totalInvoiced * $rate, 2) }}</span></td>
                <td><strong>Total Cobrado:</strong><br>${{ number_format($totalPaid, 2) }}<br><span style="font-size: 8px;">Bs. {{ number_format($totalPaid * $rate, 2) }}</span></td>
                <td class="text-right"><strong>Saldo Pendiente:</strong><br><span style="color: #ef4444; font-weight: black;">${{ number_format($totalInvoiced - $totalPaid, 2) }}</span><br><span style="font-size: 8px; color: #ef4444;">Bs. {{ number_format(($totalInvoiced - $totalPaid) * $rate, 2) }}</span></td>
            </tr>
        </table>
    </div>

    <div class="bcv-rate">
        * Conversión a Bolívares según tasa BCV de Bs. {{ number_format($rate, 2) }}
    </div>
@endsection

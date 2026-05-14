@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Resumen Ejecutivo del Taller</h2>

    <div class="summary-box">
        <h3>Métricas Clave</h3>
        <table>
            <tr>
                <td><strong>Facturación Mensual:</strong><br>${{ number_format($monthlySales, 2) }} (Bs. {{ number_format($monthlySales * $rate, 2) }})</td>
                <td><strong>Clientes Registrados:</strong><br>{{ $customersCount }}</td>
                <td><strong>Órdenes Totales:</strong><br>{{ $ordersCount }}</td>
                <td><strong>Alertas de Stock:</strong><br>{{ $criticalStock }}</td>
            </tr>
        </table>
    </div>

    <h3 style="margin-top: 30px; border-bottom: 2px solid #f1f5f9; padding-bottom: 5px;">Últimas 10 Órdenes de Trabajo</h3>
    <table>
        <thead>
            <tr>
                <th>OT</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th class="text-right">Total ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
                <tr>
                    <td>#OT-{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->vehicle->make }} {{ $order->vehicle->model }}</td>
                    <td class="text-center">{{ strtoupper($order->status) }}</td>
                    <td class="text-right">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="bcv-rate">
        * Reporte generado con tasa BCV de Bs. {{ number_format($rate, 2) }}
    </div>
@endsection

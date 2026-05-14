@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Reporte de Órdenes de Trabajo</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehículo</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th class="text-right">Total ($)</th>
            </tr>
        </thead>
        <tbody>
                @php 
                    $statusMap = [
                        'pending' => 'PENDIENTE',
                        'in_process' => 'EN PROCESO',
                        'completed' => 'COMPLETADA',
                        'cancelled' => 'CANCELADA'
                    ];
                @endphp
                @foreach($orders as $order)
                    <tr>
                        <td>#OT-{{ $order->id }}</td>
                        <td>
                            <div class="font-bold">{{ $order->vehicle->make }} {{ $order->vehicle->model }}</div>
                            <div style="font-size: 8px; color: #666;">Placa: {{ $order->vehicle->license_plate }}</div>
                        </td>
                        <td>{{ $order->customer->name }}</td>
                        <td class="text-center">
                            <span class="status {{ in_array($order->status, ['completed', 'paid']) ? 'status-paid' : 'status-pending' }}">
                                {{ $statusMap[$order->status] ?? strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="text-right">
                            ${{ number_format($order->total_amount, 2) }}<br>
                            <span style="font-size: 8px; color: #64748b;">Bs. {{ number_format($order->total_amount * $rate, 2) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-box">
            <h3>Métricas de Operación</h3>
            @php $totalAmount = $orders->sum('total_amount'); @endphp
            <table>
                <tr>
                    <td><strong>Total Órdenes:</strong> {{ $orders->count() }}</td>
                    <td><strong>Completadas:</strong> {{ $orders->where('status', 'completed')->count() }}</td>
                    <td class="text-right">
                        <strong>Facturación Total:</strong><br>
                        <span style="font-size: 16px; color: #2563eb;">${{ number_format($totalAmount, 2) }}</span><br>
                        <span style="font-size: 10px; color: #64748b;">Bs. {{ number_format($totalAmount * $rate, 2) }}</span>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="bcv-rate">
            * Conversión a Bolívares según tasa BCV de Bs. {{ number_format($rate, 2) }}
        </div>
@endsection

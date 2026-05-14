@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Agenda de Citas</h2>

    <table>
        <thead>
            <tr>
                <th>Fecha / Hora</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
                @php 
                    $statusMap = [
                        'scheduled' => 'PROGRAMADA',
                        'confirmed' => 'CONFIRMADA',
                        'completed' => 'COMPLETADA',
                        'cancelled' => 'CANCELADA'
                    ];
                @endphp
                @foreach($appointments as $appointment)
                    <tr>
                        <td class="font-bold">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $appointment->customer->name }}</td>
                        <td>{{ $appointment->vehicle->make }} {{ $appointment->vehicle->model }} ({{ $appointment->vehicle->license_plate }})</td>
                        <td>{{ $appointment->description }}</td>
                        <td class="text-center">
                            <span class="status {{ in_array($appointment->status, ['confirmed', 'completed']) ? 'status-paid' : 'status-pending' }}">
                                {{ $statusMap[$appointment->status] ?? strtoupper($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <p><strong>Total Citas Programadas:</strong> {{ $appointments->count() }}</p>
    </div>
@endsection

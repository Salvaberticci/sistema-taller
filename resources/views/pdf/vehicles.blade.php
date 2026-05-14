@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Reporte de Flota de Vehículos</h2>

    <table>
        <thead>
            <tr>
                <th>Propietario</th>
                <th>Marca / Modelo</th>
                <th>Placa</th>
                <th>Año</th>
                <th>Color</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                <tr>
                    <td class="font-bold">{{ $vehicle->customer->name }}</td>
                    <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                    <td class="text-center font-bold" style="color: #2563eb;">{{ $vehicle->license_plate }}</td>
                    <td class="text-center">{{ $vehicle->year }}</td>
                    <td class="text-center">{{ $vehicle->color ?? 'N/E' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <p><strong>Total Vehículos en Base de Datos:</strong> {{ $vehicles->count() }}</p>
    </div>
@endsection

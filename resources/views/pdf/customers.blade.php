@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Directorio de Clientes</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre / Razón Social</th>
                <th>C.I. / RIF</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Vehículos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td class="font-bold">{{ $customer->name }}</td>
                    <td>{{ $customer->id_card ?? 'N/E' }}</td>
                    <td>{{ $customer->phone ?? 'N/E' }}</td>
                    <td>{{ $customer->email ?? 'N/E' }}</td>
                    <td class="text-center">{{ $customer->vehicles->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <p><strong>Total Clientes Registrados:</strong> {{ $customers->count() }}</p>
    </div>
@endsection

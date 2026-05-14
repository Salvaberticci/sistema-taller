@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Reporte de Personal y Colaboradores</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $member)
                <tr>
                    <td class="font-bold">{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td class="text-center font-bold uppercase" style="color: #2563eb;">{{ $member->role }}</td>
                    <td class="text-center">{{ $member->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <p><strong>Total Miembros del Equipo:</strong> {{ $staff->count() }}</p>
    </div>
@endsection

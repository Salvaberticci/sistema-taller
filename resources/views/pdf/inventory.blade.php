@extends('pdf.layout')

@section('content')
    <h2 style="text-align: center;">Reporte de Inventario</h2>

    <table>
        <thead>
            <tr>
                <th>Repuesto</th>
                <th>SKU</th>
                <th>Stock</th>
                <th class="text-right">Precio ($)</th>
                <th class="text-right">Precio (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalUsd = 0; @endphp
            @foreach($parts as $part)
                @php $totalUsd += ($part->stock * $part->price); @endphp
                <tr>
                    <td>
                        <div class="font-bold">{{ $part->name }}</div>
                        <div style="font-size: 8px; color: #666;">Categoría: {{ $part->category ?? 'General' }}</div>
                    </td>
                    <td>{{ $part->sku ?? 'N/A' }}</td>
                    <td class="text-center">{{ $part->stock }}</td>
                    <td class="text-right">${{ number_format($part->price, 2) }}</td>
                    <td class="text-right">Bs. {{ number_format($part->price * $rate, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <h3>Resumen Valorizado</h3>
        <table>
            <tr>
                <td class="font-bold">Total Items:</td>
                <td>{{ $parts->count() }}</td>
                <td class="font-bold">Valor Total en Stock:</td>
                <td class="text-right font-bold" style="color: #2563eb; font-size: 16px;">
                    ${{ number_format($totalUsd, 2) }}<br>
                    <span style="font-size: 10px; color: #64748b;">Bs. {{ number_format($totalUsd * $rate, 2) }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="bcv-rate">
        * Precios calculados según tasa BCV oficial de Bs. {{ number_format($rate, 2) }} por dólar.
    </div>
@endsection

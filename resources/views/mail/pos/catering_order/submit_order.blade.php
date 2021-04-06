@extends('mail.mail')

@section('content')
    <p>Bestelldatum: {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('l, d.m.Y')
     }}</p>

    <p>Lieferdatum: {{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('l, d.m.Y')
     }}</p>

    <table style="margin-bottom: 30px; border-collapse: collapse;">
        <thead>
        <tr style="font-size: 12px;">
            <th style="border: 1px solid #ccc;">Artikel</th>
            <th style="border: 1px solid #ccc;">Menge</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->orderItems as $item)
            <tr>
                <td style="border: 1px solid #ccc; text-align: center;">{{ $item->cateringItem->cateringCategory->name }}
                    - {{
                $item->cateringItem->name
                }}</td>
                <td style="border: 1px solid #ccc;text-align: center;">{{ $item->quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
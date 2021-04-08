@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" height="64px"
             alt="{{ config('app.name') }}">
    </div>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 0; padding: 0;">
        Bestelldatum: {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('l, d.m.Y')
     }}</p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 0; padding: 0;">
        Ort: {{ $order->user->location->name }}</p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0px 0px 40px 0px; padding: 0;">
        Lieferdatum: {{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('l, d.m.Y')
     }}</p>

    <table style="width: 50%;">
        <thead>
        <tr style="color: #96c11f; text-align: left;">
            <th style="width: 33%;">Artikel</th>
            <th style="width: 33%;">Menge</th>
        </tr>
        </thead>
        @foreach ($order->orderItems->groupBy('cateringItem.cateringCategory.name') as $categoryName => $items)
            <tr align="center">
                <td><strong>{{ $categoryName }}</strong></td>
            </tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->cateringItem->name }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

@endsection
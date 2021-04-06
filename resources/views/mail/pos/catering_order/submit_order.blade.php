@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" alt="{{ config('app.name') }}">
    </div>

    <div>
        <a href="https://lehmanns-gastronomie.de/lehmanns-app/" style="display: block">
            <img src="{{ asset('image/email_footer.jpg') }}" alt="https://lehmanns-gastronomie.de/lehmanns-app/" style="width: 100%;">
        </a>
    </div>

@endsection
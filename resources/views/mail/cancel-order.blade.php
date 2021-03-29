@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" alt="{{ config('app.name') }}">
    </div>

    <p>Hallo {{ $user->full_name }},</p>
    <br>
    <p>Ihre <b>Essensbestellung</b> für den <b>{{ $vacationPeriod }}</b> wurde durch den Administrator <b>storniert.</b></p>
    <p>Bei Fragen melden Sie sich bitte unter <a href="mailto:kontakt@myfoodorder.de" style="color: #96c11f; text-decoration: none;">kontakt@myfoodorder.de</a></p>
    <br>
    <p>Das LEHMANNs <strong><span style="color:#96c11f">cool</span>inary</strong>-Team</p>

    <p style="border-top: 1px dashed black; padding-top: 30px; margin-top: 30px;"><strong><span style="color:#96c11f">cool</span>inary</strong> ist ein Partner von
        <br>
        <img src="{{ asset('image/logo_small.png') }}" alt="{{ config('app.name') }}" style="border-top: 4px solid black; height: 32px;">
    </p>

    <div>
        <a href="https://lehmanns-gastronomie.de/lehmanns-app/" style="display: block">
            <img src="{{ asset('image/email_footer.jpg') }}" alt="https://lehmanns-gastronomie.de/lehmanns-app/" style="width: 100%;">
        </a>
    </div>

@endsection
@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" height="64px" alt="{{ config('app.name') }}">
    </div>

    <p>Hallo {{ $user->full_name }},</p>
    <p>Ihre <b>Essensbestellung</b> für {{ $consumer->full_name }} am <b>{{ $vacationPeriod }}</b> wurde durch den Administrator <b>storniert.</b></p>
    <p>Bei Fragen melden Sie sich bitte unter <a href="mailto:kontakt@myfoodorder.de" style="color: #96c11f; text-decoration: none;">kontakt@myfoodorder.de</a></p>
    <br>
    <p>Das LEHMANNs <strong><span style="color:#96c11f">cool</span>inary</strong>-Team</p>

@endsection
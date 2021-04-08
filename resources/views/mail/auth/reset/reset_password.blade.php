@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" height="64px"
             alt="{{ config('app.name') }}">
    </div>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 40px; padding: 0;">
        Hallo,
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 40px; padding: 0;">
        Hast du dein Passwort vergessen?
        Klicken Sie einfach auf den folgenden Link oder kopieren Sie ihn in Ihren Browser, um ein
        neues Passwort zu erstellen.
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 40px; padding: 0;">
        <a href="{{$url}}" style="color: #96c11f;">{{$url}}</a>
    </p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 40px; padding: 0;">
        Wenn Sie diese Anfrage nicht gesendet haben, können Sie diese E-Mail ignorieren.
    </p>

@endsection
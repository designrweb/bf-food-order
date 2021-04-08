@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" height="64px" alt="{{ config('app.name') }}">
        <img src="{{ asset('image/smile_logo.png') }}" height="64px" alt="Smile">
    </div>

    <h2 style="color: #96c11f;"><span style="text-transform: uppercase;">AKTIVIERUNG</span> Ihres
        myfoodorder-Kontos!</h2>

    <p>Herzlichen Glückwunsch!</p>

    <p>
        Ihr MyFoodOrder-Konto wurde erstellt. Sie können es ab sofort nutzen.
        Die E-Mail-Adresse, die Sie bei der Anmeldung angegeben haben, lautet
        <strong>{{ $user->email }}</strong>. <br>
        Um Ihr Konto zu aktivieren, müssen Sie nur noch diese E-Mail-Adresse bestätigen.
    </p>

    <div>
        <a href="{{$verificationUrl}}">
            <img src="{{ asset('image/activate.png') }}" alt="{{ config('app.name') }}">
        </a>
    </div>

    <p>Vielen Dank für Ihre Anmeldung und willkommen bei MyFoodOrder!</p>

    <p>Das MyFoodOrder Team</p>

    <p style="border-top: 1px dashed black; border-bottom: 1px dashed black; font-style: italic;">
        Wenn die Schaltfläche oben nicht funktioniert, können Sie die folgende Adresse kopieren und
        in die Adressleiste Ihres Browsers eingeben: {{$verificationUrl}}
        <br>
        Sollten Sie keine Registrierung durchgeführt haben, so ignorieren Sie bitte diese E-Mail.
        <br>
        Diese E-Mail wurde automatisch erstellt. Bitte antworten Sie nicht darauf. Klicken <a
                href="mailto:kontakt@myfoodorder.de">Sie hier</a>, wenn Sie uns kontaktieren
        möchten.
    </p>

@endsection
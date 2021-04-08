<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        p {
            font: 400 14px/1.5 'Open Sans', sans-serif;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @yield('content')

    <p style="border-top: 1px dashed black; padding-top: 30px; margin-top: 30px;"><strong><span
                    style="color:#96c11f">cool</span>inary</strong> ist ein Partner von
        <br>
        <img src="{{ asset('image/logo_small.png') }}" alt="{{ config('app.name') }}"
             style="border-top: 4px solid black; height: 32px;">
    </p>

    <div>
        <a href="https://lehmanns-gastronomie.de/lehmanns-app/" style="display: block">
            <img src="{{ asset('image/email_footer.jpg') }}"
                 alt="https://lehmanns-gastronomie.de/lehmanns-app/" style="width: 100%;">
        </a>
    </div>
</body>
</html>

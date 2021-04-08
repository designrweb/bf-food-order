@extends('mail.mail')

@section('content')
    <div>
        <img src="{{ asset('image/Coolinary_Logo_rgb.png') }}" height="64px" alt="{{ config('app.name') }}">
    </div>

    <p>Liebe Schüler*innen, liebe Eltern und Lehrer*innen,</p>

    <h3>Herzlich Willkommen bei {{ config('app.name') }}.</h3>

    <p>{{ config('app.name') }} ist das bargeldlose Bestell- und Abrechnungssystem von Lehmanns <strong><span style="color:#96c11f">cool</span>inary</strong>. Wir sind der neue Schulcaterer an der IGS Bonn-Beuel und freuen uns, dass wir Sie als Gast in der Schulmensa begrüßen dürfen.</p>
    <p>Um allen Essensteilnehmern das gewünschte Menü anbieten zu können, lange Wartezeiten an der Essensausgabe zu vermeiden, eine hohe Qualität der Speisen zu garantieren und das alles auch noch zu fairen Preisen anbieten zu können, nutzen wir ein bargeldloses Bestell- und Abrechnungssystem.</p>

    <h4>Und so funktioniert’s:</h4>

    <h4 style="color: #96c11f;">Die Registrierung</h4>

    <p>Diese haben Sie bereits erfolgreich absolviert, wenn Sie dieses Schreiben lesen 😊</p>


    <h4 style="color: #96c11f;">Die Bestellung</h4>

    <p>Unter folgender Internetadresse können Sie den Menüplan einsehen und bestellen: <a href="{{route('login')}}" style="color: #96c11f;">{{route('login')}}</a></p>

    <p>Je nach Gericht muss nur die Hauptkomponente vorbestellt werden, alle Sättigungs-, Gemüse- und Salatbeilagen sind individuell an der Essensausgabe wählbar.</p>

    <p>Loggen Sie sich mit Ihren Benutzerdaten ein. Anmeldename ist Ihre angegebene E-Mail-Adresse und das Passwort haben Sie selbst vergeben. Nach erfolgreicher Anmeldung gelangen Sie sofort auf den aktuellen Speiseplan.</p>

    <p>
        Hier wählen Sie für jeden Wochentag das gewünschte Menü aus und bestätigen die Bestellung.
        Spätestens einen Tag vor dem gewünschten Essenstag bis 13.00 Uhr muss die Bestellung online vorliegen.
        Beispiel: am Dienstag ist der gewünschte Essenstag, dann muss am Montag bis spätestens 13.00 Uhr das Menü bestellt sein. Allerdings muss für den Montag die Bestellung am letzten Werktag der Vorwoche (in der Regel freitags, außer an Feiertagen) bis 13.00 Uhr vorliegen.
    </p>

    <h4 style="color: #96c11f;">Die Bezahlung</h4>

    <p>
        Bitte überweisen Sie an folgendes Konto:<br>
        Empfänger: <strong>Lehmanns</strong><br>
        Kreditinstitut: <strong>Sparkasse KölnBonn</strong><br>
        <abbr>IBAN</abbr>: <strong>DE51 3705 0198 1935 3522 27</strong><br>
        <abbr>BIC</abbr>: <strong>COLSDE33</strong><br>
        Verwendungszweck: <strong>Vollständiger Name des Kindes und Kundennummer</strong> (<strong>{{ $consumer->account_id }}</strong>)
    </p>
    <p>Ihr Kundenkonto muss stets über ein Guthaben verfügen, um eine Bestellung aufgeben zu können. Bitte beachten Sie, dass je nach Bank, bis zu vier Werktage vergehen, bis die Wertstellung auf dem Guthabenkonto erfolgt.</p>

    <table style="width: 50%;">
        <thead>
        <tr style="color: #96c11f; text-align: left;">
            <th style="width: 33%;">Das Angebot</th>
            <th style="width: 33%;">Vorbstellung</th>
            <th style="width: 33%;">Spontanessen</th>
        </tr>
        </thead>
        @foreach ($menuCategories as $menuCategory)
        <tr>
            <td>{{ $menuCategory->name }}:</td>
            <td><strong>{{ $menuCategory->presaleprice }} €</strong> inkl. MwSt.</td>
            <td>
                {!! $menuCategory->price ? "<strong>{$menuCategory->price} €</strong> inkl. MwSt." : "nicht verfügbar" !!}
            </td>
        </tr>
        @endforeach
    </table>

    <h4 style="color: #96c11f;">Die Identifikation (QR-Code)</h4>

    <p>Zur Identifikation an der Essensausgabe benötigt jeder Essensteilnehmer einen QR-Code. Dieser kann ausgedruckt oder digital über ein mobiles Endgerät (z.B. Smartphone) angezeigt werden. Den QR-Code finden Sie unter dem Menüpunkt „QR-Code“.</p>

    <h4 style="color: #96c11f;">Die Abholung</h4>

    <p>Der QR-Code des Essensteilnehmers wird an der Ausgabe gescannt. Dem Mitarbeiter an der Essensausgabe wird das vorbestellte Menü angezeigt und der Essensteilnehmer kann aus den Sättigungs-, sowie Salat- und Gemüsekomponenten auswählen und sein Menü entgegennehmen.</p>


    <h4 style="color: #96c11f;">Die Stornierung</h4>

    <p>Bei z.B. Abwesenheit oder Krankheit des Essensteilnehmers, kann das Essen bis 09:00 Uhr am Essenstag online storniert werden.</p>

    <h4 style="color: #96c11f;">Die Kundenbetreuung</h4>

    <p>
        Bei allen Fragen zum Bestell- und Abrechnungssystem, sowie Verpflegungsangebot wenden Sie sich bitte an die Kundenbetreuung montags bis freitags von 08:00 bis 16:00 Uhr unter 0228 - 850 261-55 oder
        <a href="mailto:kontakt@myfoodorder.de" style="color: #96c11f;">kontakt@myfoodorder.de</a>.
    </p>

    <p>Wir wünschen einen guten Appetit!</p>

    <p>Das LEHMANNs <strong><span style="color:#96c11f">cool</span>inary</strong> Team der IGS Bonn-Beuel</p>



@endsection
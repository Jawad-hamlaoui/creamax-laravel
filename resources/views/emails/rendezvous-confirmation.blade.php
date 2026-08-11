@php
    $settings = \App\Models\Setting::current();
    $client = $rendezVous->client;
@endphp
<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #1a1a14; line-height: 1.6;">
    <h2 style="color: #234625;">Votre rendez-vous est confirmé</h2>

    <p>Bonjour {{ $client?->prenom }},</p>

    <p>Nous vous confirmons votre rendez-vous avec {{ $settings->nom_entreprise }} :</p>

    <ul>
        <li><strong>Date et heure :</strong> {{ $rendezVous->date_heure->translatedFormat('l j F Y à H:i') }}</li>
        @if ($rendezVous->notes)
            <li><strong>Notes :</strong> {{ $rendezVous->notes }}</li>
        @endif
    </ul>

    <p>Pour toute question, vous pouvez nous contacter :</p>
    <ul>
        @if ($settings->telephone)
            <li>Téléphone : {{ $settings->telephone }}</li>
        @endif
        @if ($settings->email)
            <li>Email : {{ $settings->email }}</li>
        @endif
    </ul>

    <p>À bientôt,<br>{{ $settings->nom_entreprise }}</p>

    <p style="color:#7a7a6a;font-size:12px;margin-top:32px;">{{ config('app.name') }}</p>
</body>
</html>

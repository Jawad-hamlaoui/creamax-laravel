<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #1a1a14; line-height: 1.6;">
    <h2 style="color: #234625;">Nouvelle demande de contact</h2>

    <p><strong>{{ $contactMessage->prenom }} {{ $contactMessage->nom }}</strong></p>

    <ul>
        <li>Téléphone : {{ $contactMessage->telephone }}</li>
        <li>Email : {{ $contactMessage->email }}</li>
        @if ($contactMessage->commune)
            <li>Commune : {{ $contactMessage->commune }}</li>
        @endif
        @if ($contactMessage->prestation)
            <li>Prestation souhaitée : {{ $contactMessage->prestation }}</li>
        @endif
    </ul>

    <p><strong>Message :</strong></p>
    <p>{{ $contactMessage->message }}</p>

    <p>
        <a href="{{ url('/admin/contact-messages') }}" style="display:inline-block;background:#234625;color:#ffffff;padding:12px 24px;border-radius:99px;text-decoration:none;">
            Voir la demande dans l'admin
        </a>
    </p>

    <p style="color:#7a7a6a;font-size:12px;margin-top:32px;">{{ config('app.name') }}</p>
</body>
</html>

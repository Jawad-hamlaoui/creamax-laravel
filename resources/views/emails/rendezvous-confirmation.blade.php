@php
    $settings = \App\Models\Setting::current();
    $client = $rendezVous->client;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmation de rendez-vous</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f2eb;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f2eb;">
  <tr>
    <td align="center" style="padding:32px 16px;">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden;">
        <tr>
          <td style="background-color:#234625; padding:24px 32px;">
            <span style="font-family:Georgia,'Playfair Display',serif; font-size:20px; color:#ffffff; font-weight:bold;">{{ $settings->nom_entreprise }}</span>
          </td>
        </tr>
        <tr>
          <td style="padding:32px; font-family:Arial,Helvetica,sans-serif; color:#1a1a14;">
            <h1 style="margin:0 0 16px; font-size:20px; color:#234625;">Votre rendez-vous est confirmé</h1>
            <p style="margin:0 0 20px; font-size:15px; line-height:1.6;">Bonjour {{ $client?->prenom }},</p>
            <p style="margin:0 0 20px; font-size:15px; line-height:1.6;">
              Nous vous confirmons votre rendez-vous avec {{ $settings->nom_entreprise }} :
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px; background-color:#f4f2eb; border-radius:8px;">
              <tr>
                <td style="padding:16px 20px;">
                  <p style="margin:0 0 4px; font-size:12px; color:#7a7a6a; text-transform:uppercase; letter-spacing:0.05em;">Date et heure</p>
                  <p style="margin:0; font-size:17px; color:#234625; font-weight:bold;">{{ $rendezVous->date_heure->translatedFormat('l j F Y à H:i') }}</p>
                </td>
              </tr>
              @if ($rendezVous->notes)
                <tr>
                  <td style="padding:0 20px 16px;">
                    <p style="margin:0 0 4px; font-size:12px; color:#7a7a6a; text-transform:uppercase; letter-spacing:0.05em;">Notes</p>
                    <p style="margin:0; font-size:14px; color:#1a1a14;">{{ $rendezVous->notes }}</p>
                  </td>
                </tr>
              @endif
            </table>

            <p style="margin:0 0 8px; font-size:15px; line-height:1.6;">Pour toute question, vous pouvez nous contacter :</p>
            <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
              @if ($settings->telephone)
                <tr>
                  <td style="padding:4px 0; font-size:14px; color:#1a1a14;">📞 {{ $settings->telephone }}</td>
                </tr>
              @endif
              @if ($settings->email)
                <tr>
                  <td style="padding:4px 0; font-size:14px; color:#1a1a14;">✉ {{ $settings->email }}</td>
                </tr>
              @endif
            </table>

            <p style="margin:0; font-size:15px; line-height:1.6;">À bientôt,<br><strong>{{ $settings->nom_entreprise }}</strong></p>
          </td>
        </tr>
        <tr>
          <td style="background-color:#f4f2eb; padding:16px 32px; font-family:Arial,sans-serif; font-size:12px; color:#7a7a6a;">
            {{ config('app.name') }}
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

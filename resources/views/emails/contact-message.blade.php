<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle demande de contact</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f2eb;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f2eb;">
  <tr>
    <td align="center" style="padding:32px 16px;">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden;">
        <tr>
          <td style="background-color:#234625; padding:24px 32px;">
            <span style="font-family:Georgia,'Playfair Display',serif; font-size:20px; color:#ffffff; font-weight:bold;">Créa'Max Paysage</span>
          </td>
        </tr>
        <tr>
          <td style="padding:32px; font-family:Arial,Helvetica,sans-serif; color:#1a1a14;">
            <h1 style="margin:0 0 16px; font-size:20px; color:#234625;">Nouvelle demande de contact</h1>
            <p style="margin:0 0 20px; font-size:15px; line-height:1.6;">
              <strong>{{ $contactMessage->prenom }} {{ $contactMessage->nom }}</strong>
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:13px; color:#7a7a6a; width:140px;">Téléphone</td>
                <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:14px; color:#1a1a14;">{{ $contactMessage->telephone }}</td>
              </tr>
              <tr>
                <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:13px; color:#7a7a6a;">Email</td>
                <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:14px; color:#1a1a14;">{{ $contactMessage->email }}</td>
              </tr>
              @if ($contactMessage->commune)
                <tr>
                  <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:13px; color:#7a7a6a;">Commune</td>
                  <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:14px; color:#1a1a14;">{{ $contactMessage->commune }}</td>
                </tr>
              @endif
              @if ($contactMessage->prestation)
                <tr>
                  <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:13px; color:#7a7a6a;">Prestation</td>
                  <td style="padding:8px 0; border-bottom:1px solid #e4e2d8; font-size:14px; color:#1a1a14;">{{ $contactMessage->prestation }}</td>
                </tr>
              @endif
            </table>

            <p style="margin:0 0 8px; font-size:13px; color:#7a7a6a; font-weight:bold; text-transform:uppercase; letter-spacing:0.05em;">Message</p>
            <p style="margin:0 0 28px; font-size:15px; line-height:1.6; color:#1a1a14;">{{ $contactMessage->message }}</p>

            <table role="presentation" cellpadding="0" cellspacing="0">
              <tr>
                <td style="background-color:#234625; border-radius:99px;">
                  <a href="{{ url('/admin/contact-messages') }}" style="display:inline-block; padding:12px 28px; font-family:Arial,sans-serif; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none;">
                    Voir la demande dans l'admin
                  </a>
                </td>
              </tr>
            </table>
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

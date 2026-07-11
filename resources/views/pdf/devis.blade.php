<?php
/** @var \App\Models\Devis $devis */
$settings = \App\Models\Setting::current();
$client = $devis->client;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $devis->numero }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a14; }
        .header { width: 100%; margin-bottom: 20px; }
        .header td { vertical-align: top; }
        .company-name { font-size: 18px; font-weight: bold; color: #234625; }
        .company-info { font-size: 10px; color: #4a4a40; line-height: 1.5; margin-top: 4px; }
        .devis-meta { text-align: right; }
        .devis-meta .numero { font-size: 16px; font-weight: bold; color: #234625; }
        .status { display: inline-block; padding: 3px 10px; border-radius: 10px; background: #f4f2eb; color: #4a4a40; font-size: 10px; margin-top: 4px; }
        .parties { width: 100%; margin: 20px 0; }
        .parties td { width: 50%; vertical-align: top; padding: 10px; background: #fcfbf7; }
        .party-label { font-size: 9px; text-transform: uppercase; color: #7a7a6a; margin-bottom: 4px; }
        .party-name { font-weight: bold; margin-bottom: 2px; }
        table.lignes { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.lignes th { background: #234625; color: #fff; text-align: left; padding: 6px 8px; font-size: 10px; }
        table.lignes td { padding: 6px 8px; border-bottom: 1px solid #e4e2d8; }
        table.lignes td.num { text-align: right; }
        .totaux { width: 100%; margin-top: 15px; }
        .totaux td { padding: 3px 0; }
        .totaux .label { text-align: right; padding-right: 20px; }
        .totaux .value { text-align: right; width: 100px; }
        .totaux .ttc { font-weight: bold; font-size: 13px; color: #234625; border-top: 2px solid #234625; padding-top: 6px; }
        .notes { margin-top: 20px; padding: 10px; background: #fcfbf7; }
        .cgv { margin-top: 30px; font-size: 8px; color: #7a7a6a; line-height: 1.5; border-top: 1px solid #e4e2d8; padding-top: 10px; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td>
                <div class="company-name">{{ $settings->nom_entreprise }}</div>
                <div class="company-info">
                    {{ $settings->dirigeant }} — {{ $settings->forme_juridique }}<br>
                    {{ $settings->adresse }}<br>
                    SIRET : {{ $settings->siret }} — TVA : {{ $settings->tva_intra }}<br>
                    Zone d'intervention : {{ $settings->zone_intervention }}
                </div>
            </td>
            <td class="devis-meta">
                <div class="numero">{{ $devis->numero }}</div>
                <div>Date : {{ $devis->date_creation->format('d/m/Y') }}</div>
                <div>Validité : {{ $devis->validite_jours }} jours</div>
                <div class="status">{{ $devis->status->getLabel() }}</div>
            </td>
        </tr>
    </table>

    <table class="parties">
        <tr>
            <td>
                <div class="party-label">Émetteur</div>
                <div class="party-name">{{ $settings->nom_entreprise }}</div>
                <div>{{ $settings->adresse }}</div>
            </td>
            <td>
                <div class="party-label">Client</div>
                @if ($client)
                    <div class="party-name">{{ $client->prenom }} {{ $client->nom }}</div>
                    <div>{{ $client->adresse }}</div>
                    <div>{{ $client->email }} — {{ $client->tel }}</div>
                @else
                    <div class="party-name">Client non renseigné</div>
                @endif
            </td>
        </tr>
    </table>

    <table class="lignes">
        <thead>
            <tr>
                <th>Description</th>
                <th class="num">Qté</th>
                <th class="num">Prix unit.</th>
                <th class="num">Total HT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devis->lignes as $ligne)
                <tr>
                    <td>{{ $ligne->description }}</td>
                    <td class="num">{{ number_format((float) $ligne->quantite, 2, ',', ' ') }}</td>
                    <td class="num">{{ number_format((float) $ligne->prix_unitaire, 2, ',', ' ') }} €</td>
                    <td class="num">{{ number_format($ligne->total, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totaux">
        <tr>
            <td class="label">Sous-total HT</td>
            <td class="value">{{ number_format((float) $devis->sous_total, 2, ',', ' ') }} €</td>
        </tr>
        <tr>
            <td class="label">TVA ({{ rtrim(rtrim(number_format((float) $devis->tva_taux, 2), '0'), '.') }}%)</td>
            <td class="value">{{ number_format((float) $devis->tva_montant, 2, ',', ' ') }} €</td>
        </tr>
        <tr class="ttc">
            <td class="label">Total TTC</td>
            <td class="value">{{ number_format((float) $devis->total, 2, ',', ' ') }} €</td>
        </tr>
    </table>

    @if ($devis->notes)
        <div class="notes">
            <strong>Notes :</strong><br>
            {{ $devis->notes }}
        </div>
    @endif

    <div class="cgv">
        <strong>Conditions générales de vente</strong><br>
        {{ $settings->cgv_texte }}
    </div>
</body>
</html>

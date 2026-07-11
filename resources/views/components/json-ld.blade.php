@php
    $settings = \App\Models\Setting::current();

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'HomeAndConstructionBusiness',
        'name' => $settings->nom_entreprise,
        'alternateName' => 'CREA\'MAX',
        'description' => 'Conception, réalisation et entretien de jardin en Drôme et Ardèche.',
        'url' => url('/'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '3 Lotissement Carabas',
            'addressLocality' => 'Cruas',
            'postalCode' => '07350',
            'addressRegion' => 'Ardèche',
            'addressCountry' => 'FR',
        ],
        'areaServed' => [
            ['@type' => 'AdministrativeArea', 'name' => 'Drôme'],
            ['@type' => 'AdministrativeArea', 'name' => 'Ardèche'],
        ],
        'priceRange' => '€€',
        'founder' => ['@type' => 'Person', 'name' => $settings->dirigeant],
        'foundingDate' => '2026-02-25',
    ];

    if (filled($settings->telephone)) {
        $schema['telephone'] = $settings->telephone;
    }

    if (filled($settings->email)) {
        $schema['email'] = $settings->email;
    }

    $sameAs = array_filter([
        $settings->google_business_url,
        $settings->facebook_url,
        $settings->instagram_url,
    ]);

    if (! empty($sameAs)) {
        $schema['sameAs'] = array_values($sameAs);
    }
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

<x-layouts.public
    title="Créa'Max — Paysagiste Drôme & Ardèche | Création et entretien de jardin"
    description="Créa'Max Paysage, votre paysagiste en Drôme (26) et Ardèche (07). Création de jardins, aménagement paysager et entretien. Devis gratuit sous 72h, visite offerte."
>
@php
    $settings = \App\Models\Setting::current();
    $realisations = \App\Models\Realisation::where('actif', true)->orderBy('ordre')->get();
    $avisList = \App\Models\Avis::where('actif', true)->orderBy('ordre')->get();
@endphp
@include('partials.public.nav')

<section id="hero">
  <div class="hero-left">
    <div class="reveal hero-badge"><span></span>Drôme (26) & Ardèche (07)</div>
    <h1 class="hero-title reveal reveal-delay-1">
      Votre jardin,<br>
      notre <span class="accent-word">passion</span><br>
      <em>depuis des années</em>
    </h1>
    <p class="hero-desc reveal reveal-delay-2">
      Créa'Max conçoit, crée et entretient vos espaces extérieurs en Drôme et Ardèche. Du premier croquis à la livraison, nous transformons vos idées en jardins qui vous ressemblent.
    </p>
    <div class="hero-actions reveal reveal-delay-3">
      <a href="#devis" class="btn-primary">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        Devis gratuit
      </a>
      <a href="#portfolio" class="btn-outline">Voir nos jardins</a>
    </div>
    <div class="hero-trust reveal reveal-delay-4">
      <div class="trust-text">Drôme (26) &amp; Ardèche (07) — Devis gratuit · Visite offerte</div>
    </div>
  </div>

  <div class="hero-visual reveal reveal-delay-2">
    <div class="hero-badge-top">
      <div class="badge-top-num">72h</div>
      <div class="badge-top-lbl">Délai devis</div>
    </div>
    <div class="hero-img-main">
      @if ($settings->hero_image_path)
        <img src="{{ asset('storage/' . $settings->hero_image_path) }}" alt="Créa'Max Paysage" style="width:100%;height:100%;object-fit:cover;">
      @else
        <div class="hero-img-main-inner">
          <svg viewBox="0 0 80 80" fill="white"><path d="M40 5C25 5 12 18 12 33c0 20 28 42 28 42s28-22 28-42C68 18 55 5 40 5zm0 24a8 8 0 110-16 8 8 0 010 16z"/></svg>
        </div>
      @endif
    </div>
    <div class="hero-float-card">
      <div class="float-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2C8 2 5 5.5 5 9.5c0 5.5 7 12.5 7 12.5s7-7 7-12.5C19 5.5 16 2 12 2z"/></svg>
      </div>
      <div>
        <div class="float-num">0 €</div>
        <div class="float-lbl">Visite & devis gratuits</div>
      </div>
    </div>
  </div>
</section>

<section id="apropos">
  <div class="apropos-imgs reveal">
    <div class="apropos-img1">
      @if ($settings->apropos_image_1_path)
        <img src="{{ asset('storage/' . $settings->apropos_image_1_path) }}" alt="Créa'Max Paysage" style="width:100%;height:100%;object-fit:cover;">
      @else
        <div class="img-placeholder">
          <svg viewBox="0 0 24 24" fill="white"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
          Photo à venir
        </div>
      @endif
    </div>
    <div class="apropos-img2">
      @if ($settings->apropos_image_2_path)
        <img src="{{ asset('storage/' . $settings->apropos_image_2_path) }}" alt="Créa'Max Paysage" style="width:100%;height:100%;object-fit:cover;">
      @else
        <div class="img-placeholder">
          <svg viewBox="0 0 24 24" fill="white"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
          Photo à venir
        </div>
      @endif
    </div>
  </div>

  <div class="apropos-content">
    <div class="reveal"><span class="eyebrow">À propos</span></div>
    <h2 class="section-title reveal reveal-delay-1">L'art de créer des <em>espaces vivants</em></h2>
    <p class="section-sub reveal reveal-delay-2">
      Créa'Max Paysage accompagne les particuliers et professionnels de la Drôme et de l'Ardèche dans la création et l'entretien de leurs espaces extérieurs. Un savoir-faire rigoureux, une approche sur-mesure et une passion sincère pour les jardins.
    </p>
    <ul class="check-list reveal reveal-delay-3">
      <li>Conception sur-mesure avec plan paysager 2D/3D</li>
      <li>Matériel professionnel, travail soigné</li>
      <li>Devis remis sous 72h, visite gratuite sur site</li>
      <li>Aucun engagement — devis transparent</li>
    </ul>
    <div class="apropos-stats reveal reveal-delay-4">
      <div class="stat-card">
        <div class="stat-num">2</div>
        <div class="stat-lbl">Départements couverts</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">72h</div>
        <div class="stat-lbl">Délai de devis</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">0€</div>
        <div class="stat-lbl">Visite sur site</div>
      </div>
    </div>
    <div class="apropos-actions reveal reveal-delay-5">
      <a href="#devis" class="btn-primary">Demander un devis</a>
      <a href="#portfolio" class="btn-outline">Nos réalisations</a>
    </div>
  </div>
</section>

<section id="services" class="section-creme">
  <div class="services-header">
    <div>
      <div class="reveal"><span class="eyebrow">Nos prestations</span></div>
      <h2 class="section-title reveal reveal-delay-1">Tout pour vos<br><em>espaces verts</em></h2>
    </div>
    <a href="#devis" class="btn-outline reveal reveal-delay-2">Demander un devis</a>
  </div>
  <div class="services-grid">
    <div class="service-card reveal">
      <div class="service-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8 2 5 6 5 10c0 5 7 12 7 12s7-7 7-12c0-4-3-8-7-8z"/></svg></div>
      <div class="service-name">Création de jardins</div>
      <p class="service-desc">Conception sur-mesure : massifs, gazon, allées, bassins et arrosage automatique. Chaque jardin reflète votre personnalité.</p>
      <a href="#devis" class="service-link">En savoir plus <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="service-card reveal reveal-delay-1">
      <div class="service-icon"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg></div>
      <div class="service-name">Aménagement extérieur</div>
      <p class="service-desc">Terrasses, dallage, murets, clôtures, pergolas et éclairages. Valorisez votre propriété avec des aménagements durables.</p>
      <a href="#devis" class="service-link">En savoir plus <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="service-card reveal reveal-delay-2">
      <div class="service-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg></div>
      <div class="service-name">Entretien & taille</div>
      <p class="service-desc">Tonte, taille de haies, élagage, débroussaillage. Un jardin impeccable toute l'année.</p>
      <a href="#devis" class="service-link">En savoir plus <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="service-card reveal reveal-delay-1">
      <div class="service-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg></div>
      <div class="service-name">Étude & conseil</div>
      <p class="service-desc">Visite gratuite, plan paysager personnalisé et sélection des végétaux adaptés à votre sol et à votre région.</p>
      <a href="#devis" class="service-link">En savoir plus <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="service-card reveal reveal-delay-2">
      <div class="service-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
      <div class="service-name">Arrosage automatique</div>
      <p class="service-desc">Installation et programmation de systèmes d'arrosage intelligents. Économie d'eau garantie, plantes toujours bien hydratées.</p>
      <a href="#devis" class="service-link">En savoir plus <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="service-card reveal reveal-delay-3">
      <div class="service-icon"><svg viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg></div>
      <div class="service-name">Espaces pros & collectivités</div>
      <p class="service-desc">Contrats d'entretien annuels pour syndics, entreprises et collectivités locales. Interlocuteur unique, intervention régulière.</p>
      <a href="#devis" class="service-link">En savoir plus <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
  </div>
</section>

<section id="portfolio">
  <div class="portfolio-header">
    <div class="reveal"><span class="eyebrow">Nos réalisations</span></div>
    <h2 class="section-title reveal reveal-delay-1">Des jardins qui<br><em>parlent d'eux-mêmes</em></h2>
    <p class="section-sub reveal reveal-delay-2" style="margin: 16px auto 0; text-align:center;">Chaque projet est unique. Voici quelques réalisations récentes en Drôme et Ardèche.</p>
  </div>
  @if ($realisations->isEmpty())
    <p class="section-sub" style="text-align:center;">Réalisations à venir.</p>
  @else
    @php $bgs = ['linear-gradient(135deg,#a8c87a,#4a8a22)', 'linear-gradient(135deg,#8ab560,#3a6a20)', 'linear-gradient(135deg,#c5d890,#6a9a3a)']; @endphp
    <div class="portfolio-grid">
      @foreach ($realisations as $i => $projet)
        <div class="projet-card {{ $projet->featured ? 'featured' : '' }} reveal reveal-delay-{{ $i % 4 }}">
          <div class="projet-img">
            @if ($projet->image_path)
              <div class="proj-bg">
                <img src="{{ asset('storage/' . $projet->image_path) }}" alt="{{ $projet->titre }}" style="width:100%;height:100%;object-fit:cover;">
              </div>
            @else
              <div class="proj-bg" style="background:{{ $bgs[$i % count($bgs)] }};">
                <div class="img-placeholder" style="flex-direction:column;gap:8px;">
                  <svg viewBox="0 0 24 24" fill="white" style="width:36px;height:36px;opacity:0.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <span style="font-size:12px;opacity:0.7">Photo à venir</span>
                </div>
              </div>
            @endif
          </div>
          <div class="projet-meta">
            @if ($projet->lieu)
              <div class="meta-tag"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $projet->lieu }}</div>
            @endif
          </div>
          <div class="projet-body">
            <div class="projet-name">{{ $projet->titre }}</div>
            @if ($projet->description)
              <p class="projet-desc">{{ $projet->description }}</p>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  @endif
  <div style="text-align:center; margin-top:48px;">
    <a href="#devis" class="btn-accent reveal">Démarrer mon projet</a>
  </div>
</section>

<section id="avis" class="section-creme">
  <div class="portfolio-header">
    <div class="reveal"><span class="eyebrow">Avis clients</span></div>
    <h2 class="section-title reveal reveal-delay-1">Ce que <em>disent nos clients</em></h2>
    <p class="section-sub reveal reveal-delay-2" style="margin:16px auto 0;text-align:center;">Les avis Google de nos clients en Drôme et Ardèche.</p>
  </div>
  @if ($avisList->isEmpty())
    <p class="section-sub reveal reveal-delay-3" style="text-align:center;">Avis à venir.</p>
  @else
    <div class="avis-marquee reveal reveal-delay-3">
      <div class="avis-marquee-track">
        @foreach ($avisList->concat($avisList) as $avis)
          <div class="avis-card">
            <div class="avis-card-stars">{{ str_repeat('★', $avis->note) }}{{ str_repeat('☆', 5 - $avis->note) }}</div>
            <p class="avis-card-texte">{{ $avis->texte }}</p>
            <div class="avis-card-auteur">{{ $avis->nom_client }}</div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
  <div style="text-align:center; margin-top:48px;">
    <p class="section-sub reveal" style="margin:0 auto 20px;">Vous aussi, créez le jardin qui vous ressemble.</p>
    <a href="#devis" class="btn-accent reveal">Demander un devis</a>
  </div>
</section>

<section id="process" class="section-dark">
  <div class="process-header">
    <div class="reveal"><span class="eyebrow eyebrow-accent">Notre méthode</span></div>
    <h2 class="section-title section-title-light reveal reveal-delay-1">Comment ça se <em>passe ?</em></h2>
    <p class="section-sub section-sub-light reveal reveal-delay-2" style="margin:16px auto 0;text-align:center;max-width:500px;">Un processus simple et transparent, du premier contact à la livraison de votre jardin.</p>
  </div>
  <div class="process-grid">
    @foreach ([
        ['num' => 1, 'nom' => 'Visite & écoute', 'desc' => 'On se déplace chez vous gratuitement pour comprendre vos envies, votre budget et les contraintes de votre terrain.'],
        ['num' => 2, 'nom' => 'Plan & devis', 'desc' => 'Nous vous remettons un plan paysager détaillé et un devis transparent sous 72h. Aucune surprise.'],
        ['num' => 3, 'nom' => 'Réalisation', 'desc' => 'Nos équipes interviennent avec soin. Vous êtes informé à chaque étape clé du chantier.'],
        ['num' => 4, 'nom' => 'Livraison & suivi', 'desc' => 'Visite finale avec vous, conseils d\'entretien personnalisés. On reste disponibles après la livraison.'],
    ] as $i => $step)
      <div class="process-step reveal reveal-delay-{{ $i }}">
        <div class="process-num">{{ $step['num'] }}</div>
        <div class="process-name">{{ $step['nom'] }}</div>
        <p class="process-desc">{{ $step['desc'] }}</p>
      </div>
    @endforeach
  </div>
</section>

<section id="zone" class="section-creme">
  <div class="zone-grid">
    <div>
      <div class="reveal"><span class="eyebrow">Zone d'intervention</span></div>
      <h2 class="section-title reveal reveal-delay-1">On intervient<br><em>près de chez vous</em></h2>
      <p class="section-sub reveal reveal-delay-2">Créa'Max Paysage couvre l'intégralité des départements de la Drôme et de l'Ardèche. Contactez-nous pour vérifier votre commune.</p>
      <div class="zone-depts reveal reveal-delay-3">
        <div class="dept-card">
          <div class="dept-num">26</div>
          <div>
            <div class="dept-name">Drôme</div>
            <div class="dept-villes">Valence, Montélimar, Romans-sur-Isère, Crest, Die, Nyons, Pierrelatte, Loriol…</div>
          </div>
        </div>
        <div class="dept-card">
          <div class="dept-num">07</div>
          <div>
            <div class="dept-name">Ardèche</div>
            <div class="dept-villes">Aubenas, Privas, Annonay, Tournon-sur-Rhône, Largentière, Guilherand-Granges…</div>
          </div>
        </div>
      </div>
    </div>
    <div class="zone-visual reveal reveal-delay-2">
      <svg class="zone-map-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(197,216,109,0.6)" stroke-width="1.5">
        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
      </svg>
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--accent);margin-bottom:8px;">Drôme & Ardèche</div>
      <div style="font-size:13px;color:rgba(255,255,255,0.6);">Couverture complète des 2 départements</div>
      <div class="zone-chiffres">
        <div class="zone-chiffre"><span class="zone-chiffre-num">2</span><div class="zone-chiffre-lbl">Départements</div></div>
        <div class="zone-chiffre"><span class="zone-chiffre-num">30+</span><div class="zone-chiffre-lbl">Communes</div></div>
        <div class="zone-chiffre"><span class="zone-chiffre-num">72h</span><div class="zone-chiffre-lbl">Délai devis</div></div>
        <div class="zone-chiffre"><span class="zone-chiffre-num">0€</span><div class="zone-chiffre-lbl">Visite gratuite</div></div>
      </div>
    </div>
  </div>
</section>

<section id="devis" class="section-dark">
  <div class="devis-wrapper">
    <div class="devis-left">
      <div class="reveal"><span class="eyebrow eyebrow-accent">Devis gratuit</span></div>
      <h2 class="section-title section-title-light reveal reveal-delay-1">Parlez-nous de votre <em>projet</em></h2>
      <p class="section-sub section-sub-light reveal reveal-delay-2">Remplissez ce formulaire et nous vous recontactons sous 24h pour fixer une visite gratuite.</p>
      <ul class="devis-avantages reveal reveal-delay-3">
        <li>Visite gratuite sur site</li>
        <li>Devis remis sous 72h</li>
        <li>Aucun engagement</li>
      </ul>
    </div>
    <div class="devis-right reveal reveal-delay-2">
      <x-contact-form />
    </div>
  </div>
</section>

@include('partials.public.footer')

@vite('resources/js/audio-recorder.js')
</x-layouts.public>

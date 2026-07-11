@php $settings = \App\Models\Setting::current(); @endphp
<x-layouts.public
    title="Mentions légales — Créa'Max Paysage"
    description="Mentions légales du site Créa'Max Paysage."
    robots="noindex, follow"
>
<nav class="legal-nav">
  <a href="{{ route('home') }}" class="nav-logo">
    <div class="logo-mark"><svg viewBox="0 0 24 24"><path d="M12 2C8 2 5 5.5 5 9.5c0 5.5 7 12.5 7 12.5s7-7 7-12.5C19 5.5 16 2 12 2zm0 10a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg></div>
    <span class="logo-name">Créa'Max</span>
  </a>
  <a href="{{ route('home') }}" class="back-link">← Retour au site</a>
</nav>

<div class="page-wrap">
  <h1 class="page-title">Mentions légales</h1>
  <p class="page-date">En vigueur au 25 février 2026 — Conformément aux articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la Confiance dans l'économie numérique (LCEN).</p>

  <div class="ml-section">
    <h2>1. Éditeur du site</h2>
    <div class="info-card">
      <div class="info-row"><span class="info-key">Raison sociale</span><span class="info-val">{{ $settings->nom_entreprise }}</span></div>
      <div class="info-row"><span class="info-key">Nom commercial</span><span class="info-val">CREA'MAX</span></div>
      <div class="info-row"><span class="info-key">Forme juridique</span><span class="info-val">{{ $settings->forme_juridique === 'EI' ? 'Entrepreneur individuel (EI)' : $settings->forme_juridique }}</span></div>
      <div class="info-row"><span class="info-key">Dirigeant</span><span class="info-val">{{ $settings->dirigeant }}</span></div>
      <div class="info-row"><span class="info-key">Siège social</span><span class="info-val">{{ $settings->adresse }}, France</span></div>
      <div class="info-row"><span class="info-key">SIREN</span><span class="info-val">{{ $settings->siren }}</span></div>
      <div class="info-row"><span class="info-key">SIRET</span><span class="info-val">{{ $settings->siret }}</span></div>
      <div class="info-row"><span class="info-key">TVA intracommunautaire</span><span class="info-val">{{ $settings->tva_intra }}</span></div>
      <div class="info-row"><span class="info-key">Code NAF/APE</span><span class="info-val">{{ $settings->ape }} — Services d'aménagement paysager</span></div>
      <div class="info-row"><span class="info-key">Date de création</span><span class="info-val">25 février 2026</span></div>
      <div class="info-row"><span class="info-key">Zone d'intervention</span><span class="info-val">{{ $settings->zone_intervention }}</span></div>
      <div class="info-row"><span class="info-key">Téléphone</span><span class="info-val">{{ $settings->telephone ?? '[À CONFIRMER AVEC LE CLIENT]' }}</span></div>
      <div class="info-row"><span class="info-key">Email</span><span class="info-val">{{ $settings->email ?? '[À CONFIRMER AVEC LE CLIENT]' }}</span></div>
    </div>
  </div>

  <div class="ml-section">
    <h2>2. Hébergement</h2>
    <div class="alert">ℹ️ À compléter avec les informations de l'hébergeur définitif (nom, adresse, téléphone) avant mise en ligne.</div>
    <div class="info-card">
      <div class="info-row"><span class="info-key">Hébergeur</span><span class="info-val">[À CONFIRMER : nom de l'hébergeur]</span></div>
      <div class="info-row"><span class="info-key">Adresse</span><span class="info-val">[À CONFIRMER : adresse de l'hébergeur]</span></div>
      <div class="info-row"><span class="info-key">Site web</span><span class="info-val">[À CONFIRMER : URL de l'hébergeur]</span></div>
    </div>
  </div>

  <div class="ml-section">
    <h2>3. Propriété intellectuelle</h2>
    <p>L'ensemble de ce site — structure, textes, visuels, logos, icônes — est la propriété exclusive de {{ $settings->nom_entreprise }}, sauf mention contraire. Toute reproduction, représentation, modification ou exploitation, même partielle, est interdite sans autorisation écrite préalable.</p>
  </div>

  <div class="ml-section">
    <h2>4. Données personnelles (RGPD)</h2>
    <p>Les informations collectées via le formulaire de contact (nom, prénom, email, téléphone, commune, description du projet, message vocal le cas échéant) sont utilisées exclusivement pour répondre à la demande de devis ou de contact, et ne sont transmises à aucun tiers.</p>
    <h3>Responsable du traitement</h3>
    <p>{{ $settings->dirigeant }} — {{ $settings->nom_entreprise }} — {{ $settings->adresse }}</p>
    <h3>Durée de conservation</h3>
    <p>Les données sont conservées 3 ans à compter du dernier contact, sauf obligation légale contraire.</p>
    <h3>Vos droits</h3>
    <p>Conformément au RGPD (Règlement UE 2016/679) et à la loi Informatique et Libertés, vous disposez d'un droit d'accès, de rectification, d'effacement, de portabilité et d'opposition sur vos données. Pour exercer ces droits, contactez-nous à l'adresse : <strong>{{ $settings->email ?? '[À CONFIRMER : email pro]' }}</strong></p>
    <p>Si vous estimez que vos droits ne sont pas respectés, vous pouvez introduire une réclamation auprès de la <a href="https://www.cnil.fr" target="_blank" rel="noopener">CNIL</a>.</p>
  </div>

  <div class="ml-section">
    <h2>5. Cookies</h2>
    <p>Ce site n'utilise pas de cookies de traçage ou publicitaires. Des cookies techniques strictement nécessaires au fonctionnement du site peuvent être déposés sans consentement préalable conformément à la réglementation CNIL en vigueur.</p>
  </div>

  <div class="ml-section">
    <h2>6. Limitation de responsabilité</h2>
    <p>{{ $settings->nom_entreprise }} s'efforce d'assurer l'exactitude des informations publiées sur ce site. Toutefois, elle ne saurait être tenue responsable des erreurs ou omissions, ni des dommages résultant de l'utilisation de ces informations. Les liens hypertextes vers des sites tiers n'engagent pas la responsabilité de l'éditeur.</p>
  </div>

  <div class="ml-section">
    <h2>7. Droit applicable et juridiction</h2>
    <p>Les présentes mentions légales sont régies par le droit français. En cas de litige, les tribunaux français seront seuls compétents.</p>
  </div>
</div>

<footer style="background: var(--vert); color: rgba(255,255,255,0.5); text-align: center; padding: 24px; font-size: 12px;">
  © {{ now()->year }} {{ $settings->nom_entreprise }} — SIRET {{ $settings->siret }} — {{ $settings->adresse }}
  &nbsp;·&nbsp; <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.6);">Retour au site</a>
</footer>

</x-layouts.public>

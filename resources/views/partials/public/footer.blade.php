@php $settings = \App\Models\Setting::current(); @endphp
<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-brand">
      <div class="nav-logo">
        <div class="logo-mark"><svg viewBox="0 0 24 24"><path d="M12 2C8 2 5 5.5 5 9.5c0 5.5 7 12.5 7 12.5s7-7 7-12.5C19 5.5 16 2 12 2zm0 10a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg></div>
        <div><span class="logo-name">Créa'Max</span><span class="logo-sub" style="color:rgba(255,255,255,0.4);">Paysagiste</span></div>
      </div>
      <p>Paysagiste en Drôme et Ardèche. Création, aménagement et entretien de jardins pour particuliers et professionnels.</p>
      <p style="margin-top:12px;font-size:11px;color:rgba(255,255,255,0.35);line-height:1.7;">
        {{ $settings->nom_entreprise }} — {{ $settings->forme_juridique === 'EI' ? 'Entrepreneur individuel' : $settings->forme_juridique }}<br>
        {{ $settings->adresse }}<br>
        SIRET : {{ $settings->siret }} · TVA : {{ $settings->tva_intra }}<br>
        Zone : {{ $settings->zone_intervention }}
      </p>
    </div>
    <div>
      <div class="footer-col-title">Prestations</div>
      <ul class="footer-links">
        <li><a href="{{ route('home') }}#services">Création de jardins</a></li>
        <li><a href="{{ route('home') }}#services">Aménagement extérieur</a></li>
        <li><a href="{{ route('home') }}#services">Entretien & taille</a></li>
        <li><a href="{{ route('home') }}#services">Arrosage automatique</a></li>
        <li><a href="{{ route('home') }}#services">Espaces pros</a></li>
      </ul>
    </div>
    <div>
      <div class="footer-col-title">Navigation</div>
      <ul class="footer-links">
        <li><a href="{{ route('home') }}#apropos">À propos</a></li>
        <li><a href="{{ route('home') }}#portfolio">Réalisations</a></li>
        <li><a href="{{ route('home') }}#zone">Zone d'intervention</a></li>
        <li><a href="{{ route('home') }}#devis">Devis gratuit</a></li>
      </ul>
    </div>
    <div>
      <div class="footer-col-title">Contact</div>
      <ul class="footer-links">
        @if ($settings->telephone)
          <li><a href="tel:{{ $settings->telephone }}">📞 {{ $settings->telephone }}</a></li>
        @else
          <li><span style="opacity:0.45">📞 Téléphone à venir</span></li>
        @endif
        @if ($settings->email)
          <li><a href="mailto:{{ $settings->email }}">✉ {{ $settings->email }}</a></li>
        @else
          <li><span style="opacity:0.45">✉ Email à venir</span></li>
        @endif
        <li><span>📍 {{ $settings->adresse }}</span></li>
        @if ($settings->horaires)
          <li><span style="opacity:0.7">{{ $settings->horaires }}</span></li>
        @endif
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ now()->year }} {{ $settings->nom_entreprise }} — SIRET {{ $settings->siret }}. Tous droits réservés.</span>
    <span>
        <a href="{{ route('mentions-legales') }}" style="color:rgba(255,255,255,0.4);">Mentions légales</a>
        · <a href="{{ route('filament.admin.auth.login') }}" style="color:rgba(255,255,255,0.25);font-size:12px;">Espace pro</a>
    </span>
  </div>
</footer>

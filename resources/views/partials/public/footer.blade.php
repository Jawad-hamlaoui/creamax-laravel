@php $settings = \App\Models\Setting::current(); @endphp
<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-brand">
      <div class="nav-logo">
        <div class="logo-mark">
          @if ($settings->logo_path)
            <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Créa'Max Paysage" style="width:100%;height:100%;object-fit:contain;border-radius:50%;">
          @else
            <svg viewBox="0 0 24 24"><path d="M12 2C8 2 5 5.5 5 9.5c0 5.5 7 12.5 7 12.5s7-7 7-12.5C19 5.5 16 2 12 2zm0 10a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
          @endif
        </div>
        <div><span class="logo-name">Créa'Max</span><span class="logo-sub" style="color:rgba(255,255,255,0.4);">Paysagiste</span></div>
      </div>
      <p>Paysagiste en Drôme et Ardèche. Création, aménagement et entretien de jardins pour particuliers et professionnels.</p>
      <p style="margin-top:12px;font-size:11px;color:rgba(255,255,255,0.35);line-height:1.7;">
        {{ $settings->nom_entreprise }} — {{ $settings->forme_juridique === 'EI' ? 'Entrepreneur individuel' : $settings->forme_juridique }}<br>
        {{ $settings->adresse }}<br>
        SIRET : {{ $settings->siret }} · TVA : {{ $settings->tva_intra }}<br>
        Zone : {{ $settings->zone_intervention }}
      </p>
      @if ($settings->facebook_url || $settings->instagram_url)
        <div class="footer-social">
          @if ($settings->facebook_url)
            <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
            </a>
          @endif
          @if ($settings->instagram_url)
            <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            </a>
          @endif
        </div>
      @endif
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

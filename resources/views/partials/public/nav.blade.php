<nav id="navbar">
  <a href="{{ route('home') }}" class="nav-logo">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2C8 2 5 5.5 5 9.5c0 5.5 7 12.5 7 12.5s7-7 7-12.5C19 5.5 16 2 12 2zm0 10a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
    </div>
    <div>
      <span class="logo-name">Créa'Max</span>
      <span class="logo-sub">Paysagiste · 26 & 07</span>
    </div>
  </a>
  <ul class="nav-links">
    <li><a href="{{ route('home') }}#apropos">À propos</a></li>
    <li><a href="{{ route('home') }}#services">Services</a></li>
    <li><a href="{{ route('home') }}#portfolio">Réalisations</a></li>
    <li><a href="{{ route('home') }}#devis" class="btn-nav">Devis gratuit</a></li>
  </ul>
</nav>

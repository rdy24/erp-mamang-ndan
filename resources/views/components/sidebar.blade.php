<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="/dashboard">MAMANG NDAN</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="/dashboard">MM</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="{{ request()->routeIs('dashboard.') ? 'active' : '' }}"><a href="/dashboard" class="nav-link"><i
            class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <li class="menu-header">Manufacturing</li>
      <li class="{{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}"><a
          href="{{ route('dashboard.products') }}" class="nav-link"><i class="fas fa-fire"></i><span>Produk</span></a>
      </li>
      <li class="{{ request()->routeIs('dashboard.materials.*') ? 'active' : '' }}"><a
          href="{{ route('dashboard.materials') }}" class="nav-link"><i class="fas fa-fire"></i><span>Bahan
            Baku</span></a>
      </li>
    </ul>
  </aside>
</div>
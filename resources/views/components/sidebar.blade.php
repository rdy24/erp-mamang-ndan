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
                    href="{{ route('dashboard.products.index') }}" class="nav-link"><i
                        class="fas fa-box-open"></i><span>Produk</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.materials.*') ? 'active' : '' }}"><a
                    href="{{ route('dashboard.materials.index') }}" class="nav-link"><i
                        class="fas fa-beer"></i><span>Bahan
                        Baku</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.bom.*') ? 'active' : '' }}"><a
                    href="{{ route('dashboard.bom.index') }}" class="nav-link"><i
                        class="fas fa-archive"></i><span>BOM</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.manufacturing-orders.*') ? 'active' : '' }}"><a
                    href="{{ route('dashboard.manufacturing-orders.index') }}" class="nav-link"><i
                        class="fas fa-archive"></i><span>Manufacturing Orders</span></a>
            </li>
            <li class="menu-header">Purchase</li>
            <li class="{{ request()->routeIs('dashboard.vendors.*') ? 'active' : '' }}"><a
                    href="{{ route('dashboard.vendors.index') }}" class="nav-link"><i
                        class="fas fa-archive"></i><span>Vendors</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.purchase.*') ? 'active' : '' }}"><a
                    href="{{ route('dashboard.purchase.rfq') }}" class="nav-link"><i
                        class="fas fa-archive"></i><span>RFQ</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.purchase-order.*') ? 'active' : '' }}"><a
                    href="{{ route('dashboard.purchase-order.index') }}" class="nav-link"><i
                        class="fas fa-archive"></i><span>Purchase Order</span></a>
            </li>
        </ul>
    </aside>
</div>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/dashboard"> <img alt="image" src="{{ asset('admin/assets/img/logo.png') }}" class="header-logo" />
                <span class="logo-name">Test Laravel</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ Request::path() === 'dashboard' ? 'active' : '' }}">
                <a href="/" class="nav-link"><i data-feather="monitor"></i><span>Mahasiswa</span></a>
            </li>
        </ul>
    </aside>
</div>

@php
    $menus = [
        1 =>[ // Role Admin
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Penduduk', 'path'  => 'resident', 'icon' => 'fas fa-fw fa-table' ],
            (object )[ 'title' => 'Daftar Akun', 'path'  => 'account-list', 'icon' => 'fas fa-fw fa-user' ],
            (object )[ 'title' => 'Permintaan Akun', 'path'  => 'account-request', 'icon' => 'fas fa-fw fa-user' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        2 =>[ // Role Admin 2
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Penduduk', 'path'  => 'resident', 'icon' => 'fas fa-fw fa-table' ],
            (object )[ 'title' => 'Daftar Akun', 'path'  => 'account-list', 'icon' => 'fas fa-fw fa-user' ],
            (object )[ 'title' => 'Permintaan Akun', 'path'  => 'account-request', 'icon' => 'fas fa-fw fa-user' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        3 =>[ // Role Kasi Pembangunan
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        4 =>[ // Role Sekretaris Lurah
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        5 =>[ // Role Lurah
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        7 =>[ // Role Kasi Kesejahteraan Sosial
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        8 =>[ // Role Kasi Pemerintahan, Ketentraman dan Ketertiban Umum
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
        9 =>[ // Role Penduduk (user biasa)
            (object )[ 'title' => 'Dashboard', 'path'  => 'dashboard', 'icon' => 'fas fa-fw fa-tachometer-alt' ],
            (object )[ 'title' => 'Aduan Warga', 'path'  => 'complaint', 'icon' => 'fas fa-fw fa-scroll' ],
        ],
    ];
@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:#C0392B">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Aspirasi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @auth
        @foreach ($menus[auth()->user()->role_id] as $menu)
            <li class="nav-item {{ request()->is($menu->path.'*') ? 'active' : '' }}">
                <a class="nav-link" href="/{{ $menu->path }}">
                    <i class="{{ $menu->icon }}"></i>
                    <span>{{ $menu->title }}</span></a>
            </li>
        @endforeach
    @endauth

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

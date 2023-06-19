<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon">
            <img src="/img/plain_white.png" alt="Logo" class="logo-img">
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Magic Shirts') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">


    <li class="nav-item {{ str_contains(Route::currentRouteName(), 'dashboard.encomendas') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard.encomendas.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Encomendas</span>
        </a>
    </li>

    @can('viewAny', App\Models\User::class)
        <li class="nav-item {{ str_contains(Route::currentRouteName(), 'dashboard.users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.users.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Utilizadores</span>
            </a>
        </li>
    @endcan

    @can('viewAny', \App\Models\TshirtImage::class)
        <li class="nav-item {{ str_contains(Route::currentRouteName(), 'dashboard.tshirtImages') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.tshirtImages.index') }}">
                <i class="fas fa-fw fa-images"></i>
                <span>Imagens</span>
            </a>
        </li>
    @endcan

    @can('viewAny', \App\Models\Categoria::class)
        <li class="nav-item {{ str_contains(Route::currentRouteName(), 'dashboard.categorias') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.categorias.index') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Categorias</span>
            </a>
        </li>
    @endcan

    @can('viewAny', \App\Models\Cor::class)
        <li class="nav-item {{ str_contains(Route::currentRouteName(), 'dashboard.cores') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.cores.index') }}">
                <i class="fas fa-fw fa-palette"></i>
                <span>Cores</span>
            </a>
        </li>
    @endcan

    @can('is-admin')
        <li class="nav-item {{ Route::currentRouteName() == 'dashboard.precos.edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.precos.edit') }}">
                <i class="fas fa-fw fa-coins"></i>
                <span>Preços</span>
            </a>
        </li>
    @endcan


    @can('is-client-or-admin')
        <hr class="sidebar-divider">
        <li class="nav-item {{ Route::currentRouteName() == 'dashboard.profile' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.profile') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Perfil</span>
            </a>
        </li>
    @endcan




    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Loja</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

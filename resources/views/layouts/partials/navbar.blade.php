<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/plain_white.png') }}" width="30" height="30" class="d-inline-block align-top" alt=""
                loading="lazy">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0 d-flex">
                <li class="nav-item">
                </li>
                <!-- Authentication Links -->
                @guest

                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link"><i class="fa fa-user"></i> Iniciar Sessão</a>
                    </li>
                @else
                    @can('is-client')
                        <li class="nav-item">
                            <a href="{{ route('tshirts.criar-personalizada') }}" class="nav-link"><i class="fa fa-plus"></i> Nova T-shirt Personalizada</a>
                        </li>
                    @endcan
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->name }}
                          </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a>
                            @can('is-client-or-admin')
                                <a class="dropdown-item" href="{{ route('dashboard.profile') }}">Perfil</a>
                            @endcan
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Terminar Sessão
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li class="nav-item">
                    <a href="{{ route('carrinho') }}" class="nav-link"><i class="fa fa-shopping-cart"></i> Carrinho</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

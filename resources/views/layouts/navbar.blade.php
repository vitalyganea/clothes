<!-- resources/views/layouts/navbar.blade.php -->

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Clothes') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Route::is('shops.index')) active @endif" href="{{ route('shops.index')}}">Shops</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/shop') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <form class="d-flex position-relative" id="searchForm" action="{{ route('search') }}" method="GET">
                        <input class="form-control me-2" type="search" name="query" id="searchQuery" placeholder="Search Products or Shops" aria-label="Search">
                        <div id="searchResults" class="d-none position-absolute bg-white border rounded shadow-sm w-100" style="top: 100%; left: 0; z-index: 1000;"></div>
                    </form>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('shop.my-shops') }}">
                                My Shops
                            </a>
                            <div class="dropdown-item">
                                <!-- Links for each flag -->
                                <a href="{{ route('language.switch', ['lang' => 'ro']) }}">
                                    <img class="lang-flag" src="{{ asset('assets/flags/ro.svg') }}" alt="Romanian">
                                </a>
                                <a href="{{ route('language.switch', ['lang' => 'ru']) }}">
                                    <img class="lang-flag" src="{{ asset('assets/flags/ru.svg') }}" alt="Russian">
                                </a>
                                <a href="{{ route('language.switch', ['lang' => 'en']) }}">
                                    <img class="lang-flag" src="{{ asset('assets/flags/en.svg') }}" alt="English">
                                </a>
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<style>
    .lang-flag {
        width: 20px;
        height: 20px;
        cursor: pointer;
        margin-right: 10px; /* Space between flags */
    }

    .dropdown-item a {
        display: inline-block; /* Ensure links are inline */
        margin-right: 3px; /* Space between flags */
    }
</style>

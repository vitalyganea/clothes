<link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
<nav>
    <div class="nav-bar">
        <i class='bx bx-menu sidebarOpen'></i>
        <span class="logo navLogo"><a href="{{ url('/') }}">Clothes</a></span>

        <div class="menu">
            <div class="logo-toggle">
                <span class="logo"><a href="{{ url('/') }}">Clothes</a></span>
                <i class='bx bx-x siderbarClose'></i>
            </div>

            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a class="@if(Route::is('shops.index')) active @endif" href="{{ route('shops.index') }}">Shops</a></li>
            </ul>
        </div>

        <div class="darkLight-searchBox">
            <div class="dark-light">
                <i class='bx bx-moon moon'></i>
                <i class='bx bx-sun sun'></i>
            </div>

            <div class="searchBox">
                <div class="searchToggle">
                    <i class='bx bx-x cancel'></i>
                    <i class='bx bx-search search'></i>
                </div>

                <div class="search-field">
                    <input type="text" id="searchQuery" placeholder="Search...">
                    <i class='bx bx-search'></i>
                    <div id="searchResults" class="d-none position-absolute bg-white w-100" style="top: 100%; left: 0; z-index: 1000;"></div>
                </div>
            </div>

            <div class="searchBox">
                <div class="profileToggle">
                    @guest
                        <a href="{{route('login')}}">
                            @endguest
                            <div class="dark-light">
                                <i class='bx bx-user user' id="profileIcon"></i>
                            </div>
                            @guest
                        </a>
                    @endguest
                </div>

                @auth
                    <div class="profile-menu d-none position-absolute bg-white border rounded shadow-sm p-2 profile-div text-center" style="top: 100%; right: 0; z-index: 1000;">

                        <p>{{ Auth::user()->name }}</p>

                        <hr>
                        <a href="{{ route('wishlist.index') }}" class="d-block py-2 profile-link">Your wishlist</a>
                        <a href="{{ route('shop.my-shops') }}" class="d-block py-2 profile-link">My Shops</a>
                        <a href="{{ route('logout') }}" class="d-block py-2 profile-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
<script>
    const body = document.querySelector("body"),
        nav = document.querySelector("nav"),
        modeToggle = document.querySelector(".dark-light"),
        searchToggle = document.querySelector(".searchToggle"),
        profileToggle = document.querySelector(".profileToggle"),
        profileMenu = document.querySelector(".profile-menu"),
        sidebarOpen = document.querySelector(".sidebarOpen"),
        siderbarClose = document.querySelector(".siderbarClose");

    let getMode = localStorage.getItem("mode");
    if(getMode && getMode === "dark-mode"){
        body.classList.add("dark");
    } else if (getMode && getMode === "light-mode") {
        body.classList.add("light");
    }

    // Toggle dark and light mode
    modeToggle.addEventListener("click", () => {
        modeToggle.classList.toggle("active");
        if(body.classList.contains("dark")){
            body.classList.remove("dark");
            body.classList.add("light");
            localStorage.setItem("mode", "light-mode");
        } else if (body.classList.contains("light")){
            body.classList.remove("light");
            body.classList.add("dark");
            localStorage.setItem("mode", "dark-mode");
        } else {
            body.classList.add("dark");
            localStorage.setItem("mode", "dark-mode");
        }
    });

    // Toggle profile menu
    profileToggle.addEventListener("click", (e) => {
        profileMenu.classList.toggle("d-none");
        e.stopPropagation(); // Prevent closing when clicking inside the menu
    });

    // Close profile menu when clicking outside
    body.addEventListener("click", () => {
        if (!profileMenu.classList.contains("d-none")) {
            profileMenu.classList.add("d-none");
        }
    });

    // Prevent closing profile menu when clicking inside it
    profileMenu.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    // Search Toggle
    searchToggle.addEventListener("click", () => {
        searchToggle.classList.toggle("active");
        document.querySelector('#searchQuery').focus();
    });

    // Sidebar Toggle
    sidebarOpen.addEventListener("click", () => {
        nav.classList.add("active");
    });

    body.addEventListener("click", (e) => {
        let clickedElm = e.target;
        if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")) {
            nav.classList.remove("active");
        }
    });
</script>


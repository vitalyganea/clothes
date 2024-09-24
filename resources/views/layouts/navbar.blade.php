<link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
<nav>
    <div class="nav-bar">
        <i class='bx bx-menu sidebarOpen' ></i>
        <span class="logo navLogo"><a href="{{ url('/') }}">Clothes</a></span>

        <div class="menu">
            <div class="logo-toggle">
                <span class="logo"><a href="{{ url('/') }}">Clothes</a></span>
                <i class='bx bx-x siderbarClose'></i>
            </div>

            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a class="@if(Route::is('shops.index')) active @endif" href="{{ route('shops.index')}}">Shops</a></li>
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
                    <div id="searchResults" class="d-none position-absolute bg-white border rounded shadow-sm w-100" style="top: 100%; left: 0; z-index: 1000;"></div>
                </div>
            </div>
            <div class="dark-light">
                <i class='bx bx-user user'></i>
            </div>
        </div>
    </div>
</nav>
<script>
    const body = document.querySelector("body"),
        nav = document.querySelector("nav"),
        modeToggle = document.querySelector(".dark-light"),
        searchToggle = document.querySelector(".searchToggle"),
        sidebarOpen = document.querySelector(".sidebarOpen"),
        siderbarClose = document.querySelector(".siderbarClose");

    let getMode = localStorage.getItem("mode");
    if(getMode && getMode === "dark-mode"){
        body.classList.add("dark");
    }

    // js code to toggle dark and light mode
    modeToggle.addEventListener("click" , () =>{
        modeToggle.classList.toggle("active");
        body.classList.toggle("dark");

        // js code to keep user selected mode even page refresh or file reopen
        if(!body.classList.contains("dark")){
            localStorage.setItem("mode" , "light-mode");
        }else{
            localStorage.setItem("mode" , "dark-mode");
        }
    });

    // js code to toggle search box
    searchToggle.addEventListener("click" , () =>{
        searchToggle.classList.toggle("active");
    });


    //   js code to toggle sidebar
    sidebarOpen.addEventListener("click" , () =>{
        nav.classList.add("active");
    });

    body.addEventListener("click" , e =>{
        let clickedElm = e.target;

        if(!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")){
            nav.classList.remove("active");
        }
    });


</script>
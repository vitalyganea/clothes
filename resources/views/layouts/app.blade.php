<!-- resources/views/layouts/app.blade.php -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/custom.css') }}">
    <!-- Replace link with script for custom.js -->
    <script src="{{ mix('js/custom.js') }}" defer></script>

    <title>{{ config('app.name', 'Clothes') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
<div id="app">
    <!-- Include Navbar -->
    @include('layouts.navbar')

    <main class="py-4">
        <button id="scrollToTopBtn" class="btn" style="font-size:25px; display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000; background-color: black; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
        </button>
        @yield('content')
    </main>

    @stack('scripts')
    @include('layouts.footer')

</div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const scrollToTopBtn = document.getElementById("scrollToTopBtn");
        scrollToTopBtn.onclick = function () {
            window.scrollTo({top: 0, behavior: 'smooth'});
        };
        window.addEventListener('scroll', function () {
            if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
                scrollToTopBtn.style.opacity = 1; // Fade in
                scrollToTopBtn.style.visibility = "visible"; // Make it visible
            } else {
                scrollToTopBtn.style.opacity = 0; // Fade out
                scrollToTopBtn.style.visibility = "hidden"; // Hide it
            }
        });
    });
</script>
</html>

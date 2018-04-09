<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/app.css">
        <link rel='stylesheet' href="css/home.css">
        @yield('css')
        <script src='js/app.js'></script>
        <script src='js/home.js'></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Site navigation navbar -->
        @yield('navbar')
        <!-- Banner  -->
        <div class="banner">
            <div class="banner-title-background">
                <h1>@yield('pageTitle')</h1>
            </div>
        </div>
        <!-- Site body -->
        <div class="body">
            @yield('left_bar')
            @yield('body')
            @yield('right_bar')
        </div>
        <!-- Footer -->
        @yield('footer')
    </body>
</html>
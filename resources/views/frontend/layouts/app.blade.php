<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <title> | CibesLift</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('public/frontend/css/apps.css?v=0.1')}}">

        @stack('styles')

    </head>

    <body>

        @include('frontend/layouts/header')

        <main class="main">

            @yield('content')

            @include('frontend/layouts/footer')

        </main>

        <script src="{{asset('public/frontend/js/apps.js?v=0.1')}}"></script>

        @stack('script')

    </body>

</html>

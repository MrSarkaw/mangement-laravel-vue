<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>system mangement</title>
        <script src="{{ asset("js/app.js") }}" defer></script>

        <link rel="stylesheet" href="{{ asset("css/fai/css/all.css") }}">
        <link rel="stylesheet" href="{{ asset("css/main.css") }}">
        <link rel="stylesheet" href="{{ asset("css/gen_style.css") }}">


        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css" />
    </head>
    <body class="antialiased">
        <div id="app">
            <router-view></router-view>
        </div>
    </body>
</html>

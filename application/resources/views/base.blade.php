<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Teste DealerSites</title>

        {{-- Laravel Mix - CSS File --}}
        <link defer rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        @stack('styles')
    </head>

    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>

        {{-- Laravel Mix - JS File --}}
        <script defer src="{{ mix('js/app.js') }}"></script>

        @stack('scripts')
    </body>
</html>
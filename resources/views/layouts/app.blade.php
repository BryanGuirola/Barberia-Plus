<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Barbería Plus') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        label,
        .text-sm,
        .text-gray-600,
        .h2,
        .dark\:text-gray-400,
        .dark\:text-gray-600 {
            color: #1E212D !important;
        }

        body {
            background-color: #F3ECE7;
            color: #2E2E2E;
            font-family: 'Inter', sans-serif;
        }

        header.bg-white {
            background-color: #fff;
            border-bottom: 1px solid #D4A373;
        }
    </style>
</head>

<body>
    <div class="min-vh-100">
        @if(auth()->check())
        @switch(auth()->user()->rol)
        @case('cliente')
        @include('layouts.partials.navbar_cliente')
        @break
        @case('encargado')
        @include('layouts.partials.navbar_encargado')
        @break
        @case('Admin')
        @include('layouts.partials.navbar_admin')
        @break
        @endswitch
        @endif

        @hasSection('header')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4">
                @yield('header')
            </div>
        </header>
        @endif

        <main>
            @yield('content')
        </main>
    </div>
    @include('layouts.partials.footer')
</body>

</html>
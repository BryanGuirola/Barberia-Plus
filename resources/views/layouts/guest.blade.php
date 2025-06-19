<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Barbería Plus') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
           label,
        .text-sm,
        .text-gray-600,
        .h2
        .dark\:text-gray-400,
        .dark\:text-gray-600 {
            color: #1E212D !important;
        }
        :root {
            --color-bg: #F3ECE7;
            --color-primary: #B06C49;
            --color-accent: #D4A373;
            --color-detail: #A3B18A;
            --color-dark: #2E2E2D;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-dark);
        }

        .auth-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        .brand-logo {
            width: 64px;
            height: auto;
            display: block;
            margin: 0 auto 1.5rem;
        }

        a {
            color: var(--color-primary);
            text-decoration: none;
        }

        a:hover {
            color: var(--color-accent);
            text-decoration: underline;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--color-accent);
        }

        .text-muted {
            color: #5c5c5c !important;
        }
    </style>
</head>

<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center px-3">
        <div>
            <div class="text-center mb-3">
                <a href="/">
                    <img src="{{ asset('images/android-chrome-192x192.png') }}" alt="Logo Barbería Plus" class="brand-logo">
                </a>
            </div>

            <div class="auth-container w-100" style="max-width: 420px;">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>

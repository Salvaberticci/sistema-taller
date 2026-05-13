<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MecaniSmart AI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { 
                font-family: 'Outfit', sans-serif; 
                background-color: #0f172a; /* Slate 900 */
                color: #f8fafc; /* Slate 50 */
            }
            .premium-card {
                background-color: #1e293b; /* Slate 800 */
                border: 1px solid #334155; /* Slate 700 */
            }
        </style>
    </head>
    <body class="antialiased min-h-screen">
        <div class="min-h-screen bg-[#0f172a]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#1e293b] shadow-sm border-b border-slate-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-12">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

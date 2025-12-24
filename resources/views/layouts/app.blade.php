<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    {{-- Tambahkan 'flex flex-col' agar footer bisa didorong ke bawah --}}
    <div class="min-h-screen bg-gray-100 flex flex-col justify-between">
        
        {{-- Wrapper Konten Atas --}}
        <div>
            @include('layouts.navigation')

            @hasSection('header')
                <header class="bg-white shadow">
                    <div class="{{ request()->is('admin/*') ? 'w-full px-6 py-6' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6' }}">
                        @yield('header')
                    </div>
                </header>
            @endif

            <main class="{{ request()->is('admin/*') ? 'w-full px-6 py-6' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6' }}">
                @yield('content')
            </main>
        </div>

        {{-- Include Footer di Sini (Di luar wrapper konten atas) --}}
        @include('layouts.footer')
        
    </div>
</body>
</html>
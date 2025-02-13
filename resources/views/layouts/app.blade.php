<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FPA Event Calendar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-rich-text::styles theme="richtextlaravel" data-turbo-track="false"/>
</head>
<body class="font-sans antialiased bg-gradient-to-b from-white to-primary-50">
    <div class="min-h-screen flex flex-col">
        <x-flash-messages/>
        @include('layouts.navigation')
        <main class="grow pt-16">
            @isset($banner)
                {{ $banner }}
            @endisset
            <section class="max-w-6xl mx-auto px-4 py-4 pb-8 sm:px-6 lg:px-8">
                {{ $slot }}
            </section>
        </main>

        <x-footer/>
    </div>
</body>
</html>

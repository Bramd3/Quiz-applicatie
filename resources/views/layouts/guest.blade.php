<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|poppins:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background dark:bg-background-dark text-gray-900 dark:text-gray-100 font-sans min-h-screen antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center py-8">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-primary" />
            </a>
        </div>

        <div class="w-full max-w-md mt-6 px-6 py-8 bg-surface dark:bg-surface-dark shadow-soft rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
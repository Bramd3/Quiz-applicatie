<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'QuizApp') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">

        <!-- Header -->
        <header class="bg-purple-600 text-white shadow-md">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold">QuizApp</a>

                <nav class="space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="hover:underline">Inloggen</a>
                        <a href="{{ route('register') }}" class="hover:underline">Registreren</a>
                    @else
                        <span class="mr-4">Hallo, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:underline">Uitloggen</button>
                        </form>
                    @endguest
                </nav>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 py-8">
            <div class="max-w-4xl mx-auto px-6">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-300 py-4 text-center">
            <p>&copy; {{ date('Y') }} QuizApp - Alle rechten voorbehouden</p>
        </footer>
    </div>
</body>
</html>

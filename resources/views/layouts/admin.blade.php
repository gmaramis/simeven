<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GSJA Kairos Manado') }} - Admin - @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-cyan-50 via-blue-50 to-purple-50">
            <!-- Navigation -->
            <nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-cyan-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                                    GSJA Kairos Admin
                                </a>
                            </div>
                            <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="border-transparent text-gray-600 hover:text-cyan-600 hover:border-cyan-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.events.index') }}" 
                                   class="border-transparent text-gray-600 hover:text-cyan-600 hover:border-cyan-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300">
                                    Event
                                </a>
                                <a href="{{ route('admin.registrations.index') }}" 
                                   class="border-transparent text-gray-600 hover:text-cyan-600 hover:border-cyan-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300">
                                    Pendaftaran
                                </a>
                            </div>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                            <a href="{{ route('home') }}" 
                               class="text-gray-600 hover:text-cyan-600 transition-colors duration-300 text-sm font-medium">
                                Lihat Website
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 border border-green-400 text-green-800 px-6 py-4 rounded-2xl mb-6 relative shadow-lg">
                            <span class="block sm:inline font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-gradient-to-r from-red-100 to-pink-100 border border-red-400 text-red-800 px-6 py-4 rounded-2xl mb-6 relative shadow-lg">
                            <span class="block sm:inline font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>

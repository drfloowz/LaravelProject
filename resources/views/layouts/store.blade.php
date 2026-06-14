<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel Store'))</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold text-indigo-600 tracking-tight">
                        StoreFront
                    </a>
                    
                    <!-- Categories Links (Desktop) -->
                    <div class="hidden md:ml-10 md:flex md:space-x-6 overflow-x-auto">
                        <a href="{{ route('home') }}" class="{{ !request('category') ? 'text-indigo-600 border-indigo-600' : 'text-gray-500 border-transparent hover:text-gray-900' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Tüm Ürünler
                        </a>
                        @foreach($categories ?? [] as $category)
                            <a href="{{ route('home', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'text-indigo-600 border-indigo-600' : 'text-gray-500 border-transparent hover:text-gray-900' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium whitespace-nowrap">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-600 font-medium hidden md:block">Admin Panel</a>
                        @endif
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition-colors">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none" 
                                 style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Çıkış Yap</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Giriş Yap</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md transition-colors shadow-sm">Kayıt Ol</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Mobile Categories (Scrollable horizontal list) -->
        <div class="md:hidden border-t border-gray-100 overflow-x-auto pb-1">
            <div class="flex space-x-4 px-4 py-2">
                <a href="{{ route('home') }}" class="{{ !request('category') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }} text-sm whitespace-nowrap">Tüm Ürünler</a>
                @foreach($categories ?? [] as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'text-indigo-600 font-semibold' : 'text-gray-600' }} text-sm whitespace-nowrap">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <div class="mb-4 md:mb-0">
                &copy; {{ date('Y') }} StoreFront. Tüm hakları saklıdır.
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-gray-900">Hakkımızda</a>
                <a href="#" class="hover:text-gray-900">İletişim</a>
                <a href="#" class="hover:text-gray-900">Gizlilik Politikası</a>
            </div>
        </div>
    </footer>
</body>
</html>

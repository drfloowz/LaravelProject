<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 font-bold text-xl text-blue-600 dark:text-blue-400">
            Admin Panel
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 dark:bg-gray-700 font-medium' : '' }}">Dashboard</a>
            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-200 dark:bg-gray-700 font-medium' : '' }}">Categories</a>
            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 dark:bg-gray-700 font-medium' : '' }}">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-200 dark:bg-gray-700 font-medium' : '' }}">Orders</a>
        </nav>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ url('/') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-900 dark:hover:text-gray-100 mb-2">← Back to Site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 font-medium transition-colors">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center px-6">
            <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
        </header>

        <div class="p-6 flex-1 overflow-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>

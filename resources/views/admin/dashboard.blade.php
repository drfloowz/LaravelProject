@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow border border-gray-100 dark:border-gray-700">
        <h2 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name ?? 'Admin' }}!</h2>
        <p class="text-gray-600 dark:text-gray-400">This is your admin backoffice. Use the sidebar to manage categories, products, and orders.</p>
    </div>
@endsection

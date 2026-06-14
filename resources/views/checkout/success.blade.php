@extends('layouts.store')

@section('title', 'Siparişiniz Alındı - hepsUz')

@section('content')
<div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
    <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-8">
        <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>
    
    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl mb-4">Siparişiniz Alındı!</h1>
    <p class="text-lg text-gray-500 mb-8">Bizi tercih ettiğiniz için teşekkür ederiz. Siparişiniz başarıyla oluşturuldu ve en kısa sürede işleme alınacaktır.</p>
    
    <div class="bg-gray-50 rounded-2xl p-8 mb-8 border border-gray-200">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-2">Sipariş Numarası</p>
        <p class="text-3xl font-black text-indigo-600">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>
    
    <div class="flex justify-center space-x-4">
        <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 border border-transparent shadow-sm text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
            Alışverişe Devam Et
        </a>
    </div>
</div>
@endsection

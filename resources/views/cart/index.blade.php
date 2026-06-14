@extends('layouts.store')

@section('title', 'Sepetim - hepsUz')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Alışveriş Sepeti</h1>
    <p class="mt-2 text-sm text-gray-500">Sepetinizdeki ürünleri inceleyin ve siparişinizi tamamlayın.</p>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(count($cart) > 0)
    <div class="lg:flex lg:space-x-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @foreach($cart as $id => $item)
                        <li class="p-6 flex flex-col sm:flex-row sm:items-center">
                            <!-- Image -->
                            <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-xl overflow-hidden mb-4 sm:mb-0">
                                <img src="{{ $item['image_path'] ? asset('storage/' . $item['image_path']) : 'https://via.placeholder.com/200x200?text=Gorsel' }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            </div>
                            
                            <!-- Details -->
                            <div class="sm:ml-6 flex-1 flex flex-col sm:flex-row sm:justify-between items-center">
                                <div class="mb-4 sm:mb-0 text-center sm:text-left">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        <a href="{{ route('product.show', $item['slug']) }}" class="hover:text-indigo-600 transition-colors">{{ $item['name'] }}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">Birim Fiyat: ₺{{ number_format($item['price'], 2) }}</p>
                                </div>
                                
                                <div class="flex items-center space-x-4 sm:space-x-6">
                                    <!-- Quantity Update Form -->
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.submit();" class="px-3 py-2 bg-gray-50 text-gray-600 hover:text-indigo-600 hover:bg-gray-100 transition-colors">&minus;</button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_stock'] }}" class="w-12 sm:w-16 text-center border-y-0 border-x border-gray-300 p-0 py-2 focus:ring-0 sm:text-sm font-medium text-gray-900" onchange="this.form.submit()">
                                        <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.submit();" class="px-3 py-2 bg-gray-50 text-gray-600 hover:text-indigo-600 hover:bg-gray-100 transition-colors">&plus;</button>
                                    </form>

                                    <!-- Price -->
                                    <div class="text-lg font-bold text-gray-900 w-20 sm:w-24 text-right">
                                        ₺{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </div>

                                    <!-- Remove Form -->
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors p-2 rounded-full hover:bg-red-50" title="Sepetten Çıkar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Sipariş Özeti</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Ara Toplam</span>
                        <span class="font-medium text-gray-900">₺{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 border-b border-gray-200 pb-4">
                        <span>KDV (%20)</span>
                        <span class="font-medium text-gray-900">₺{{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-lg font-bold text-gray-900 pt-2">
                        <span>Genel Toplam</span>
                        <span class="text-indigo-600">₺{{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full flex items-center justify-center px-6 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md transform hover:-translate-y-0.5">
                    Siparişi Tamamla
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        &larr; Alışverişe Devam Et
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-24 bg-white border border-gray-200 rounded-2xl shadow-sm">
        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h3 class="mt-4 text-xl font-medium text-gray-900">Sepetiniz Boş</h3>
        <p class="mt-2 text-sm text-gray-500 mb-8">Henüz sepetinize hiç ürün eklemediniz. İhtiyacınız olan ürünleri bulmak için hemen mağazaya göz atın.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 border border-transparent shadow-md text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">
            Alışverişe Başla
        </a>
    </div>
@endif
@endsection

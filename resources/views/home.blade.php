@extends('layouts.store')

@section('title', 'Vitrin - StoreFront')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                @if(request('category'))
                    {{ collect($categories)->firstWhere('slug', request('category'))->name ?? 'Ürünler' }}
                @else
                    Tüm Ürünler
                @endif
            </h1>
            <p class="mt-2 text-sm text-gray-500">İhtiyacınız olan her şey burada.</p>
        </div>
    </div>

    @if($products->count() > 0)
        <!-- Modern Ürün Grid Sistemi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group relative">
                    <!-- Tüm Kart İçin Link -->
                    <a href="{{ url('/product/' . $product->slug) }}" class="absolute inset-0 z-0"><span class="sr-only">Ürünü İncele</span></a>
                    
                    <!-- Resim Alanı (Sabit Boyutlu) -->
                    <div class="relative w-full h-64 overflow-hidden bg-gray-50">
                        <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/400x400?text=Gorsel+Yok' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- Ürün Bilgileri -->
                    <div class="p-5 relative z-10">
                        <a href="{{ route('home', ['category' => $product->category->slug ?? '']) }}" class="inline-block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1 hover:underline">
                            {{ $product->category->name ?? 'Kategori' }}
                        </a>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 truncate">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-2xl font-extrabold text-gray-900 pointer-events-none">₺{{ number_format($product->price, 2) }}</span>
                            
                            <a href="{{ url('/product/' . $product->slug) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors pointer-events-auto">
                                İncele
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Boş Durum Ekranı -->
        <div class="text-center py-24 bg-white border border-gray-200 rounded-2xl">
            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Ürün Bulunamadı</h3>
            <p class="mt-2 text-sm text-gray-500">Bu kategoride şu an ürün bulunmamaktadır.</p>
        </div>
    @endif
@endsection
@extends('layouts.store')

@section('title', $product->name . ' - StoreFront')

@section('content')
    <div class="bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2 lg:w-3/5 border-b md:border-b-0 md:border-r border-gray-200 bg-gray-50 flex items-center justify-center p-8">
                <img src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://via.placeholder.com/800x800.png?text=Görsel+Yok' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-auto max-h-[600px] object-contain rounded-xl shadow-sm">
            </div>
            
            <!-- Product Details -->
            <div class="md:w-1/2 lg:w-2/5 p-8 lg:p-12 flex flex-col justify-center">
                <div class="mb-4">
                    <a href="{{ route('home', ['category' => $product->category->slug ?? '']) }}" class="text-sm font-semibold tracking-widest text-indigo-600 uppercase hover:text-indigo-800 transition-colors">
                        {{ $product->category->name ?? 'Kategori Yok' }}
                    </a>
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                    {{ $product->name }}
                </h1>
                
                <div class="flex items-center mb-6">
                    <div class="text-3xl font-black text-gray-900">
                        ₺{{ number_format($product->price, 2) }}
                    </div>
                </div>

                <div class="prose prose-sm sm:prose text-gray-600 mb-8 max-w-none">
                    <p class="whitespace-pre-line">{{ $product->description }}</p>
                </div>
                
                <div class="mt-auto">
                    <!-- Stock Status -->
                    <div class="mb-6 flex items-center space-x-3">
                        <span class="text-sm font-medium text-gray-700">Durum:</span>
                        @if($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Stokta ({{ $product->stock }} adet)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Tükendi
                            </span>
                        @endif
                    </div>

                    <!-- Add to Cart -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-4 mb-4">
                            <label for="quantity" class="text-sm font-medium text-gray-700">Miktar:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        </div>
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition-colors shadow-sm {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Sepete Ekle
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

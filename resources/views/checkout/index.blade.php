@extends('layouts.store')

@section('title', 'Güvenli Ödeme - hepsUz')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Güvenli Ödeme</h1>
    <p class="mt-2 text-sm text-gray-500">Teslimat bilgilerinizi doldurun ve siparişinizi onaylayın.</p>
</div>

@if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <div class="lg:flex lg:space-x-8">
        <!-- Adres Bilgileri Formu -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Teslimat Bilgileri</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', auth()->user()->name) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('full_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefon Numarası</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="05XX XXX XX XX">
                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Açık Adres</label>
                        <textarea name="address" id="address" rows="4" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Mahalle, Sokak, Bina No, Kapı No, İlçe, İl vb.">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sipariş Özeti -->
        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Sipariş Özeti</h2>
                
                <div class="mb-6 max-h-64 overflow-y-auto">
                    <ul class="divide-y divide-gray-200">
                        @foreach($cart as $item)
                        <li class="py-3 flex justify-between">
                            <div class="flex items-center">
                                <span class="text-sm font-bold text-gray-900">{{ $item['quantity'] }}x</span>
                                <span class="ml-2 text-sm text-gray-600 truncate max-w-[150px] sm:max-w-[180px]">{{ $item['name'] }}</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900">₺{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="space-y-4 mb-6 pt-4 border-t border-gray-200">
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

                <button type="submit" class="w-full flex items-center justify-center px-6 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md transform hover:-translate-y-0.5">
                    Siparişi Onayla
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

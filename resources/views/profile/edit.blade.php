@extends('layouts.store')

@section('title', 'Müşteri Paneli - hepsUz')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'account' }">
    
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('status') === 'profile-updated')
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Profil başarıyla güncellendi.</span>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Lütfen formdaki hataları kontrol edin.</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                <div class="p-6 bg-gray-50 border-b border-gray-200 text-center">
                    <div class="h-20 w-20 mx-auto bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl font-bold mb-4">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                <nav class="p-2 space-y-1">
                    <button @click="activeTab = 'account'" :class="{'bg-indigo-50 text-indigo-700': activeTab === 'account', 'text-gray-700 hover:bg-gray-100': activeTab !== 'account'}" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Hesap Bilgilerim
                    </button>
                    <button @click="activeTab = 'orders'" :class="{'bg-indigo-50 text-indigo-700': activeTab === 'orders', 'text-gray-700 hover:bg-gray-100': activeTab !== 'orders'}" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Siparişlerim
                        @if($user->orders->count() > 0)
                            <span class="ml-auto bg-indigo-100 text-indigo-600 py-0.5 px-2 rounded-full text-xs">{{ $user->orders->count() }}</span>
                        @endif
                    </button>
                    <button @click="activeTab = 'addresses'" :class="{'bg-indigo-50 text-indigo-700': activeTab === 'addresses', 'text-gray-700 hover:bg-gray-100': activeTab !== 'addresses'}" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Adreslerim
                    </button>
                    <button @click="activeTab = 'cards'" :class="{'bg-indigo-50 text-indigo-700': activeTab === 'cards', 'text-gray-700 hover:bg-gray-100': activeTab !== 'cards'}" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Kayıtlı Kartlarım
                    </button>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            
            <!-- Tab: Hesap Bilgilerim -->
            <div x-show="activeTab === 'account'" x-cloak class="space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Profil Bilgileri</h3>
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                            <input name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                            <input name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-gray-900 hover:bg-gray-800 transition-colors">
                                Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tab: Siparişlerim -->
            <div x-show="activeTab === 'orders'" x-cloak>
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Geçmiş Siparişlerim</h3>
                    
                    @if($user->orders->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <p class="text-gray-500">Henüz hiç sipariş vermediniz.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($user->orders as $order)
                                <div class="border border-gray-200 rounded-xl overflow-hidden" x-data="{ open: false }">
                                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between cursor-pointer hover:bg-gray-100" @click="open = !open">
                                        <div class="flex flex-col sm:flex-row sm:gap-8 mb-4 sm:mb-0">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Sipariş No</p>
                                                <p class="font-bold text-gray-900">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Tarih</p>
                                                <p class="font-medium text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Toplam Tutar</p>
                                                <p class="font-bold text-indigo-600">₺{{ number_format($order->total_amount, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'shipped' => 'bg-purple-100 text-purple-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Bekliyor',
                                                    'processing' => 'Onaylandı',
                                                    'shipped' => 'Kargoda',
                                                    'completed' => 'Teslim Edildi',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$order->status] }}">
                                                {{ $statusLabels[$order->status] }}
                                            </span>
                                            <svg class="h-5 w-5 text-gray-400 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                    <div x-show="open" x-collapse x-cloak class="border-t border-gray-200">
                                        <ul class="divide-y divide-gray-100">
                                            @foreach($order->items as $item)
                                            <li class="px-6 py-4 flex items-center">
                                                <div class="h-16 w-16 rounded-lg bg-gray-50 overflow-hidden">
                                                    <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://via.placeholder.com/150' }}" class="h-full w-full object-cover">
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <div class="flex justify-between font-medium text-gray-900">
                                                        <h3><a href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                                        <p>₺{{ number_format($item->price * $item->quantity, 2) }}</p>
                                                    </div>
                                                    <p class="text-sm text-gray-500">Adet: {{ $item->quantity }}</p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab: Adreslerim -->
            <div x-show="activeTab === 'addresses'" x-cloak x-data="{ showForm: false }">
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Kayıtlı Adreslerim</h3>
                        <button @click="showForm = !showForm" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2 rounded-lg transition-colors">
                            <span x-show="!showForm">+ Yeni Adres Ekle</span>
                            <span x-show="showForm">Vazgeç</span>
                        </button>
                    </div>

                    <!-- Yeni Adres Formu -->
                    <div x-show="showForm" x-collapse class="mb-8 border border-gray-200 p-6 rounded-xl bg-gray-50">
                        <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Adres Başlığı (Ev, İş)</label>
                                    <input type="text" name="baslik" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                                    <input type="text" name="ad_soyad" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telefon</label>
                                    <input type="text" name="telefon" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Şehir</label>
                                    <input type="text" name="sehir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">İlçe</label>
                                    <input type="text" name="ilce" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Açık Adres</label>
                                <textarea name="acik_adres" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700">Adresi Kaydet</button>
                            </div>
                        </form>
                    </div>

                    <!-- Mevcut Adresler -->
                    @if($user->addresses->isEmpty())
                        <p class="text-gray-500 text-center py-8">Kayıtlı adresiniz bulunmuyor.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->addresses as $address)
                            <div class="border border-gray-200 rounded-xl p-4 relative group hover:border-indigo-300 transition-colors">
                                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </form>
                                <h4 class="font-bold text-gray-900 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $address->baslik }}
                                </h4>
                                <p class="text-sm font-medium text-gray-800">{{ $address->ad_soyad }} - {{ $address->telefon }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $address->sehir }}, {{ $address->ilce }}</p>
                                <p class="text-sm text-gray-600 truncate">{{ $address->acik_adres }}</p>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab: Kayıtlı Kartlarım -->
            <div x-show="activeTab === 'cards'" x-cloak x-data="{ showForm: false }">
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Kayıtlı Kartlarım</h3>
                        <button @click="showForm = !showForm" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2 rounded-lg transition-colors">
                            <span x-show="!showForm">+ Yeni Kart Ekle</span>
                            <span x-show="showForm">Vazgeç</span>
                        </button>
                    </div>

                    <!-- Yeni Kart Formu -->
                    <div x-show="showForm" x-collapse class="mb-8 border border-gray-200 p-6 rounded-xl bg-gray-50">
                        <form action="{{ route('cards.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kart Üzerindeki İsim</label>
                                <input type="text" name="kart_sahibi" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="AD SOYAD">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kart Numarası</label>
                                <input type="text" name="kart_no" required maxlength="16" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="16 Haneli Numara">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ay (AA)</label>
                                    <input type="text" name="son_kullanma_ay" required maxlength="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="12">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Yıl (YYYY)</label>
                                    <input type="text" name="son_kullanma_yil" required maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="2028">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700">Kartı Kaydet</button>
                            </div>
                        </form>
                    </div>

                    <!-- Mevcut Kartlar -->
                    @if($user->savedCards->isEmpty())
                        <p class="text-gray-500 text-center py-8">Kayıtlı kartınız bulunmuyor.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->savedCards as $card)
                            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl p-6 relative group text-white shadow-md">
                                <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </form>
                                <svg class="w-10 h-10 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <p class="font-mono text-lg tracking-widest mb-2">**** **** **** {{ $card->son_dort_hane }}</p>
                                <div class="flex justify-between items-end text-sm text-gray-300">
                                    <p class="uppercase font-semibold tracking-wider">{{ $card->kart_sahibi }}</p>
                                    <p>{{ $card->son_kullanma_ay }}/{{ substr($card->son_kullanma_yil, -2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

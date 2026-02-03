<x-filament-panels::page>
    <style>
        .cart-item {
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <div class="space-y-6">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Left Panel - Product Selection & Cart -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Header Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <span class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </span>
                            Transaksi Penjualan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    <span class="flex items-center">
                                        <span class="text-lg mr-2">👤</span>
                                        Pelanggan
                                    </span>
                                </label>
                                <select wire:model="selectedCustomer" class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    <option value="">🛒 Pelanggan Umum</option>
                                    @foreach(\App\Models\Customer::where('is_active', true)->get() as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Product Search -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    <span class="flex items-center">
                                        <span class="text-lg mr-2">🔍</span>
                                        Cari Produk
                                    </span>
                                </label>
                                <select wire:model.live="productSearch" class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                                    <option value="">Pilih produk untuk ditambahkan...</option>
                                    @foreach(\App\Models\Product::where('is_active', true)->get() as $product)
                                        <option value="{{ $product->id }}">
                                            📦 {{ $product->name }} - 💰 Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-t-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                            <span class="text-2xl mr-3">🛒</span>
                            Keranjang Belanja 
                            @if(!empty($cart))
                                <span class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-500 text-white">
                                    {{ count($cart) }} item
                                </span>
                            @endif
                        </h3>
                    </div>

                    <div class="p-6">
                        @if(empty($cart))
                            <div class="text-center py-16">
                                <div class="mx-auto h-24 w-24 text-gray-300 dark:text-gray-600 mb-4">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Keranjang masih kosong</h3>
                                <p class="text-gray-500 dark:text-gray-400">Pilih produk dari dropdown di atas untuk memulai transaksi</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($cart as $index => $item)
                                <div class="cart-item flex items-center justify-between p-6 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-200">
                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $item['name'] }}</h4>
                                        <div class="mt-2 flex items-center space-x-3">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                                📋 {{ $item['code'] }}
                                            </span>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                📦 Stok: {{ $item['stock'] }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-lg font-bold text-green-600 dark:text-green-400">
                                            💰 Rp {{ number_format($item['price'], 0, ',', '.') }} / unit
                                        </p>
                                    </div>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-4 mx-6">
                                        <button 
                                            wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                            class="w-12 h-12 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-full transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                                        >
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        
                                        <div class="w-16 h-12 flex items-center justify-center bg-white dark:bg-gray-800 border-3 border-gray-300 dark:border-gray-600 rounded-lg shadow-inner">
                                            <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $item['quantity'] }}</span>
                                        </div>
                                        
                                        <button 
                                            wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                            class="w-12 h-12 flex items-center justify-center bg-green-500 hover:bg-green-600 text-white rounded-full transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                                        >
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Subtotal & Remove -->
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                            💵 Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>
                                        <button 
                                            wire:click="removeFromCart({{ $index }})"
                                            class="px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-600 dark:text-red-400 rounded-lg text-sm font-bold transition-colors duration-200"
                                        >
                                            🗑️ Hapus
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Panel - Payment Summary -->
            <div class="xl:col-span-1 space-y-6">
                <!-- Payment Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 rounded-t-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                            <span class="text-2xl mr-3">💰</span>
                            Ringkasan Pembayaran
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center py-3 border-b-2 border-gray-200 dark:border-gray-700">
                            <span class="text-lg font-semibold text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Discount -->
                        <div class="flex justify-between items-center py-3">
                            <span class="text-lg font-semibold text-gray-600 dark:text-gray-400">Diskon:</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500 font-medium">Rp</span>
                                <input 
                                    type="number" 
                                    wire:model.live="discount"
                                    class="w-24 px-3 py-2 text-lg font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-right transition-all duration-200"
                                    min="0"
                                    max="{{ $subtotal }}"
                                    placeholder="0"
                                >
                            </div>
                        </div>
                        
                        <!-- Tax -->
                        <div class="flex justify-between items-center py-3 border-b-2 border-gray-200 dark:border-gray-700">
                            <span class="text-lg font-semibold text-gray-600 dark:text-gray-400">Pajak:</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500 font-medium">Rp</span>
                                <input 
                                    type="number" 
                                    wire:model.live="tax"
                                    class="w-24 px-3 py-2 text-lg font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-right transition-all duration-200"
                                    min="0"
                                    placeholder="0"
                                >
                            </div>
                        </div>
                        
                        <!-- Total -->
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl p-6 border-2 border-green-300 dark:border-green-700 shadow-inner">
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-green-700 dark:text-green-300">TOTAL:</span>
                                <span class="text-4xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- Payment Input -->
                        <div class="space-y-3">
                            <label class="block text-lg font-bold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <span class="text-xl mr-2">💳</span>
                                    Dibayar:
                                </span>
                            </label>
                            <input 
                                type="number" 
                                wire:model.live="paid"
                                class="block w-full px-4 py-4 text-2xl font-bold text-right border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 shadow-inner"
                                min="0"
                                placeholder="0"
                            >
                        </div>
                        
                        <!-- Change -->
                        @if($paid > 0)
                        <div class="bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl p-6 border-2 border-blue-300 dark:border-blue-700 shadow-inner">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-blue-700 dark:text-blue-300">💸 Kembalian:</span>
                                <span class="text-3xl font-bold {{ $change >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }}">
                                    Rp {{ number_format($change, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 rounded-t-lg">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <span class="text-xl mr-2">⚡</span>
                            Aksi Cepat
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <button 
                                wire:click="setExactAmount"
                                class="px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                            >
                                <span class="flex items-center justify-center">
                                    <span class="mr-2">🎯</span>
                                    Uang Pas
                                </span>
                            </button>
                            
                            <button 
                                wire:click="setRoundedAmount"
                                class="px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                            >
                                <span class="flex items-center justify-center">
                                    <span class="mr-2">📈</span>
                                    Bulatkan
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Process Transaction Button -->
                <button 
                    wire:click="processTransaction"
                    @disabled(empty($cart) || $paid < $total)
                    class="w-full py-6 px-6 text-xl font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 disabled:transform-none disabled:shadow-none
                           {{ empty($cart) || $paid < $total 
                              ? 'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed' 
                              : 'bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white' }}"
                >
                    @if(empty($cart))
                        <span class="flex items-center justify-center">
                            <span class="text-2xl mr-3">🛒</span>
                            Tambahkan Produk
                        </span>
                    @elseif($paid < $total)
                        <span class="flex items-center justify-center">
                            <span class="text-2xl mr-3">⚠️</span>
                            Pembayaran Kurang
                        </span>
                    @else
                        <span class="flex items-center justify-center">
                            <span class="text-2xl mr-3">✅</span>
                            Proses Transaksi
                        </span>
                    @endif
                </button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
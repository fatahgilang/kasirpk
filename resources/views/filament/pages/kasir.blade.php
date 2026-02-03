<x-filament-panels::page>
    <div class="pos-system">
        <div class="pos-layout">
            <!-- Products Section -->
            <div class="products-panel">
                <!-- Header Section -->
                <div class="panel-header">
                    <div class="customer-selector">
                        <label for="customer">Pelanggan</label>
                        <select wire:model="selectedCustomer" id="customer">
                            <option value="">Pelanggan Umum</option>
                            @foreach($this->availableCustomers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="session-info">
                        <div class="date">{{ date('d/m/Y') }}</div>
                        <div class="time">{{ date('H:i') }}</div>
                        <div class="cashier">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                <!-- Search Section -->
                <div class="search-bar">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        <input 
                            type="text" 
                            wire:model.live="searchQuery"
                            placeholder="Cari produk..."
                            class="search-input"
                        >
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    @forelse($this->availableProducts as $product)
                        <div class="product-card" wire:click="addToCart({{ $product->id }})">
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <p class="product-code">{{ $product->code }}</p>
                            </div>
                            <div class="product-pricing">
                                <div class="product-price">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                                @if($product->track_stock)
                                    <div class="stock-badge stock-{{ $product->stock_quantity > 10 ? 'high' : ($product->stock_quantity > 0 ? 'medium' : 'low') }}">
                                        {{ $product->stock_quantity }}
                                    </div>
                                @else
                                    <div class="stock-badge stock-unlimited">∞</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="no-products">
                            <svg class="no-products-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p>Tidak ada produk ditemukan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart & Payment Section -->
            <div class="cart-panel">
                <!-- Cart Header -->
                <div class="cart-header">
                    <h2>Keranjang</h2>
                    @if(!empty($cart))
                        <button wire:click="clearCart" class="clear-cart-btn">Kosongkan</button>
                    @endif
                </div>

                <!-- Cart Items -->
                <div class="cart-items">
                    @if(empty($cart))
                        <div class="empty-cart">
                            <svg class="empty-cart-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15.5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6" />
                            </svg>
                            <p>Keranjang kosong</p>
                        </div>
                    @else
                        @foreach($cart as $index => $item)
                            <div class="cart-item">
                                <div class="item-details">
                                    <h4 class="item-name">{{ $item['name'] }}</h4>
                                    <div class="item-meta">
                                        <span class="item-code">{{ $item['code'] }}</span>
                                        <span class="item-unit-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <div class="quantity-section">
                                    <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})" class="qty-btn qty-minus">−</button>
                                    <span class="qty-display">{{ $item['quantity'] }}</span>
                                    <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})" class="qty-btn qty-plus">+</button>
                                </div>
                                
                                <div class="item-total">
                                    <div class="item-subtotal">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                                    <button wire:click="removeFromCart({{ $index }})" class="remove-item">×</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <!-- Summary -->
                    <div class="payment-summary">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Diskon</span>
                            <div class="input-with-currency">
                                <input 
                                    type="number" 
                                    wire:model.live="discount" 
                                    class="summary-input" 
                                    min="0" 
                                    max="100" 
                                    placeholder="0"
                                    step="1"
                                >
                                <span class="currency-label">%</span>
                            </div>
                        </div>
                        @if($discount > 0)
                            <div class="summary-breakdown">
                                <div class="breakdown-item discount">
                                    <span>Diskon {{ $discount }}%:</span>
                                    <span>-Rp {{ number_format($subtotal * $discount / 100, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Total -->
                    <div class="total-section">
                        <div class="total-label">TOTAL</div>
                        <div class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</div>
                    </div>

                    <!-- Payment Input -->
                    <div class="payment-input-section">
                        <label>Dibayar</label>
                        <div class="payment-input-wrapper">
                            <span class="payment-currency">Rp</span>
                            <input 
                                type="number" 
                                wire:model.live="paid" 
                                class="payment-input" 
                                min="0" 
                                placeholder="0"
                                step="1000"
                            >
                        </div>
                        @if($paid > 0)
                            <div class="payment-display">
                                Rp {{ number_format($paid, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <!-- Quick Payment -->
                    <div class="quick-payment">
                        <button wire:click="setExactAmount" class="quick-btn exact-btn">Uang Pas</button>
                        <button wire:click="setRoundedAmount" class="quick-btn round-btn">Bulatkan</button>
                    </div>

                    <!-- Change -->
                    @if($paid > 0)
                        <div class="change-section">
                            <span>Kembalian</span>
                            <span class="change-amount {{ $change >= 0 ? 'positive' : 'negative' }}">
                                Rp {{ number_format($change, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif

                    <!-- Process Button -->
                    <button 
                        wire:click="processTransaction"
                        @disabled(empty($cart) || $paid < $total)
                        class="process-btn {{ empty($cart) || $paid < $total ? 'disabled' : 'active' }}"
                    >
                        @if(empty($cart))
                            Tambah Produk
                        @elseif($paid < $total)
                            Bayar Kurang
                        @else
                            PROSES TRANSAKSI
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Reset and Base Styles */
        .pos-system {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: calc(100vh - 120px);
            background: #f5f7fa;
            padding: 16px;
            box-sizing: border-box;
        }

        .pos-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            min-height: calc(100vh - 152px);
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Products Panel */
        .products-panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .customer-selector label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .customer-selector select {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            padding: 10px 12px;
            font-size: 14px;
            min-width: 200px;
        }

        .customer-selector select option {
            background: #667eea;
            color: white;
        }

        .session-info {
            text-align: right;
            font-size: 14px;
        }

        .session-info .date {
            font-weight: 600;
            font-size: 16px;
        }

        .session-info .time {
            font-weight: 600;
            font-size: 16px;
            margin-top: 2px;
        }

        .session-info .cashier {
            opacity: 0.8;
            margin-top: 4px;
            font-size: 13px;
        }

        .search-bar {
            padding: 16px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-input-wrapper {
            position: relative;
            max-width: 400px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #64748b;
        }

        .search-input {
            width: 100%;
            padding: 12px 12px 12px 44px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .products-grid {
            flex: 1;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            overflow-y: auto;
            max-height: calc(100vh - 300px);
        }

        .product-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .product-name {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-code {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .product-pricing {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
        }

        .product-price {
            font-size: 16px;
            font-weight: 700;
            color: #059669;
        }

        .stock-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 12px;
            text-align: center;
            min-width: 24px;
        }

        .stock-high { background: #dcfce7; color: #166534; }
        .stock-medium { background: #fef3c7; color: #92400e; }
        .stock-low { background: #fee2e2; color: #991b1b; }
        .stock-unlimited { background: #f1f5f9; color: #475569; }

        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .no-products-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            color: #cbd5e1;
        }

        /* Cart Panel */
        .cart-panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            background: #1e293b;
            color: white;
        }

        .cart-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .clear-cart-btn {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .clear-cart-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            color: white;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 500px);
            min-height: 200px;
            padding: 16px;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
        }

        .empty-cart-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            color: #cbd5e1;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .item-details {
            flex: 1;
            min-width: 0;
        }

        .item-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .item-meta {
            display: flex;
            gap: 8px;
            font-size: 12px;
        }

        .item-code {
            color: #64748b;
        }

        .item-unit-price {
            color: #059669;
            font-weight: 500;
        }

        .quantity-section {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-minus {
            background: #fee2e2;
            color: #dc2626;
        }

        .qty-plus {
            background: #dcfce7;
            color: #16a34a;
        }

        .qty-btn:hover {
            transform: scale(1.1);
        }

        .qty-display {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            min-width: 24px;
            text-align: center;
        }

        .item-total {
            text-align: right;
            min-width: 80px;
        }

        .item-subtotal {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .remove-item {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 16px;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .remove-item:hover {
            background: #fee2e2;
        }

        /* Payment Section */
        .payment-section {
            padding: 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .payment-summary {
            margin-bottom: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .summary-row span:first-child {
            color: #475569;
            font-weight: 500;
        }

        .summary-row span:last-child {
            color: #1e293b;
            font-weight: 600;
        }

        .summary-value {
            color: #1e293b;
            font-weight: 600;
        }

        .summary-input {
            width: 100px;
            padding: 8px 10px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            text-align: right;
            font-size: 14px;
            font-weight: 600;
            background: white;
            color: #1e293b;
        }

        .summary-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-with-currency {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .currency-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }

        .summary-breakdown {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            font-size: 13px;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .breakdown-item.discount {
            background: #fee2e2;
            color: #991b1b;
        }

        .breakdown-item span:first-child {
            font-weight: 500;
        }

        .breakdown-item span:last-child {
            font-weight: 600;
        }

        .total-section {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 16px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 16px;
        }

        .total-label {
            font-size: 12px;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        .total-amount {
            font-size: 24px;
            font-weight: 700;
        }

        .payment-input-section {
            margin-bottom: 16px;
        }

        .payment-input-section label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .payment-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .payment-currency {
            position: absolute;
            left: 12px;
            font-size: 18px;
            font-weight: 600;
            color: #64748b;
            z-index: 1;
            pointer-events: none;
        }

        .payment-input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            font-size: 18px;
            font-weight: 600;
            text-align: right;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            background: white;
            color: #1e293b;
        }

        .payment-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .payment-display {
            margin-top: 8px;
            padding: 8px 12px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            color: #0369a1;
            text-align: center;
        }

        .quick-payment {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 16px;
        }

        .quick-btn {
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .exact-btn {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .round-btn {
            background: #e9d5ff;
            color: #7c3aed;
        }

        .quick-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .change-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #dbeafe;
            border-radius: 6px;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .change-section span:first-child {
            color: #1e40af;
        }

        .change-amount.positive {
            color: #059669;
            font-size: 16px;
        }

        .change-amount.negative {
            color: #dc2626;
            font-size: 16px;
        }

        .process-btn {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .process-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .process-btn.active:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .process-btn.disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .pos-layout {
                grid-template-columns: 1.5fr 1fr;
                gap: 16px;
                min-height: calc(100vh - 132px);
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 12px;
                padding: 16px;
                max-height: calc(100vh - 280px);
            }
            
            .product-card {
                height: 120px;
                padding: 12px;
            }

            .cart-items {
                max-height: calc(100vh - 480px);
                min-height: 180px;
            }
        }

        @media (max-width: 768px) {
            .pos-system {
                padding: 12px;
                min-height: calc(100vh - 80px);
            }
            
            .pos-layout {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto;
                gap: 12px;
                min-height: auto;
            }
            
            .panel-header {
                flex-direction: column;
                gap: 12px;
                text-align: center;
                padding: 16px;
            }
            
            .customer-selector {
                width: 100%;
            }
            
            .customer-selector select {
                width: 100%;
                min-width: auto;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 10px;
                padding: 12px;
                max-height: 50vh;
                min-height: 300px;
            }
            
            .product-card {
                height: 100px;
                padding: 10px;
            }
            
            .product-name {
                font-size: 13px;
            }
            
            .product-price {
                font-size: 14px;
            }
            
            .cart-panel {
                min-height: auto;
            }
            
            .cart-items {
                max-height: 40vh;
                min-height: 200px;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .quantity-section {
                justify-content: center;
            }
            
            .item-total {
                text-align: center;
                min-width: auto;
            }

            .payment-section {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .pos-system {
                padding: 8px;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 8px;
                padding: 8px;
                max-height: 45vh;
                min-height: 250px;
            }
            
            .product-card {
                height: 90px;
                padding: 8px;
            }
            
            .product-name {
                font-size: 12px;
            }
            
            .product-price {
                font-size: 13px;
            }
            
            .payment-input {
                font-size: 16px;
            }
            
            .total-amount {
                font-size: 20px;
            }

            .cart-items {
                max-height: 35vh;
                min-height: 150px;
            }

            .panel-header {
                padding: 12px;
            }

            .search-bar {
                padding: 12px;
            }

            .payment-section {
                padding: 12px;
            }
        }

        /* Scrollbar Styling */
        .products-grid::-webkit-scrollbar,
        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .products-grid::-webkit-scrollbar-track,
        .cart-items::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .products-grid::-webkit-scrollbar-thumb,
        .cart-items::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .products-grid::-webkit-scrollbar-thumb:hover,
        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-filament-panels::page>
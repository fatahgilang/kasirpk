<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input 
                        type="date" 
                        wire:model="startDate" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input 
                        type="date" 
                        wire:model="endDate" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    />
                </div>
                <div class="flex items-end">
                    <button 
                        wire:click="generateReport" 
                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition"
                    >
                        Tampilkan Laporan
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Revenue Card -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                <p class="text-2xl font-bold mt-2">{{ $reportData['revenue']['formatted'] ?? 'Rp 0' }}</p>
            </div>

            <!-- COGS Card -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-sm font-medium text-gray-500">Harga Pokok Penjualan</h3>
                <p class="text-2xl font-bold mt-2 text-red-600">{{ $reportData['cost_of_goods_sold']['formatted'] ?? 'Rp 0' }}</p>
            </div>

            <!-- Gross Profit Card -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-sm font-medium text-gray-500">Laba Kotor</h3>
                <p class="text-2xl font-bold mt-2 {{ ($reportData['gross_profit']['total'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $reportData['gross_profit']['formatted'] ?? 'Rp 0' }}
                </p>
            </div>

            <!-- Net Profit Card -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-sm font-medium text-gray-500">Laba Bersih</h3>
                <p class="text-2xl font-bold mt-2 {{ ($reportData['net_profit']['total'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $reportData['net_profit']['formatted'] ?? 'Rp 0' }}
                </p>
            </div>
        </div>

        <!-- Detailed Report -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium mb-4">Detail Laporan Laba Rugi</h3>
                
                @if(!empty($reportData))
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Periode</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $reportData['period']['start'] ?? '' }} - {{ $reportData['period']['end'] ?? '' }}
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Pendapatan</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-700">{{ $reportData['revenue']['formatted'] ?? 'Rp 0' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 pl-8">(-) Harga Pokok Penjualan</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-700">{{ $reportData['cost_of_goods_sold']['formatted'] ?? 'Rp 0' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">= Laba Kotor</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-700">{{ $reportData['gross_profit']['formatted'] ?? 'Rp 0' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 pl-8">(-) Biaya Operasional</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-700">{{ $reportData['expenses']['formatted'] ?? 'Rp 0' }}</td>
                            </tr>
                            <tr class="bg-blue-50 font-bold">
                                <td class="px-4 py-3 text-base font-bold text-gray-900">= Laba Bersih</td>
                                <td class="px-4 py-3 text-base font-bold text-right {{ ($reportData['net_profit']['total'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $reportData['net_profit']['formatted'] ?? 'Rp 0' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Margin Laba</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-700">
                                    {{ $reportData['profit_margin'] ?? 0 }}%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500 text-center py-8">Tidak ada data laporan. Silakan pilih periode dan klik "Tampilkan Laporan".</p>
                @endif
            </div>
        </div>

        <!-- Export Button -->
        <div class="bg-white rounded-lg shadow-sm border p-6 flex justify-end">
            <button 
                wire:click="exportToPdf" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Ekspor ke PDF
            </button>
        </div>
    </div>
</x-filament-panels::page>
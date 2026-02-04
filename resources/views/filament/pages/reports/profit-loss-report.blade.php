<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                Filter Laporan
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        Tanggal Mulai
                    </label>
                    <x-filament::input.wrapper class="mt-1">
                        <x-filament::input 
                            type="date" 
                            wire:model="startDate" 
                        />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        Tanggal Akhir
                    </label>
                    <x-filament::input.wrapper class="mt-1">
                        <x-filament::input 
                            type="date" 
                            wire:model="endDate" 
                        />
                    </x-filament::input.wrapper>
                </div>
                <div class="flex items-end">
                    <x-filament::button wire:click="generateReport">
                        Tampilkan Laporan
                    </x-filament::button>
                </div>
            </div>
        </x-filament::section>

        <!-- Stats Overview manual implementation -->
        <div class="fi-wi-stats-overview grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Pendapatan -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pendapatan</span>
                    </div>
                    <div class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                        {{ $reportData['revenue']['formatted'] ?? 'Rp 0' }}
                    </div>
                </div>
            </div>

            <!-- COGS -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Harga Pokok Penjualan</span>
                    </div>
                    <div class="text-2xl font-semibold tracking-tight text-danger-600 dark:text-danger-400">
                        {{ $reportData['cost_of_goods_sold']['formatted'] ?? 'Rp 0' }}
                    </div>
                </div>
            </div>

            <!-- Laba Kotor -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Laba Kotor</span>
                    </div>
                    <div class="text-2xl font-semibold tracking-tight {{ ($reportData['gross_profit']['total'] ?? 0) >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                        {{ $reportData['gross_profit']['formatted'] ?? 'Rp 0' }}
                    </div>
                </div>
            </div>

            <!-- Laba Bersih -->
            <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Laba Bersih</span>
                    </div>
                    <div class="text-2xl font-semibold tracking-tight {{ ($reportData['net_profit']['total'] ?? 0) >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                        {{ $reportData['net_profit']['formatted'] ?? 'Rp 0' }}
                    </div>
                </div>
            </div>
        </div>

        <x-filament::section>
            <x-slot name="heading">
                Detail Laporan Laba Rugi
            </x-slot>
            
            @if(!empty($reportData))
            <div class="fi-ta-content overflow-x-auto">
                <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium">Periode</td>
                            <td class="px-4 py-3 text-sm">
                                {{ $reportData['period']['start'] ?? '' }} - {{ $reportData['period']['end'] ?? '' }}
                            </td>
                        </tr>
                        <tr class="bg-gray-50/50 dark:bg-white/5">
                            <td class="px-4 py-3 text-sm font-medium">Pendapatan</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $reportData['revenue']['formatted'] ?? 'Rp 0' }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium pl-8">(-) Harga Pokok Penjualan</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $reportData['cost_of_goods_sold']['formatted'] ?? 'Rp 0' }}</td>
                        </tr>
                        <tr class="bg-gray-50/50 dark:bg-white/5">
                            <td class="px-4 py-3 text-sm font-medium">= Laba Kotor</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $reportData['gross_profit']['formatted'] ?? 'Rp 0' }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium pl-8">(-) Biaya Operasional</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $reportData['expenses']['formatted'] ?? 'Rp 0' }}</td>
                        </tr>
                        <tr class="bg-primary-50/50 dark:bg-primary-500/10 font-bold">
                            <td class="px-4 py-3 text-base font-bold text-primary-600">= Laba Bersih</td>
                            <td class="px-4 py-3 text-base font-bold text-right {{ ($reportData['net_profit']['total'] ?? 0) >= 0 ? 'text-success-600' : 'text-danger-600' }}">
                                {{ $reportData['net_profit']['formatted'] ?? 'Rp 0' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium">Margin Laba</td>
                            <td class="px-4 py-3 text-sm text-right">
                                {{ $reportData['profit_margin'] ?? 0 }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <div class="flex items-center justify-center py-12 text-gray-400">
                Tidak ada data laporan. Silakan pilih periode dan klik "Tampilkan Laporan".
            </div>
            @endif
        </x-filament::section>

        <div class="flex justify-end">
            <x-filament::button 
                wire:click="exportToPdf" 
                color="success"
                icon="heroicon-m-arrow-down-tray"
            >
                Ekspor ke PDF
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
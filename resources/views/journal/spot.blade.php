<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="py-12" x-data="spotJournalApp({ availableCash: {{ $stats['available_cash'] }} })">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Tabs -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-white">Trading Journal</h2>
                    <p class="text-gray-400 mt-1">Track your performance and master the markets.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Month Selector -->
                    <form method="GET" action="{{ route('journal.spot.index') }}" class="flex items-center">
                        <select name="month" onchange="this.form.submit()" class="bg-black/20 border border-white/10 text-white text-sm rounded-xl focus:ring-brand-orange focus:border-brand-orange block w-full py-2 px-4 cursor-pointer hover:bg-white/5 transition-colors">
                            @foreach($availableMonths as $month)
                                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Tab Switcher -->
                    <div class="bg-black/20 p-1 rounded-xl flex items-center">
                        <a href="{{ route('journal.index') }}" class="px-6 py-2 rounded-lg text-sm font-bold text-gray-400 hover:text-white transition-all">
                            Futures
                        </a>
                        <a href="{{ route('journal.spot.index') }}" class="px-6 py-2 rounded-lg text-sm font-bold bg-brand-orange text-white shadow-lg shadow-brand-orange/20 transition-all">
                            Spot
                        </a>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mb-8">
                <button @click="openModal('deposit')" class="flex-1 bg-green-500/10 hover:bg-green-500/20 border border-green-500/20 text-green-400 font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Deposit
                </button>
                <button @click="openModal('buy')" class="flex-1 bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/20 text-blue-400 font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Buy Coin
                </button>
                <button @click="openModal('sell')" class="flex-1 bg-orange-500/10 hover:bg-orange-500/20 border border-orange-500/20 text-orange-400 font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sell Coin
                </button>
                <button @click="openModal('withdraw')" class="flex-1 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Withdraw
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Cash Balance -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Cash Balance</p>
                    <h3 class="text-2xl font-black text-white">
                        Rp {{ number_format($stats['available_cash'] * $usdIdrRate, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">≈ ${{ number_format($stats['available_cash'], 2) }}</p>
                </div>

                <!-- Net Deposit -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Net Deposit</p>
                    <h3 class="text-2xl font-black text-white">
                        Rp {{ number_format($stats['net_deposit'] * $usdIdrRate, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">≈ ${{ number_format($stats['net_deposit'], 2) }}</p>
                </div>

                <!-- Total Asset -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Asset</p>
                    <h3 class="text-2xl font-black text-brand-orange" x-text="'Rp ' + formatNumber(totalCurrentValue * usdIdrRate, 0)">
                        Rp 0
                    </h3>
                    <p class="text-xs text-gray-500 mt-1" x-text="'≈ $' + formatNumber(totalCurrentValue)">≈ $0.00</p>
                </div>

                <!-- Unrealized PnL -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Unrealized PnL</p>
                    <h3 class="text-2xl font-black" :class="totalUnrealizedPnL >= 0 ? 'text-green-400' : 'text-red-400'" x-text="(totalUnrealizedPnL >= 0 ? '+' : '') + 'Rp ' + formatNumber(totalUnrealizedPnL * usdIdrRate, 0)">
                        Rp 0
                    </h3>
                    <p class="text-xs text-gray-500 mt-1" x-text="'≈ ' + (totalUnrealizedPnL >= 0 ? '+' : '') + '$' + formatNumber(totalUnrealizedPnL)">≈ $0.00</p>
                </div>

                <!-- Cost Basis -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Cost Basis</p>
                    <h3 class="text-2xl font-black text-white">
                        Rp {{ number_format($stats['total_holdings_value'] * $usdIdrRate, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">≈ ${{ number_format($stats['total_holdings_value'], 2) }}</p>
                </div>

                <!-- Current Value -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Current Value</p>
                    <h3 class="text-2xl font-black text-white" x-text="'Rp ' + formatNumber(totalCurrentValue * usdIdrRate, 0)">
                        Rp 0
                    </h3>
                    <p class="text-xs text-gray-500 mt-1" x-text="'≈ $' + formatNumber(totalCurrentValue)">≈ $0.00</p>
                </div>

                <!-- Realized PnL (All Time) -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Realized PnL (All Time)</p>
                    <h3 class="text-2xl font-black {{ $stats['realized_pnl'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $stats['realized_pnl'] >= 0 ? '+' : '' }}Rp {{ number_format($stats['realized_pnl'] * $usdIdrRate, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">≈ {{ $stats['realized_pnl'] >= 0 ? '+' : '' }}${{ number_format($stats['realized_pnl'], 2) }}</p>
                </div>

                <!-- Monthly Realized PnL -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Monthly Realized PnL</p>
                    <h3 class="text-2xl font-black {{ $stats['monthly_realized_pnl'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $stats['monthly_realized_pnl'] >= 0 ? '+' : '' }}Rp {{ number_format($stats['monthly_realized_pnl'] * $usdIdrRate, 0, ',', '.') }}
                    </h3>
                    <div class="flex justify-between items-end mt-1">
                        <p class="text-xs text-gray-500">≈ {{ $stats['monthly_realized_pnl'] >= 0 ? '+' : '' }}${{ number_format($stats['monthly_realized_pnl'], 2) }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Holdings Table -->
                <div class="lg:col-span-2 glass-card rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md overflow-hidden h-fit">
                    <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Current Holdings</h3>
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Live Prices (CoinGecko)
                        </span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Pie Chart -->
                        <div class="md:col-span-1 relative h-64 w-full flex items-center justify-center">
                            <canvas id="allocationChart"></canvas>
                            <!-- Center Text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Total Value</span>
                                <span class="text-xl font-black text-white" x-text="'$' + formatNumber(totalCurrentValue)"></span>
                            </div>
                        </div>
                        
                        <!-- Table -->
                        <div class="md:col-span-2 overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-white/5 bg-white/5">
                                    <th class="px-6 py-3">Pair</th>
                                    <th class="px-6 py-3 text-right">Qty</th>
                                    <th class="px-6 py-3 text-right">Avg Price</th>
                                    <th class="px-6 py-3 text-right">Cur. Price</th>
                                    <th class="px-6 py-3 text-right">PnL</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($holdings as $holding)
                                    <tr class="hover:bg-white/5 transition-colors" x-init="registerHolding({{ json_encode($holding['pair']) }}, {{ $holding['quantity'] }}, {{ $holding['avg_price'] }})">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-white">{{ $holding['pair'] }}</div>
                                            <div class="text-xs text-gray-500">Cost: ${{ number_format($holding['total_cost'], 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-300">
                                            {{ number_format($holding['quantity'], 4) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-300">
                                            ${{ number_format($holding['avg_price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-white">
                                            <span x-text="prices[{{ json_encode($holding['pair']) }}] ? '$' + formatNumber(prices[{{ json_encode($holding['pair']) }}]) : '...'">...</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold">
                                            <span x-show="prices[{{ json_encode($holding['pair']) }}]" 
                                                  :class="getPnL({{ json_encode($holding['pair']) }}) >= 0 ? 'text-green-400' : 'text-red-400'"
                                                  x-text="(getPnL({{ json_encode($holding['pair']) }}) >= 0 ? '+' : '') + '$' + formatNumber(getPnL({{ json_encode($holding['pair']) }}))">
                                            </span>
                                            <span x-show="!prices[{{ json_encode($holding['pair']) }}]" class="text-gray-500">...</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            No holdings yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                        </div>
                    </div>


                <!-- Transaction History -->
                <div class="glass-card rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md overflow-hidden h-fit">
                    <div class="px-6 py-4 border-b border-white/5">
                        <h3 class="text-lg font-bold text-white">History</h3>
                    </div>
                    <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                        <table class="w-full">
                            <tbody class="divide-y divide-white/5">
                                @forelse($transactions as $tx)
                                    <tr class="hover:bg-white/5 transition-colors group">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs font-bold px-2 py-0.5 rounded uppercase 
                                                            {{ $tx->type === 'deposit' ? 'bg-green-500/20 text-green-400' : '' }}
                                                            {{ $tx->type === 'withdraw' ? 'bg-red-500/20 text-red-400' : '' }}
                                                            {{ $tx->type === 'buy' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                                            {{ $tx->type === 'sell' ? 'bg-orange-500/20 text-orange-400' : '' }}
                                                        ">
                                                            {{ $tx->type }}
                                                        </span>
                                                        <span class="text-sm font-bold text-white">{{ $tx->pair ?? 'USDT' }}</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $tx->transaction_date->format('M d, H:i') }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-bold text-white">${{ number_format($tx->value, 2) }}</div>
                                                    @if($tx->pair)
                                                        <div class="text-xs text-gray-400">{{ number_format($tx->amount, 6) }} @ {{ number_format($tx->price, 2) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Edit/Delete (Visible on Hover) -->
                                            <div class="flex justify-end gap-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button @click="editTx({{ $tx->id }})" class="text-xs text-gray-400 hover:text-brand-orange">Edit</button>
                                                <form action="{{ route('journal.spot.destroy', $tx->id) }}" method="POST" onsubmit="return confirm('Delete?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-xs text-gray-400 hover:text-red-500">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-gray-500">No transactions.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 z-[999] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                    <div class="absolute inset-0 bg-gray-900 opacity-75 backdrop-blur-sm"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-[#0A1935] border border-white/10 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form :action="formAction" method="POST">
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">
                        <input type="hidden" name="type" x-model="form.type">
                        
                        <div class="px-6 py-6">
                            <h3 class="text-xl font-bold text-white mb-6">
                                <span x-text="isEdit ? 'Edit' : 'New'"></span> 
                                <span x-text="form.type.toUpperCase()"></span>
                            </h3>
                            
                            <div class="space-y-4">
                                <div x-show="['buy', 'sell'].includes(form.type)" class="relative">
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Pair / Coin</label>
                                    
                                    <!-- Searchable Dropdown -->
                                    <div class="relative">
                                        <input type="text" 
                                               x-model="searchQuery" 
                                               @input="filterCoins()" 
                                               @focus="showDropdown = true" 
                                               @click.away="showDropdown = false"
                                               class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" 
                                               placeholder="Search Coin (e.g. BTC)">
                                        
                                        <!-- Hidden Input for Form Submission -->
                                        <input type="hidden" name="pair" x-model="form.pair">

                                        <!-- Dropdown List -->
                                        <div x-show="showDropdown && filteredCoins.length > 0" 
                                             class="absolute z-50 mt-1 w-full bg-[#0F2445] border border-white/10 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                                            <template x-for="coin in filteredCoins" :key="coin.id">
                                                <div @click="selectCoin(coin)" class="px-4 py-3 hover:bg-white/5 cursor-pointer flex items-center gap-3 transition-colors">
                                                    <img :src="coin.image" class="w-6 h-6 rounded-full">
                                                    <div>
                                                        <div class="text-sm font-bold text-white" x-text="coin.name"></div>
                                                        <div class="text-xs text-gray-400" x-text="coin.symbol.toUpperCase()"></div>
                                                    </div>
                                                    <div class="ml-auto text-xs font-mono text-gray-300" x-text="'$' + formatNumber(coin.current_price)"></div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-1" x-show="form.pair">Selected: <span class="text-brand-orange font-bold" x-text="form.pair"></span></p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Date</label>
                                        <input type="date" name="transaction_date" x-model="form.transaction_date" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                    </div>
                                    <div x-show="['buy', 'sell'].includes(form.type)">
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Price ($)</label>
                                        <input type="number" step="any" name="price" x-model="form.price" @input="calculateValue()" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2" x-text="['buy', 'sell'].includes(form.type) ? 'Amount (Coin)' : 'Amount (USDT)'"></label>
                                    <input type="number" step="any" name="amount" x-model="form.amount" @input="calculateValue()" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                    
                                    <!-- Available Balance Helper -->
                                    <template x-if="form.type === 'sell' && form.pair && holdings[form.pair]">
                                        <div class="mt-1 text-right">
                                            <span class="text-[10px] text-gray-500">Available: 
                                                <span @click="form.amount = holdings[form.pair].qty; calculateValue()" class="text-brand-orange font-bold cursor-pointer hover:underline" x-text="holdings[form.pair].qty + ' ' + form.pair.split('/')[0]"></span>
                                            </span>
                                        </div>
                                    </template>
                                </div>

                                <div x-show="['buy', 'sell'].includes(form.type)">
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Total Value ($)</label>
                                    <input type="number" step="any" name="value" x-model="form.value" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                    
                                    <!-- Buy Percentage Slider -->
                                    <div x-show="form.type === 'buy'" class="mt-3">
                                        <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                                            <span>Available: <span class="text-white font-bold" x-text="'$' + formatNumber(availableCash)"></span></span>
                                            <span x-text="buyPercentage + '%'"></span>
                                        </div>
                                        <input type="range" min="0" max="100" step="25" x-model="buyPercentage" @input="updateBuyAmountFromPercentage()" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-brand-orange">
                                        <div class="flex justify-between text-[10px] text-gray-600 mt-1 px-1">
                                            <span>0%</span>
                                            <span>25%</span>
                                            <span>50%</span>
                                            <span>75%</span>
                                            <span>100%</span>
                                        </div>
                                    </div>
                                </div>
                                <input x-show="!['buy', 'sell'].includes(form.type)" type="hidden" name="value" x-model="form.value">

                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">TxID (Optional)</label>
                                    <input type="text" name="txid" x-model="form.txid" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" placeholder="Transaction Hash">
                                </div>
                            </div>
                        </div>
                        <div class="bg-black/20 px-6 py-4 flex flex-row-reverse gap-3">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-brand-orange text-base font-medium text-white hover:bg-orange-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Save
                            </button>
                            <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-white/10 shadow-sm px-4 py-2 bg-white/5 text-base font-medium text-gray-300 hover:bg-white/10 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chart; // Global chart instance

        function spotJournalApp(props = {}) {
            return {
                availableCash: props.availableCash || 0,
                usdIdrRate: props.usdIdrRate || 16000,

                // Dropdown Data
                searchQuery: '',
                showDropdown: false,
                allCoins: [], // Fetched from CoinGecko
                filteredCoins: [],
                
                // Data
                transactions: {!! json_encode($transactions) !!},
                
                // PnL Data
                holdings: {}, 
                prices: {}, 
                totalCurrentValue: 0,
                totalUnrealizedPnL: 0,
                
                // Dynamic Coin Map (Symbol -> ID)
                coinMap: {},

                // Modal & Form Data
                showModal: false,
                isEdit: false,
                formAction: '{{ route("journal.spot.store") }}',
                form: {
                    type: 'buy',
                    pair: '',
                    transaction_date: new Date().toISOString().split('T')[0],
                    price: '',
                    amount: '',
                    value: '',
                    txid: '',
                    notes: ''
                },
                buyPercentage: 0,



                async init() {
                    try {
                        await this.fetchCoinList();
                        
                        this.initChart();
                        
                        this.fetchPrices();
                        
                        setInterval(() => {
                            this.fetchPrices();
                        }, 60000);
                    } catch (e) {
                        console.error('Error in init:', e);
                    }
                },

                initChart() {
                    if (typeof Chart === 'undefined') {
                        console.error('Chart.js not loaded');
                        return;
                    }
                    
                    const canvas = document.getElementById('allocationChart');
                    if (!canvas) {
                        console.error('Canvas element not found');
                        return;
                    }

                    try {
                        const ctx = canvas.getContext('2d');
                        
                        // Destroy existing if any
                        if (chart) chart.destroy();

                        chart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: [],
                                datasets: [{
                                    data: [],
                                    backgroundColor: [
                                        '#F7931A', // BTC Orange
                                        '#627EEA', // ETH Blue
                                        '#14F195', // SOL Green
                                        '#F3BA2F', // BNB Yellow
                                        '#26A17B', // USDT Green
                                        '#E84142', // AVAX Red
                                        '#0033AD', // DOT Blue
                                        '#2775CA', // USDC Blue
                                        '#F0B90B', // DOGE Yellow
                                        '#8247E5'  // MATIC Purple
                                    ],
                                    borderWidth: 0,
                                    hoverOffset: 10,
                                    borderRadius: 5,
                                    spacing: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '85%', // Thinner ring
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(10, 25, 53, 0.9)',
                                        titleColor: '#fff',
                                        bodyColor: '#ccc',
                                        borderColor: 'rgba(255,255,255,0.1)',
                                        borderWidth: 1,
                                        padding: 12,
                                        cornerRadius: 8,
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                if (label) label += ': ';
                                                if (context.parsed !== null) {
                                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed);
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                animation: {
                                    animateScale: true,
                                    animateRotate: true
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error initializing chart:', error);
                    }
                },

                updateChart() {
                    if (!chart) return;

                    let labels = [];
                    let data = [];
                    let totalValue = 0;

                    // Add Holdings
                    for (let pair in this.holdings) {
                        let holding = this.holdings[pair];
                        let price = this.prices[pair] || holding.avg;
                        let value = holding.qty * price;
                        
                        if (value > 1) { 
                            labels.push(holding.symbol);
                            data.push(value);
                            totalValue += value;
                        }
                    }

                    chart.data.labels = labels;
                    if (chart.data.datasets[0]) {
                        chart.data.datasets[0].data = data;
                    }
                    
                    try {
                        chart.update();
                    } catch (e) {
                        console.warn('Chart update failed:', e);
                    }
                },

                async fetchCoinList() {
                    try {
                        // Fetch Top 100 Coins via Proxy
                        let response = await fetch('{{ route("journal.spot.proxy.coins") }}');
                        let data = await response.json();
                        this.allCoins = data;
                        this.filteredCoins = data;

                        // Build Coin Map for PnL
                        data.forEach(coin => {
                            this.coinMap[coin.symbol.toUpperCase()] = coin.id;
                        });
                    } catch (error) {
                        console.error('Error fetching coin list:', error);
                    }
                },

                filterCoins() {
                    let source = this.allCoins;

                    // If Selling, only show coins we hold
                    if (this.form.type === 'sell') {
                        const heldSymbols = Object.values(this.holdings)
                            .filter(h => h.qty > 0)
                            .map(h => h.symbol.toUpperCase());
                        
                        source = this.allCoins.filter(coin => heldSymbols.includes(coin.symbol.toUpperCase()));
                    }

                    if (this.searchQuery === '') {
                        this.filteredCoins = source;
                    } else {
                        this.filteredCoins = source.filter(coin => 
                            coin.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                            coin.symbol.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    }
                    this.showDropdown = true;
                    // Also allow manual typing if not found in list
                    this.form.pair = this.searchQuery.toUpperCase(); 
                },

                selectCoin(coin) {
                    this.form.pair = coin.symbol.toUpperCase();
                    this.searchQuery = coin.name; // Display name in input
                    this.form.price = coin.current_price; // Auto-fill price
                    
                    // Auto-fill amount if selling
                    if (this.form.type === 'sell' && this.holdings[this.form.pair]) {
                        this.form.amount = this.holdings[this.form.pair].qty;
                    }

                    this.showDropdown = false;
                    this.calculateValue();
                },

                registerHolding(pair, qty, avg) {
                    let symbol = pair.split('/')[0].toUpperCase();
                    this.holdings[pair] = { symbol: symbol, qty: parseFloat(qty), avg: parseFloat(avg) };
                },

                async fetchPrices() {
                    let ids = [];
                    let symbolToPair = {};

                    // Collect IDs using Dynamic Map
                    for (let pair in this.holdings) {
                        let symbol = this.holdings[pair].symbol;
                        let id = this.coinMap[symbol]; // Use dynamic map
                        
                        // Fallback for common coins if not in Top 100 (optional hardcoded list could be added here)
                        if (!id) {
                            // Try to guess ID (lowercase symbol) or skip
                             // id = symbol.toLowerCase(); 
                        }

                        if (id) {
                            ids.push(id);
                            symbolToPair[id] = pair;
                        }
                    }

                    if (ids.length === 0) return;

                    try {
                        let response = await fetch(`{{ route("journal.spot.proxy.prices") }}?ids=${ids.join(',')}`);
                        let data = await response.json();

                        this.totalCurrentValue = 0;
                        this.totalUnrealizedPnL = 0;

                        for (let id in data) {
                            let price = data[id].usd;
                            let pair = symbolToPair[id];
                            if (pair) {
                                this.prices[pair] = price;
                                
                                let holding = this.holdings[pair];
                                let currentValue = holding.qty * price;
                                let costBasis = holding.qty * holding.avg;
                                
                                this.totalCurrentValue += currentValue;
                                this.totalUnrealizedPnL += (currentValue - costBasis);
                            }
                        }
                        
                        this.updateChart(); // Update chart after prices fetch

                    } catch (error) {
                        console.error('Error fetching prices:', error);
                    }
                },

                getPnL(pair) {
                    if (!this.prices[pair] || !this.holdings[pair]) return 0;
                    let currentPrice = this.prices[pair];
                    let holding = this.holdings[pair];
                    return (currentPrice - holding.avg) * holding.qty;
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
                },

                openModal(type) {
                    this.isEdit = false;
                    this.formAction = '{{ route("journal.spot.store") }}';
                    this.resetForm();
                    this.form.type = type;
                    this.filterCoins(); // Init dropdown based on type
                    this.showModal = true;
                },

                editTx(id) {
                    const tx = this.transactions.find(t => t.id === id);
                    if (!tx) return;

                    this.isEdit = true;
                    this.formAction = '/journal/spot/' + tx.id;
                    this.form = {
                        type: tx.type,
                        pair: tx.pair,
                        transaction_date: tx.transaction_date.split('T')[0],
                        price: tx.price,
                        amount: tx.amount,
                        value: tx.value,
                        txid: tx.txid,
                        notes: tx.notes
                    };
                    this.searchQuery = tx.pair; // Pre-fill search
                    this.filterCoins(); // Init dropdown
                    this.showModal = true;
                },

                calculateValue() {
                    if (['buy', 'sell'].includes(this.form.type)) {
                        const price = parseFloat(this.form.price);
                        const amount = parseFloat(this.form.amount);
                        if (price && amount) {
                            this.form.value = (price * amount).toFixed(2);
                        }
                    } else {
                        this.form.value = this.form.amount;
                    }
                },

                updateBuyAmountFromPercentage() {
                    if (this.form.type !== 'buy') return;
                    
                    const percentage = parseInt(this.buyPercentage);
                    const value = (this.availableCash * (percentage / 100));
                    this.form.value = value.toFixed(2);
                    
                    if (this.form.price && this.form.price > 0) {
                        this.form.amount = (value / this.form.price).toFixed(6);
                    }
                }
            }
        }
    </script>
</x-app-layout>

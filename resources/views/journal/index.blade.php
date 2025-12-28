<x-app-layout>
    <div class="py-12" x-data="journalApp()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Stats -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-white">Trading Journal</h2>
                    <p class="text-gray-400 mt-1">Track your performance and master the markets.</p>
                </div>
                <button @click="openModal()" class="bg-brand-orange hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-brand-orange/20 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Record Trade
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <!-- Total PnL -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total PnL</p>
                    <h3 class="text-3xl font-black {{ $stats['total_pnl'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        ${{ number_format($stats['total_pnl'], 2) }}
                    </h3>
                </div>

                <!-- Win Rate -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Win Rate</p>
                    <h3 class="text-3xl font-black text-white">
                        {{ number_format($stats['win_rate'], 1) }}%
                    </h3>
                </div>

                <!-- Avg ROI -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Avg. ROI</p>
                    <h3 class="text-3xl font-black {{ $stats['avg_roi'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ number_format($stats['avg_roi'], 2) }}%
                    </h3>
                </div>

                <!-- Total Trades -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Trades</p>
                    <h3 class="text-3xl font-black text-white">
                        {{ $stats['total_trades'] }}
                    </h3>
                </div>
            </div>

            <!-- Trade History Table -->
            <div class="glass-card rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white">Recent Trades</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-white/5 bg-white/5">
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Pair</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3 text-right">Leverage</th>
                                <th class="px-6 py-3 text-right">Entry</th>
                                <th class="px-6 py-3 text-right">Exit</th>
                                <th class="px-6 py-3 text-right">PnL ($)</th>
                                <th class="px-6 py-3 text-right">ROI (%)</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($journals as $journal)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                        {{ $journal->trade_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">
                                        {{ $journal->pair }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $journal->direction === 'long' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                            {{ strtoupper($journal->direction) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-300">
                                        {{ $journal->leverage }}x
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-300 font-mono">
                                        {{ number_format($journal->entry_price, 4) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-300 font-mono">
                                        {{ number_format($journal->exit_price, 4) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold {{ $journal->pnl_value >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        ${{ number_format($journal->pnl_value, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold {{ $journal->pnl_percentage >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($journal->pnl_percentage, 2) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusColor = match($journal->status) {
                                                'win' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                                'loss' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                                'be' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                                            };
                                        @endphp
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusColor }}">
                                            {{ strtoupper($journal->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="editTrade({{ $journal }})" class="text-gray-400 hover:text-brand-orange transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('journal.destroy', $journal->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                        No trades recorded yet. Start your journey!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add/Edit Trade Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75 backdrop-blur-sm"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-[#0A1935] border border-white/10 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form :action="formAction" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">
                        
                        <div class="px-6 py-6">
                            <h3 class="text-xl font-bold text-white mb-6" x-text="isEdit ? 'Edit Trade' : 'Record New Trade'"></h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Pair</label>
                                    <input type="text" name="pair" x-model="form.pair" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" placeholder="BTC/USDT">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Date</label>
                                    <input type="date" name="trade_date" x-model="form.trade_date" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Direction</label>
                                    <select name="direction" x-model="form.direction" @change="calculatePnL()" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                        <option value="long">Long</option>
                                        <option value="short">Short</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Leverage</label>
                                    <input type="number" name="leverage" x-model="form.leverage" @input="calculatePnL()" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" placeholder="20">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Entry Price</label>
                                    <input type="number" step="any" name="entry_price" x-model="form.entry_price" @input="calculatePnL()" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Exit Price</label>
                                    <input type="number" step="any" name="exit_price" x-model="form.exit_price" @input="calculatePnL()" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Margin (USDT)</label>
                                    <input type="number" step="any" name="margin" x-model="form.margin" @input="calculatePnL()" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Status</label>
                                    <select name="status" x-model="form.status" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange">
                                        <option value="win">Win</option>
                                        <option value="loss">Loss</option>
                                        <option value="be">Break Even</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">PnL Value ($)</label>
                                    <input type="number" step="any" name="pnl_value" x-model="form.pnl_value" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" placeholder="-50.00">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">PnL Percentage (%)</label>
                                    <input type="number" step="any" name="pnl_percentage" x-model="form.pnl_percentage" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" placeholder="-25.5">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Notes</label>
                                    <textarea name="notes" x-model="form.notes" rows="3" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-brand-orange focus:ring-1 focus:ring-brand-orange" placeholder="Why did you take this trade?"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-black/20 px-6 py-4 flex flex-row-reverse gap-3">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-brand-orange text-base font-medium text-white hover:bg-orange-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Save Trade
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
        function journalApp() {
            return {
                showModal: false,
                isEdit: false,
                formAction: '{{ route("journal.store") }}',
                form: {
                    pair: '',
                    trade_date: new Date().toISOString().split('T')[0],
                    direction: 'long',
                    leverage: '',
                    entry_price: '',
                    exit_price: '',
                    margin: '',
                    status: 'win',
                    pnl_value: '',
                    pnl_percentage: '',
                    notes: ''
                },

                openModal() {
                    this.isEdit = false;
                    this.formAction = '{{ route("journal.store") }}';
                    this.resetForm();
                    this.showModal = true;
                },

                editTrade(trade) {
                    this.isEdit = true;
                    this.formAction = '/journal/' + trade.id;
                    this.form = {
                        pair: trade.pair,
                        trade_date: trade.trade_date.split('T')[0],
                        direction: trade.direction,
                        leverage: trade.leverage,
                        entry_price: trade.entry_price,
                        exit_price: trade.exit_price,
                        margin: trade.margin,
                        status: trade.status,
                        pnl_value: trade.pnl_value,
                        pnl_percentage: trade.pnl_percentage,
                        notes: trade.notes
                    };
                    this.showModal = true;
                },

                resetForm() {
                    this.form = {
                        pair: '',
                        trade_date: new Date().toISOString().split('T')[0],
                        direction: 'long',
                        leverage: '',
                        entry_price: '',
                        exit_price: '',
                        margin: '',
                        status: 'win',
                        pnl_value: '',
                        pnl_percentage: '',
                        notes: ''
                    };
                },

                calculatePnL() {
                    const entry = parseFloat(this.form.entry_price);
                    const exit = parseFloat(this.form.exit_price);
                    const margin = parseFloat(this.form.margin);
                    const leverage = parseFloat(this.form.leverage);

                    if (entry && exit && margin && leverage) {
                        let pnl = 0;
                        const quantity = (margin * leverage) / entry;

                        if (this.form.direction === 'long') {
                            pnl = (exit - entry) * quantity;
                        } else {
                            pnl = (entry - exit) * quantity;
                        }

                        const roi = (pnl / margin) * 100;

                        this.form.pnl_value = pnl.toFixed(2);
                        this.form.pnl_percentage = roi.toFixed(2);

                        // Auto-update status
                        if (pnl > 0) {
                            this.form.status = 'win';
                        } else if (pnl < 0) {
                            this.form.status = 'loss';
                        } else {
                            this.form.status = 'be';
                        }
                    }
                }
            }
        }
    </script>
</x-app-layout>

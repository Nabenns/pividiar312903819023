<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white">Position Size Calculator</h2>
                <p class="text-gray-400 mt-2">Calculate your crypto futures position with precision</p>
            </div>

            <div x-data="calculator()" class="space-y-6">
                
                <!-- Input Card -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md">
                    
                    <!-- Trade Direction -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Trade Direction</label>
                        <div class="grid grid-cols-2 gap-4 p-1 bg-black/20 rounded-xl">
                            <button @click="direction = 'long'" 
                                :class="direction === 'long' ? 'bg-green-600 text-white shadow-lg shadow-green-900/50' : 'text-gray-400 hover:text-white'"
                                class="py-3 rounded-lg font-bold transition-all duration-300">
                                Long
                            </button>
                            <button @click="direction = 'short'" 
                                :class="direction === 'short' ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:text-white'"
                                class="py-3 rounded-lg font-bold transition-all duration-300">
                                Short
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Entry Price -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Entry Price</label>
                            <div class="relative group">
                                <input type="number" step="any" x-model.number="entryPrice" 
                                    class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition-all"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <!-- Stop Loss -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Stop Loss</label>
                            <div class="relative group">
                                <input type="number" step="any" x-model.number="stopLoss" 
                                    class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition-all"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <!-- Risk Amount -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Risk Amount ($)</label>
                            <div class="relative group">
                                <input type="number" step="any" x-model.number="riskAmount" 
                                    class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition-all"
                                    placeholder="10">
                            </div>
                        </div>

                        <!-- Leverage -->
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Leverage (x)</label>
                            <div class="relative group">
                                <input type="number" step="1" x-model.number="leverage" 
                                    class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition-all"
                                    placeholder="10">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Card -->
                <div class="glass-card p-8 rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1" :class="direction === 'long' ? 'bg-green-500' : 'bg-red-500'"></div>
                    
                    <div class="text-center mb-8">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Position Size (USDT)</p>
                        <h3 class="text-5xl font-black text-white tracking-tight">
                            <span x-text="formatNumber(positionSize)">0</span> <span class="text-lg text-gray-500 font-medium">USDT</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="p-4 bg-black/20 rounded-xl border border-white/5">
                            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Quantity</p>
                            <p class="text-white font-bold text-lg" x-text="formatNumber(quantity)">0</p>
                        </div>
                        <div class="p-4 bg-black/20 rounded-xl border border-white/5">
                            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Margin Required</p>
                            <p class="text-white font-bold text-lg">$<span x-text="formatNumber(margin)">0</span></p>
                        </div>
                        <div class="p-4 bg-black/20 rounded-xl border border-white/5">
                            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Risk %</p>
                            <p class="text-white font-bold text-lg"><span x-text="formatNumber(riskPercentage)">0</span>%</p>
                        </div>
                        <div class="p-4 bg-black/20 rounded-xl border border-white/5">
                            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Distance to SL</p>
                            <p class="text-white font-bold text-lg"><span x-text="formatNumber(slDistance)">0</span>%</p>
                        </div>
                    </div>

                    <div class="mt-6 p-3 rounded-lg border text-center transition-colors duration-300"
                        :class="direction === 'long' ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-green-500/10 border-green-500/30 text-green-400'">
                        <p class="text-sm font-bold">Max Loss: $<span x-text="riskAmount">0</span></p>
                    </div>
                </div>

                <!-- TP Targets -->
                <div class="glass-card p-6 rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Take Profit Targets</h4>
                    
                    <div class="space-y-3">
                        <template x-for="(rr, index) in [1, 2, 3, 5]" :key="index">
                            <div class="flex items-center justify-between p-3 bg-black/20 rounded-lg border border-white/5 hover:border-white/10 transition-colors">
                                <div>
                                    <span class="text-xs font-bold text-gray-500 uppercase mr-2" x-text="'TP' + (index + 1)"></span>
                                    <span class="text-white font-mono font-bold" x-text="calculateTP(rr)">-</span>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-gray-400">R:R <span class="text-white font-bold" x-text="rr"></span></span>
                                    <span class="text-green-400 font-bold">+$<span x-text="formatNumber(riskAmount * rr)">0</span></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function calculator() {
            return {
                direction: 'long',
                entryPrice: null,
                stopLoss: null,
                riskAmount: 10,
                leverage: 10,

                get slDistance() {
                    if (!this.entryPrice || !this.stopLoss) return 0;
                    let dist = Math.abs(this.entryPrice - this.stopLoss) / this.entryPrice * 100;
                    return dist;
                },

                get positionSize() {
                    if (!this.slDistance || !this.riskAmount) return 0;
                    // Risk = PositionSize * (SL% / 100)
                    // PositionSize = Risk / (SL% / 100)
                    return this.riskAmount / (this.slDistance / 100);
                },

                get quantity() {
                    if (!this.positionSize || !this.entryPrice) return 0;
                    return this.positionSize / this.entryPrice;
                },

                get margin() {
                    if (!this.positionSize || !this.leverage) return 0;
                    return this.positionSize / this.leverage;
                },

                get riskPercentage() {
                    // Risk relative to margin
                    if (!this.margin || !this.riskAmount) return 0;
                    return (this.riskAmount / this.margin) * 100;
                },

                formatNumber(num) {
                    if (!num) return '0';
                    return new Intl.NumberFormat('en-US', { maximumFractionDigits: 2 }).format(num);
                },

                calculateTP(rr) {
                    if (!this.entryPrice || !this.stopLoss) return '-';
                    let riskDist = Math.abs(this.entryPrice - this.stopLoss);
                    let targetDist = riskDist * rr;
                    
                    let tpPrice;
                    if (this.direction === 'long') {
                        tpPrice = this.entryPrice + targetDist;
                    } else {
                        tpPrice = this.entryPrice - targetDist;
                    }
                    
                    return this.formatNumber(tpPrice);
                }
            }
        }
    </script>
</x-app-layout>

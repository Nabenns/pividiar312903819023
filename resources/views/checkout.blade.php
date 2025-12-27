<x-app-layout>
    <div class="min-h-screen py-12 flex items-center justify-center relative overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-brand-orange/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                {{-- Left Column: Plan Details & Value Prop --}}
                <div class="space-y-8">
                    <div>
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                            Complete Your <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-orange to-orange-400">Investment Journey</span>
                        </h2>
                        <p class="text-gray-400 text-lg">
                            You are one step away from accessing premium market insights and tools.
                        </p>
                    </div>

                    <div class="glass-card p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md">
                        <div class="flex items-baseline mb-6">
                            <span class="text-3xl font-bold text-white">{{ $plan->name }}</span>
                            <span class="ml-4 text-xl text-brand-orange font-medium capitalize">{{ $plan->billing_cycle }} Plan</span>
                        </div>

                        <ul class="space-y-4 mb-8">
                            @if(is_array($plan->features))
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-orange/20 flex items-center justify-center mt-1">
                                            <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="ml-3 text-gray-300">{{ $feature['name'] ?? $feature }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Secure SSL Encryption
                        </div>
                    </div>
                </div>

                {{-- Right Column: Order Summary & Payment --}}
                <div class="lg:pl-8">
                    <div class="glass-card rounded-3xl border border-white/10 bg-[#0b172e]/80 backdrop-blur-xl p-8 shadow-2xl relative overflow-hidden group" x-data="couponSystem()">
                        <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        
                        <h3 class="text-2xl font-bold text-white mb-6">Order Summary</h3>

                        <div class="space-y-4 mb-8 border-b border-white/10 pb-8">
                            <div class="flex justify-between items-center text-gray-300">
                                <span>{{ $plan->name }} ({{ ucfirst($plan->billing_cycle) }})</span>
                                <span class="font-medium text-white">IDR {{ number_format($plan->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-300">
                                <span>Tax (0%)</span>
                                <span class="font-medium text-white">IDR 0</span>
                            </div>
                            
                            <!-- Coupon Section -->
                            <div class="pt-4 border-t border-white/10 mt-4">
                                <div class="flex gap-2 mb-2" x-show="!appliedCoupon">
                                    <input type="text" x-model="couponCode" placeholder="Enter coupon code" 
                                        class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:ring-brand-orange focus:border-brand-orange placeholder-gray-500">
                                    <button @click="applyCoupon" :disabled="loading"
                                        class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                                        <span x-show="!loading">Apply</span>
                                        <span x-show="loading" class="animate-spin">↻</span>
                                    </button>
                                </div>
                                <p x-show="errorMessage" x-text="errorMessage" class="text-red-400 text-xs mt-1"></p>

                                <div x-show="appliedCoupon" class="flex justify-between items-center text-green-400 text-sm py-2 bg-green-500/10 px-3 rounded-lg border border-green-500/20">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Code <span x-text="appliedCoupon.code" class="font-bold"></span> applied
                                    </span>
                                    <button @click="removeCoupon" class="text-gray-400 hover:text-white">&times;</button>
                                </div>
                                
                                <div x-show="appliedCoupon" class="flex justify-between items-center text-green-400 mt-2">
                                    <span>Discount</span>
                                    <span class="font-medium">- IDR <span x-text="formatCurrency(appliedCoupon.discount_amount)"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-8">
                            <span class="text-lg font-bold text-white">Total Amount</span>
                            <span class="text-3xl font-bold text-brand-orange">IDR <span x-text="formatCurrency(currentTotal)">{{ number_format($plan->price, 0, ',', '.') }}</span></span>
                        </div>

                        <button id="pay-button" class="w-full py-4 px-6 bg-gradient-to-r from-brand-orange to-orange-600 hover:from-orange-500 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-brand-orange/25 transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center group">
                            <span>Pay Now</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </button>

                        <div class="mt-6 text-center">
                            <p class="text-xs text-gray-500 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Guaranteed Safe & Secure Checkout by Midtrans
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script>
            function couponSystem() {
                return {
                    couponCode: '{{ request('coupon_code') }}',
                    appliedCoupon: null,
                    originalTotal: {{ $plan->price }},
                    currentTotal: {{ $plan->price }},
                    loading: false,
                    errorMessage: '',

                    init() {
                        if (this.couponCode) {
                            this.validateOnLoad();
                        }
                    },

                    formatCurrency(value) {
                        return new Intl.NumberFormat('id-ID').format(value);
                    },

                    async validateOnLoad() {
                        this.loading = true;
                        try {
                            const response = await fetch('{{ route("coupon.validate") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    code: this.couponCode,
                                    total: this.originalTotal
                                })
                            });

                            const data = await response.json();

                            if (response.ok) {
                                this.appliedCoupon = data;
                                this.currentTotal = data.new_total;
                            } else {
                                this.errorMessage = data.message;
                                this.couponCode = '';
                            }
                        } catch (error) {
                            console.error(error);
                        } finally {
                            this.loading = false;
                        }
                    },

                    async applyCoupon() {
                        if (!this.couponCode) return;
                        this.loading = true;
                        this.errorMessage = '';

                        try {
                            const response = await fetch('{{ route("coupon.validate") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    code: this.couponCode,
                                    total: this.originalTotal
                                })
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                throw new Error(data.message || 'Invalid coupon');
                            }

                            // Reload page with coupon code to regenerate Snap Token
                            window.location.href = window.location.pathname + '?coupon_code=' + data.code;

                        } catch (error) {
                            this.errorMessage = error.message;
                            this.appliedCoupon = null;
                            this.currentTotal = this.originalTotal;
                            this.loading = false;
                        }
                    },

                    removeCoupon() {
                        window.location.href = window.location.pathname;
                    }
                }
            }
        </script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    onPending: function(result){
                        alert("Waiting for your payment!"); console.log(result);
                    },
                    onError: function(result){
                        alert("Payment failed!"); console.log(result);
                    },
                    onClose: function(){
                        alert('You closed the popup without finishing the payment');
                    }
                })
            };
        </script>
    @endpush
</x-app-layout>

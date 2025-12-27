<x-app-layout>
    <div class="relative min-h-screen overflow-hidden">
        <!-- Background Glows -->
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-1/4 w-[500px] h-[500px] bg-purple-900/20 rounded-full mix-blend-screen filter blur-[120px] animate-pulse"></div>
            <div class="absolute top-40 right-1/4 w-[400px] h-[400px] bg-indigo-600/10 rounded-full mix-blend-screen filter blur-[120px]"></div>
        </div>

        <div class="py-12 relative z-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Header -->
                <div class="mb-8 flex justify-between items-end">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">Affiliate Dashboard</h2>
                        <p class="text-gray-400">Track your earnings and manage your coupons.</p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Earnings -->
                    <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-transparent opacity-50"></div>
                        <div class="relative z-10">
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Total Earnings (Paid)</p>
                            <h3 class="text-3xl font-bold text-white">IDR {{ number_format($totalEarnings, 0, ',', '.') }}</h3>
                        </div>
                        <div class="absolute top-4 right-4 p-3 bg-green-500/10 rounded-xl text-green-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Pending Earnings -->
                    <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-transparent opacity-50"></div>
                        <div class="relative z-10">
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Pending Earnings</p>
                            <h3 class="text-3xl font-bold text-white">IDR {{ number_format($pendingEarnings, 0, ',', '.') }}</h3>
                        </div>
                        <div class="absolute top-4 right-4 p-3 bg-yellow-500/10 rounded-xl text-yellow-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Total Conversions -->
                    <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-50"></div>
                        <div class="relative z-10">
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-1">Total Conversions</p>
                            <h3 class="text-3xl font-bold text-white">{{ number_format($totalConversions) }}</h3>
                        </div>
                        <div class="absolute top-4 right-4 p-3 bg-blue-500/10 rounded-xl text-blue-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Coupons -->
                    <div class="lg:col-span-1 space-y-6">
                        <h3 class="text-xl font-bold text-white">Your Coupons</h3>
                        
                        @forelse($coupons as $coupon)
                            <div class="glass-card p-6 rounded-2xl border border-white/10 relative group hover:border-brand-orange/50 transition-colors">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-2xl font-mono font-bold text-brand-orange tracking-wider">{{ $coupon->code }}</h4>
                                        <p class="text-sm text-gray-400 mt-1">
                                            Discount: 
                                            <span class="text-white">
                                                {{ $coupon->discount_type === 'percent' ? $coupon->discount_amount . '%' : 'IDR ' . number_format($coupon->discount_amount) }}
                                            </span>
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 text-xs font-bold rounded-full border border-green-500/20">Active</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-sm text-gray-400 pt-4 border-t border-white/10">
                                    <span>Commission Rate:</span>
                                    <span class="text-white font-medium">
                                        {{ $coupon->commission_type === 'percent' ? $coupon->commission_amount . '%' : 'IDR ' . number_format($coupon->commission_amount) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-gray-400 mt-2">
                                    <span>Uses:</span>
                                    <span class="text-white font-medium">{{ $coupon->uses }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="glass-card p-8 rounded-2xl text-center border border-dashed border-white/10">
                                <p class="text-gray-400">You don't have any active coupons yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Right Column: Commission History -->
                    <div class="lg:col-span-2 space-y-6">
                        <h3 class="text-xl font-bold text-white">Commission History</h3>

                        <div class="glass-card rounded-2xl overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-gray-400">
                                    <thead class="bg-white/5 text-xs uppercase text-gray-300 font-bold">
                                        <tr>
                                            <th class="px-6 py-4">Date</th>
                                            <th class="px-6 py-4">Transaction</th>
                                            <th class="px-6 py-4">Commission</th>
                                            <th class="px-6 py-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @forelse($commissions as $commission)
                                            <tr class="hover:bg-white/5 transition">
                                                <td class="px-6 py-4">{{ $commission->created_at->format('d M Y') }}</td>
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-col">
                                                        <span class="text-white font-medium">{{ $commission->transaction->plan->name ?? 'Unknown Plan' }}</span>
                                                        <span class="text-xs text-gray-500">TRX-{{ substr($commission->transaction->midtrans_order_id ?? 'N/A', -6) }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-white font-bold">IDR {{ number_format($commission->amount, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                                        {{ $commission->status === 'paid' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 
                                                           ($commission->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20') }}">
                                                        <span class="w-1.5 h-1.5 rounded-full {{ $commission->status === 'paid' ? 'bg-green-400' : ($commission->status === 'pending' ? 'bg-yellow-400' : 'bg-red-400') }}"></span>
                                                        {{ ucfirst($commission->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No commissions recorded yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($commissions->hasPages())
                                <div class="p-4 border-t border-white/5">
                                    {{ $commissions->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

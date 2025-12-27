<x-app-layout>
    <div class="relative min-h-screen overflow-hidden">
        <!-- Background Glows -->
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-1/4 w-[500px] h-[500px] bg-blue-900/20 rounded-full mix-blend-screen filter blur-[120px] animate-pulse"></div>
            <div class="absolute top-40 right-1/4 w-[400px] h-[400px] bg-orange-600/10 rounded-full mix-blend-screen filter blur-[120px]"></div>
        </div>



        <div class="py-12 relative z-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Stats & History -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Stat 1 -->
                            <div class="glass-card p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-xl bg-brand-orange/10 text-brand-orange">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Active Days</p>
                                        <p class="text-2xl font-bold text-white">{{ $activeDays }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat 2 -->
                            <div class="glass-card p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-xl bg-blue-500/10 text-blue-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Lessons</p>
                                        <p class="text-2xl font-bold text-white">{{ $lessonsCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat 3 -->
                            <div class="glass-card p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-xl bg-green-500/10 text-green-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Spent</p>
                                        <p class="text-2xl font-bold text-white">IDR {{ number_format($totalSpent / 1000, 0) }}k</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction History -->
                        <div class="glass-card rounded-3xl overflow-hidden">
                            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-white">Transaction History</h3>
                                <button class="text-sm text-brand-orange hover:text-white transition font-medium">View All</button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-gray-400">
                                    <thead class="bg-white/5 text-xs uppercase text-gray-300 font-bold">
                                        <tr>
                                            <th class="px-6 py-4">Date</th>
                                            <th class="px-6 py-4">Plan</th>
                                            <th class="px-6 py-4">Amount</th>
                                            <th class="px-6 py-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @forelse($transactions as $transaction)
                                            <tr class="hover:bg-white/5 transition">
                                                <td class="px-6 py-4">{{ $transaction->created_at->format('d M Y') }}</td>
                                                <td class="px-6 py-4 text-white font-medium">{{ $transaction->plan->name }}</td>
                                                <td class="px-6 py-4">IDR {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                                        {{ $transaction->status === 'paid' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 
                                                           ($transaction->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20') }}">
                                                        <span class="w-1.5 h-1.5 rounded-full {{ $transaction->status === 'paid' ? 'bg-green-400' : ($transaction->status === 'pending' ? 'bg-yellow-400' : 'bg-red-400') }}"></span>
                                                        {{ ucfirst($transaction->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                                    No transactions found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Subscription -->
                    <div class="lg:col-span-1">
                        <div class="glass-card rounded-3xl p-1 bg-gradient-to-b from-white/10 to-transparent">
                            <div class="bg-[#0b172e]/80 rounded-[22px] p-6 h-full relative overflow-hidden backdrop-blur-xl">
                                <!-- Background Glow -->
                                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-brand-orange/20 blur-3xl rounded-full pointer-events-none"></div>

                                <h3 class="text-lg font-bold text-white mb-6 relative z-10">My Subscription</h3>

                                @if(auth()->user()->activeSubscription)
                                    <div class="text-center py-8 relative z-10">
                                        <div class="inline-block p-4 rounded-full bg-brand-orange/10 mb-4 ring-1 ring-brand-orange/20">
                                            <svg class="w-12 h-12 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-2xl font-bold text-white mb-1">{{ auth()->user()->activeSubscription->plan->name }}</h4>
                                        <p class="text-sm text-green-400 font-bold bg-green-500/10 px-3 py-1 rounded-full inline-block mb-6 border border-green-500/20">Active Member</p>
                                        
                                        <div class="space-y-3 text-sm text-gray-400">
                                            <div class="flex justify-between border-b border-white/5 pb-2">
                                                <span>Started</span>
                                                <span class="text-white font-medium">{{ auth()->user()->activeSubscription->created_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex justify-between border-b border-white/5 pb-2">
                                                <span>Renews</span>
                                                <span class="text-white font-medium">{{ auth()->user()->activeSubscription->ends_at->format('d M Y') }}</span>
                                            </div>
                                        </div>

                                        <button class="mt-8 w-full py-3 rounded-xl border border-white/10 text-white font-bold hover:bg-white/5 transition">
                                            Manage Subscription
                                        </button>
                                    </div>
                                @elseif(auth()->user()->hasAnyRole(['admin', 'premium']))
                                    <div class="text-center py-8 relative z-10">
                                        <div class="inline-block p-4 rounded-full bg-brand-orange/10 mb-4 ring-1 ring-brand-orange/20">
                                            <svg class="w-12 h-12 text-brand-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-2xl font-bold text-white mb-1">Premium Member</h4>
                                        <p class="text-sm text-green-400 font-bold bg-green-500/10 px-3 py-1 rounded-full inline-block mb-6 border border-green-500/20">
                                            {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                                        </p>
                                        
                                        <p class="text-gray-400 text-sm mb-6">You have premium access via role assignment.</p>
                                    </div>
                                @else
                                    <div class="text-center py-8 relative z-10">
                                        <div class="inline-block p-4 rounded-full bg-white/5 mb-4 ring-1 ring-white/10">
                                            <svg class="w-12 h-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-white mb-2">No Active Plan</h4>
                                        <p class="text-gray-400 text-sm mb-6">Unlock premium features and start your trading journey today.</p>
                                        
                                        <a href="{{ route('pricing') }}" class="block w-full py-3.5 bg-brand-orange rounded-xl font-bold text-white shadow-lg shadow-brand-orange/20 hover:shadow-brand-orange/40 hover:-translate-y-0.5 transition transform">
                                            Upgrade Now
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

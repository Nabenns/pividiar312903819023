<x-app-layout>
    <div class="py-12" x-data="calendarApp(@js($events))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-white">Economic Calendar</h2>
                <p class="text-gray-400 mt-2">Key market events and economic data releases</p>
            </div>

            <!-- Filters -->
            <div class="mb-8 flex flex-col md:flex-row gap-4 justify-between items-center">
                <!-- Impact Filter -->
                <div class="flex gap-2 p-1 bg-black/20 rounded-xl border border-white/5">
                    <button @click="filterImpact = 'all'" 
                        :class="filterImpact === 'all' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">All</button>
                    <button @click="filterImpact = 'High'" 
                        :class="filterImpact === 'High' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">High</button>
                    <button @click="filterImpact = 'Medium'" 
                        :class="filterImpact === 'Medium' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/30' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">Medium</button>
                    <button @click="filterImpact = 'Low'" 
                        :class="filterImpact === 'Low' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all">Low</button>
                </div>

                <!-- Currency Filter -->
                <div class="relative">
                    <select x-model="filterCurrency" class="bg-black/20 border border-white/10 text-white text-sm rounded-xl focus:ring-brand-orange focus:border-brand-orange block w-full p-2.5">
                        <option value="all">All Currencies</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="JPY">JPY</option>
                        <option value="AUD">AUD</option>
                        <option value="CAD">CAD</option>
                        <option value="CHF">CHF</option>
                        <option value="CNY">CNY</option>
                    </select>
                </div>
            </div>

            <div class="space-y-8">
                <template x-for="(events, date) in groupedEvents" :key="date">
                    <div class="glass-card rounded-2xl border border-white/10 bg-[#0A1935]/80 shadow-xl backdrop-blur-md overflow-hidden mb-8">
                        <!-- Date Header -->
                        <div class="px-6 py-4 bg-black/20 border-b border-white/5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-orange/10 flex flex-col items-center justify-center text-brand-orange border border-brand-orange/20">
                                <span class="text-xs font-bold uppercase" x-text="formatMonth(date)"></span>
                                <span class="text-lg font-bold leading-none" x-text="formatDay(date)"></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white" x-text="formatDayName(date)"></h3>
                                <p class="text-xs text-gray-400" x-text="formatYear(date)"></p>
                            </div>
                        </div>

                        <!-- Events Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-white/5 bg-white/5">
                                        <th class="px-6 py-3">Time</th>
                                        <th class="px-6 py-3">Currency</th>
                                        <th class="px-6 py-3">Impact</th>
                                        <th class="px-6 py-3">Event</th>
                                        <th class="px-6 py-3 text-right">Actual</th>
                                        <th class="px-6 py-3 text-right">Forecast</th>
                                        <th class="px-6 py-3 text-right">Previous</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <template x-for="event in events" :key="event.title + event.time">
                                        <tr class="hover:bg-white/5 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 font-mono" x-text="formatTime(event.time)"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 rounded text-xs font-bold bg-white/10 text-white border border-white/10" x-text="event.country"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border"
                                                    :class="{
                                                        'bg-red-500/20 text-red-400 border-red-500/30': event.impact === 'High',
                                                        'bg-orange-500/20 text-orange-400 border-orange-500/30': event.impact === 'Medium',
                                                        'bg-yellow-500/20 text-yellow-400 border-yellow-500/30': event.impact === 'Low',
                                                        'bg-gray-500/20 text-gray-400 border-gray-500/30': event.impact === 'Holiday'
                                                    }" x-text="event.impact">
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-white font-medium group-hover:text-brand-orange transition-colors" x-text="event.title"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-white" x-text="event.actual || '-'"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-400" x-text="event.forecast || '-'"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500" x-text="event.previous || '-'"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </template>

                <div x-show="Object.keys(groupedEvents).length === 0" class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white">No events found</h3>
                    <p class="text-gray-400 mt-1">Try adjusting your filters.</p>
                </div>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-600">Data source: ForexFactory.com</p>
            </div>
        </div>
    </div>

    <script>
        function calendarApp(initialEvents) {
            return {
                events: initialEvents,
                filterImpact: 'all',
                filterCurrency: 'all',

                get filteredEvents() {
                    return this.events.filter(event => {
                        const impactMatch = this.filterImpact === 'all' || event.impact === this.filterImpact;
                        const currencyMatch = this.filterCurrency === 'all' || event.country === this.filterCurrency;
                        return impactMatch && currencyMatch;
                    });
                },

                get groupedEvents() {
                    return this.filteredEvents.reduce((groups, event) => {
                        const date = event.date;
                        if (!groups[date]) {
                            groups[date] = [];
                        }
                        groups[date].push(event);
                        return groups;
                    }, {});
                },

                // Date Formatting Helpers
                formatMonth(dateStr) {
                    return new Date(dateStr).toLocaleDateString('en-US', { month: 'short' });
                },
                formatDay(dateStr) {
                    return new Date(dateStr).getDate();
                },
                formatDayName(dateStr) {
                    return new Date(dateStr).toLocaleDateString('en-US', { weekday: 'long' });
                },
                formatYear(dateStr) {
                    return new Date(dateStr).getFullYear();
                },
                formatTime(timeStr) {
                    // Assuming timeStr is HH:mm format, simple return. 
                    // In a real app, you might parse and adjust timezone here if needed.
                    return timeStr;
                }
            }
        }
    </script>
</x-app-layout>

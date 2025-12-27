<x-app-layout>
    <div class="py-12 relative overflow-hidden">
        <!-- Background Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-brand-orange/10 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="mb-12 text-center max-w-2xl mx-auto">
                <h2 class="text-4xl font-bold text-white tracking-tight mb-4">Academy</h2>
                <p class="text-gray-400 text-lg">Master the markets with our premium educational content. From basics to advanced strategies.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($lessons as $lesson)
                    <div class="glass-card rounded-3xl border border-white/10 overflow-hidden hover:border-brand-orange/50 hover:shadow-2xl hover:shadow-brand-orange/10 transition-all duration-300 group flex flex-col h-full">
                        <div class="aspect-video w-full bg-gray-800 relative overflow-hidden">
                            @if ($lesson->thumbnail)
                                <img src="{{ Storage::url($lesson->thumbnail) }}" alt="{{ $lesson->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-white/5 group-hover:bg-white/10 transition-colors">
                                    <svg class="w-16 h-16 text-white/10 group-hover:text-white/20 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0b172e] via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 right-4">
                                @if($lesson->is_free)
                                    <span class="px-3 py-1 rounded-full bg-green-500/20 border border-green-500/30 text-green-400 text-xs font-bold backdrop-blur-md shadow-lg">
                                        Free
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-brand-orange/20 border border-brand-orange/30 text-brand-orange text-xs font-bold backdrop-blur-md shadow-lg flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Premium
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-brand-orange transition-colors line-clamp-2">{{ $lesson->title }}</h3>
                                <div class="text-gray-400 text-sm line-clamp-3 mb-6 leading-relaxed">
                                    {!! strip_tags($lesson->description) !!}
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-white/5 mt-auto">
                                <a href="{{ route('academy.lesson', $lesson) }}" class="block w-full py-3 text-center rounded-xl font-bold transition-all duration-300 {{ $lesson->is_free ? 'bg-white/10 hover:bg-white/20 text-white' : 'bg-brand-orange hover:bg-brand-orange/90 text-white shadow-lg shadow-brand-orange/20 hover:shadow-brand-orange/40 hover:-translate-y-0.5' }}">
                                    {{ $lesson->is_free ? 'Start Learning' : 'Unlock Lesson' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 mb-6 animate-pulse">
                            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No lessons available yet</h3>
                        <p class="text-gray-400">We are crafting new content. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>


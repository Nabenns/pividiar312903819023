<x-app-layout>
    <div class="flex flex-col lg:flex-row min-h-screen">
        {{-- Sidebar Navigation --}}
        <div class="w-full lg:w-80 bg-[#0b172e] border-r border-white/10 flex-shrink-0">
            <div class="p-6 border-b border-white/10">
                <a href="{{ route('academy.index') }}" class="flex items-center text-gray-400 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Academy
                </a>
                <h2 class="text-lg font-bold text-white leading-tight">All Lessons</h2>
            </div>
            
            <div class="overflow-y-auto h-[calc(100vh-200px)] p-4 space-y-2">
                @php
                    $allLessons = \App\Models\Lesson::orderBy('order')->get();
                @endphp
                @foreach ($allLessons as $l)
                    <a href="{{ route('academy.lesson', $l) }}" class="block p-3 rounded-xl transition-all duration-200 {{ $l->id === $lesson->id ? 'bg-brand-orange text-white shadow-lg shadow-brand-orange/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full {{ $l->id === $lesson->id ? 'bg-white/20' : 'bg-white/5' }} text-xs font-bold mr-3">
                                {{ $loop->iteration }}
                            </span>
                            <span class="text-sm font-medium">{{ $l->title }}</span>
                            @if(!$l->is_free && $l->id !== $lesson->id)
                                <svg class="w-4 h-4 ml-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 bg-[#020617] overflow-y-auto">
            <div class="max-w-4xl mx-auto px-6 py-12">
                <h1 class="text-3xl font-bold text-white mb-8">{{ $lesson->title }}</h1>
                
                <div class="space-y-8">
                    @if($isLocked)
                        <div class="p-12 rounded-3xl bg-white/5 border border-white/10 text-center relative overflow-hidden group">
                            <div class="absolute inset-0 bg-brand-orange/5 blur-3xl group-hover:bg-brand-orange/10 transition-colors duration-500"></div>
                            <div class="relative z-10">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-white mb-3">Premium Content</h2>
                                <p class="text-gray-400 max-w-md mx-auto mb-8">This lesson is available exclusively for premium members. Upgrade your plan to unlock full access.</p>
                                <a href="{{ route('pricing') }}" class="inline-flex items-center px-8 py-4 bg-brand-orange hover:bg-brand-orange/90 text-white rounded-xl font-bold transition-all shadow-lg shadow-brand-orange/20 hover:shadow-brand-orange/40 hover:-translate-y-1">
                                    Upgrade to Premium
                                </a>
                            </div>
                        </div>
                    @elseif($lesson->content)
                        @foreach ($lesson->content as $block)
                            @if ($block['type'] === 'text')
                                <div class="prose prose-invert max-w-none text-gray-300">
                                    {!! $block['data']['content'] !!}
                                </div>
                            @elseif ($block['type'] === 'image')
                                <figure class="rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
                                    <img src="{{ Storage::url($block['data']['url']) }}" alt="{{ $block['data']['caption'] ?? '' }}" class="w-full">
                                    @if(!empty($block['data']['caption']))
                                        <figcaption class="p-3 bg-black/50 text-center text-gray-400 text-sm">
                                            {{ $block['data']['caption'] }}
                                        </figcaption>
                                    @endif
                                </figure>
                            @elseif ($block['type'] === 'video')
                                <div class="aspect-video rounded-2xl overflow-hidden border border-white/10 shadow-2xl bg-black">
                                    <iframe src="{{ $block['data']['url'] }}" class="w-full h-full" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="p-8 rounded-2xl bg-white/5 border border-white/10 text-center text-gray-400">
                            No content available for this lesson yet.
                        </div>
                    @endif
                </div>

                {{-- Navigation Buttons --}}
                <div class="mt-12 pt-8 border-t border-white/10 flex justify-between">


                    @if($previousLesson)
                        <a href="{{ route('academy.lesson', $previousLesson) }}" class="flex items-center px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-xl transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <div>
                                <div class="text-xs text-gray-400 uppercase">Previous</div>
                                <div class="font-medium">{{ $previousLesson->title }}</div>
                            </div>
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('academy.lesson', $nextLesson) }}" class="flex items-center px-6 py-3 bg-brand-orange hover:bg-brand-orange/90 text-white rounded-xl transition-colors shadow-lg shadow-brand-orange/20">
                            <div class="text-right">
                                <div class="text-xs text-white/80 uppercase">Next</div>
                                <div class="font-medium">{{ $nextLesson->title }}</div>
                            </div>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

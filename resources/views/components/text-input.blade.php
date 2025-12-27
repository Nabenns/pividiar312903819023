@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/5 border-white/10 text-white placeholder-gray-500 focus:border-brand-orange focus:ring-brand-orange rounded-xl shadow-sm transition duration-200']) }}>

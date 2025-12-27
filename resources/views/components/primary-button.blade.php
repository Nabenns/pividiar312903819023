<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-brand-orange border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,159,28,0.3)] hover:shadow-[0_0_25px_rgba(255,159,28,0.5)] transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>

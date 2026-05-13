@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200']) }}>

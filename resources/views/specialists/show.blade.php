@extends('layouts.app')
@section('title', 'Profile: ' . $specialist->user->name)

@section('content')
    <div class="bg-stone-50 min-h-screen pb-20">
        {{-- Шапка профиля --}}
        <div class="bg-brown py-16 shadow-inner">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 bg-gold/20 rounded-[2.5rem] flex items-center justify-center border-4 border-white/10 shrink-0 shadow-2xl">
                    <span class="text-5xl font-bold text-gold">{{ mb_substr($specialist->user->name, 0, 1) }}</span>
                </div>

                <div class="text-center md:text-left text-white">
                    <h1 class="text-4xl font-bold mb-2 tracking-tight">{{ $specialist->user->name }}</h1>
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 text-stone-400 text-sm">
                        <span class="flex items-center gap-1.5"><span class="text-gold text-lg">★</span> {{ number_format($specialist->reviews_avg_rating ?? 5.0, 1) }}</span>
                        <span class="opacity-30">|</span>
                        <span>{{ $specialist->experience_years ?? 0 }} Years Experience</span>
                        <span class="opacity-30">|</span>
                        <span class="text-gold font-medium italic underline decoration-gold/30">{{ $specialist->salon->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 -mt-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Основной контент --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-stone-100">
                        <h2 class="text-xl font-bold text-brown mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-gold rounded-full"></span>
                            About Specialist
                        </h2>
                        <p class="text-stone-500 leading-relaxed italic">
                            "{{ $specialist->bio ?? 'Professional beauty expert dedicated to excellence and style.' }}"
                        </p>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-stone-100">
                        <h2 class="text-xl font-bold text-brown mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-gold rounded-full"></span>
                            Recent Works
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @php
                                // Умный подбор тегов на основе данных мастера
                                $info = strtolower($specialist->bio . ' ' . $specialist->services->pluck('name')->implode(' '));

                                if (str_contains($info, 'nail') || str_contains($info, 'manicure')) {
                                    $tag = 'nails,manicure';
                                } elseif (str_contains($info, 'makeup') || str_contains($info, 'face')) {
                                    $tag = 'makeup,cosmetics';
                                } else {
                                    $tag = 'hairstyle,haircut';
                                }
                            @endphp

                            @for($i = 1; $i <= 6; $i++)
                                <div class="aspect-square bg-stone-50 rounded-2xl overflow-hidden border border-stone-100 hover:border-gold/30 transition-all hover:scale-[1.02] shadow-sm relative">
                                    {{-- Используем сервис Pexels или Unsplash через параметры для стабильности --}}
                                    <img src="https://loremflickr.com/400/400/{{ $tag }}?random={{ $specialist->id + $i }}"
                                         alt="Portfolio Work"
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='https://placehold.co/400x400/E7E5E4/A8A29E?text=GlowBook+Work';">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Боковая панель с услугами --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-gold/10 sticky top-6">
                        <h3 class="text-lg font-bold text-brown mb-6 pb-2 border-b">Services & Prices</h3>
                        <div class="space-y-5 mb-10">
                            @forelse($specialist->services as $service)
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-bold text-brown">{{ $service->name }}</p>
                                        <p class="text-[10px] text-stone-400 mt-0.5">{{ $service->duration_minutes }} min</p>
                                    </div>
                                    <span class="text-gold font-bold text-sm ml-4">{{ number_format($service->price, 0, '.', ' ') }} ₸</span>
                                </div>
                            @empty
                                <p class="text-stone-400 text-xs italic">Consult with the specialist for a custom service list.</p>
                            @endforelse
                        </div>

                        <a href="{{ route('client.book', ['specialist_id' => $specialist->id]) }}"
                           class="block text-center bg-gold text-white py-4 rounded-2xl font-bold shadow-lg shadow-gold/20 hover:bg-brown transition-all active:scale-95">
                            Book Appointment
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

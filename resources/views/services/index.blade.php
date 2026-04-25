@extends('layouts.app')
@section('title', 'All Services')

@section('content')
    {{-- Header Section --}}
    <div class="bg-brown py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white">All Services</h1>
            <p class="text-stone-400 mt-2">Browse services from all our partner salons</p>
        </div>
    </div>

    {{-- HOT PROMOTIONS SECTION --}}
    <section class="max-w-7xl mx-auto px-4 mt-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Promo 1: Seasonal Discount --}}
            <div class="bg-gradient-to-br from-gold/20 to-cream p-6 rounded-[2rem] border border-gold/30 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                <div class="relative z-10">
                    <span class="bg-gold text-white text-[9px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter">Limited Offer</span>
                    <h3 class="text-brown font-bold mt-4 text-xl leading-tight">-25% on Summer Care</h3>
                    <p class="text-stone-600 text-xs mt-2">Refresh your look for the season. Valid for all facial treatments.</p>
                    <div class="mt-4">
                        <span class="text-brown font-mono font-bold text-xs bg-white/60 px-3 py-1.5 rounded-xl border border-gold/20">CODE: GLOW2026</span>
                    </div>
                </div>
                <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 group-hover:scale-110 transition-transform duration-500">✨</div>
            </div>

            {{-- Promo 2: Bundle Deal --}}
            <div class="bg-gradient-to-br from-brown/10 to-stone-100 p-6 rounded-[2rem] border border-stone-200 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                <div class="relative z-10">
                    <span class="bg-brown text-white text-[9px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter">Best Value</span>
                    <h3 class="text-brown font-bold mt-4 text-xl leading-tight">Mani + Pedi Combo</h3>
                    <p class="text-stone-600 text-xs mt-2">Book both services today and get a complimentary hand massage.</p>
                    <a href="#" class="mt-4 inline-block text-brown font-bold text-[11px] underline tracking-widest uppercase">View Details →</a>
                </div>
                <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 group-hover:scale-110 transition-transform duration-500">💅</div>
            </div>

            {{-- Promo 3: Loyalty/New Client --}}
            <div class="bg-gradient-to-br from-rose-50 to-cream p-6 rounded-[2rem] border border-rose-200 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                <div class="relative z-10">
                    <span class="bg-rose-400 text-white text-[9px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter">New Client</span>
                    <h3 class="text-brown font-bold mt-4 text-xl leading-tight">First Visit Gift</h3>
                    <p class="text-stone-600 text-xs mt-2">Get 5 000 ₸ off your first appointment over 20 000 ₸.</p>
                    <p class="mt-4 text-rose-500 font-bold text-[10px] italic underline">Applied automatically</p>
                </div>
                <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 group-hover:scale-110 transition-transform duration-500">💝</div>
            </div>
        </div>
    </section>

    {{-- SERVICES GRID --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200 hover:shadow-lg hover:border-gold/40 hover:-translate-y-1 transition-all duration-300">

                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 bg-gold/10 text-gold text-xs font-medium rounded-full uppercase tracking-wider italic">
                            {{ $service->category }}
                        </span>
                        <span class="text-gold font-bold text-lg">{{ number_format($service->price, 0, '.', ' ') }} ₸</span>
                    </div>

                    <h3 class="text-lg font-semibold text-brown">{{ $service->name }}</h3>

                    <p class="text-stone-500 text-sm mt-2 leading-relaxed line-clamp-2">
                        {{ $service->description }}
                    </p>

                    <p class="text-xs text-stone-400 mt-3 flex items-center italic">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                        {{ $service->salon->name }}
                    </p>

                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-stone-100">
                        <span class="text-xs text-stone-400 font-medium">{{ $service->duration_minutes }} min</span>

                        @auth
                            <a href="{{ route('client.book', ['salon_id' => $service->salon_id, 'service_id' => $service->id]) }}"
                               class="bg-gold text-white px-5 py-2 rounded-xl text-xs font-bold shadow-sm transition hover:bg-brown">
                                Book Now
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="bg-gold text-white px-5 py-2 rounded-xl text-xs font-bold shadow-sm transition hover:bg-brown">
                                Book Now
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

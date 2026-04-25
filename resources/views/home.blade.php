@extends('layouts.app')
@section('title', 'Book Your Perfect Look')

@section('content')
    {{-- HERO SECTION --}}
    <section class="bg-brown relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-24 md:py-32 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">Book Your<br><span class="text-gold">Perfect Look</span></h1>
            <p class="text-stone-400 text-lg md:text-xl max-w-2xl mx-auto mb-8">Discover top beauty salons and book with the best specialists across Kazakhstan.</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('client.book') }}" class="btn-gold text-white px-10 py-4 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-gold/20 hover:-translate-y-1 active:scale-95">
                        Book an Appointment
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-gold text-white px-10 py-4 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-gold/20 hover:-translate-y-1 active:scale-95">
                        Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-stone-600 text-stone-300 px-10 py-4 rounded-2xl font-bold text-sm hover:border-gold hover:text-gold transition-all">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- SALONS SECTION --}}
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brown">Available Salons</h2>
            <p class="text-stone-500 mt-2">Find the perfect beauty spot near you</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($salons as $salon)
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 group relative overflow-hidden">
                    <div class="flex items-start justify-between relative z-10">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold text-brown group-hover:text-gold transition">{{ $salon->name }}</h3>
                                <span class="bg-gold/10 text-gold text-[10px] uppercase tracking-widest px-2 py-1 rounded-full border border-gold/20 font-bold">Premium</span>
                            </div>
                            <p class="text-sm text-stone-500 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $salon->address }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-1 bg-cream px-3 py-1.5 rounded-2xl border border-stone-100">
                            <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-bold text-brown">{{ number_format($salon->averageRating(), 1) }}</span>
                        </div>
                    </div>
                    <p class="text-stone-500 text-sm mt-4 line-clamp-2 leading-relaxed italic">"{{ $salon->description }}"</p>
                    <div class="flex items-center justify-between mt-6 pt-5 border-t border-stone-50">
                        <div class="flex items-center space-x-4 text-xs font-medium text-stone-400">
                            <span class="flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-gold/40 mr-2"></span>{{ $salon->specialists->count() }} Artists</span>
                            <span class="flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-gold/40 mr-2"></span>{{ $salon->services->count() }} Services</span>
                        </div>
                        <a href="{{ route('salons.show', $salon) }}" class="btn-gold text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-gold/20 transition-all hover:-translate-y-1 active:scale-95">
                            View Salon
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- UPCOMING EVENTS SECTION --}}
    <section class="bg-cream/50 py-20 border-y border-stone-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-brown">Upcoming Beauty Events</h2>
                <p class="text-stone-500 mt-2">Exclusive masterclasses and beauty days in our partner salons</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Event 1 --}}
                <div class="bg-white rounded-[2rem] p-3 shadow-sm flex flex-col sm:flex-row gap-6 hover:shadow-xl transition-all duration-500 group border border-stone-100">
                    <div class="sm:w-44 h-44 bg-brown rounded-[1.5rem] shrink-0 flex flex-col items-center justify-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-gold/10 group-hover:scale-110 transition-transform duration-700"></div>
                        <span class="text-4xl font-black relative z-10">28</span>
                        <span class="uppercase tracking-[0.2em] text-[10px] font-bold opacity-60 relative z-10">May</span>
                    </div>
                    <div class="p-4 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                            <span class="text-gold text-[10px] font-bold uppercase tracking-widest">Masterclass</span>
                        </div>
                        <h3 class="text-xl font-bold text-brown mb-2 group-hover:text-gold transition">Summer Glow Trends</h3>
                        <p class="text-stone-500 text-sm mb-4 leading-relaxed">Master the art of sun-kissed makeup with top Almaty artists.</p>
                        <div class="flex items-center gap-4 text-[11px] text-stone-400 font-medium">
                            <span class="flex items-center">📍 Glow Studio Almaty</span>
                            <span class="flex items-center">⏰ 15:00</span>
                        </div>
                    </div>
                </div>

                {{-- Event 2 --}}
                <div class="bg-white rounded-[2rem] p-3 shadow-sm flex flex-col sm:flex-row gap-6 hover:shadow-xl transition-all duration-500 group border border-stone-100">
                    <div class="sm:w-44 h-44 bg-gold rounded-[1.5rem] shrink-0 flex flex-col items-center justify-center text-brown relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 group-hover:scale-110 transition-transform duration-700"></div>
                        <span class="text-4xl font-black relative z-10">05</span>
                        <span class="uppercase tracking-[0.2em] text-[10px] font-bold opacity-60 relative z-10">June</span>
                    </div>
                    <div class="p-4 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-brown animate-pulse"></span>
                            <span class="text-brown text-[10px] font-bold uppercase tracking-widest">Grand Opening</span>
                        </div>
                        <h3 class="text-xl font-bold text-brown mb-2 group-hover:text-gold transition">New Branch Launch</h3>
                        <p class="text-stone-500 text-sm mb-4 leading-relaxed">Join us for champagne and gifts at our new premium location.</p>
                        <div class="flex items-center gap-4 text-[11px] text-stone-400 font-medium">
                            <span class="flex items-center">📍 Esentai Square</span>
                            <span class="flex items-center">⏰ All Day</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICES SECTION --}}
    <section class="bg-white py-20">
        {{-- ... твой код услуг остается таким же, но добавь кнопку в конце ... --}}
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-brown">Popular Services</h2>
                <p class="text-stone-500 mt-2">High-quality services from our best experts</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <div class="bg-cream/30 rounded-3xl p-6 border border-stone-100 hover:border-gold/30 transition shadow-sm hover:shadow-md group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-white text-gold text-[10px] font-bold uppercase tracking-wider rounded-full border border-stone-100 italic">{{ $service->category }}</span>
                            <span class="text-brown font-bold">{{ number_format($service->price, 0, '.', ' ') }} ₸</span>
                        </div>
                        <h3 class="text-lg font-bold text-brown mb-1">{{ $service->name }}</h3>
                        <p class="text-stone-400 text-xs mb-4 flex items-center italic">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                            {{ $service->salon->name }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-stone-100">
                            <span class="text-xs text-stone-400 font-medium">{{ $service->duration_minutes }} min</span>
                            @auth
                                <a href="{{ route('client.book', ['salon_id' => $service->salon_id, 'service_id' => $service->id]) }}" class="bg-gold text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-brown transition-all shadow-sm">
                                    Book Now
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="bg-gold text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-brown transition-all shadow-sm">
                                    Book Now
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('services') }}" class="inline-flex items-center bg-brown text-white px-8 py-3 rounded-2xl font-bold text-xs hover:bg-gold transition-all">
                    View All Services &rarr;
                </a>
            </div>
        </div>
    </section>
@endsection

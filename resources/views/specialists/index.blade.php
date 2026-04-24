@extends('layouts.app')

@section('title', 'Our Specialists')

@section('content')
    @php
        $maxRating = $specialists->max('rating');
    @endphp

    <div class="bg-brown py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white ">Our Specialists</h1>
            <p class="text-stone-400 mt-2 font-medium">Meet the beauty experts at our salons</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16 bg-cream/30">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($specialists as $specialist)
                <div class="group bg-white rounded-[2.5rem] p-3 shadow-sm border border-stone-100 hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 flex flex-col h-full relative">

                    @if($specialist->rating >= $maxRating && $specialist->rating > 0)
                        <div class="absolute top-6 right-6 z-10">
                    <span class="bg-gold text-white text-[10px] font-black px-4 py-2 rounded-full shadow-lg border border-white/20 uppercase tracking-widest flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Top Master
                    </span>
                        </div>
                    @endif

                    <div class="relative h-36 bg-stone-50 rounded-[2rem] overflow-visible mb-14 transition-colors duration-500 group-hover:bg-gold/5">
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                            <div class="w-28 h-28 bg-white rounded-full p-1.5 shadow-xl ring-8 ring-stone-50/50 group-hover:ring-gold/10 transition-all duration-500">
                                <div class="w-full h-full rounded-full bg-stone-100 flex items-center justify-center overflow-hidden border border-stone-100">
                                    @if($specialist->user->avatar)
                                        <img src="{{ asset('storage/' . $specialist->user->avatar) }}"
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                             alt="{{ $specialist->user->name }}">
                                    @else
                                        <span class="text-gold text-3xl font-bold group-hover:scale-110 transition-transform duration-500">
                                    {{ mb_substr($specialist->user->name, 0, 1) }}
                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 pb-8 text-center flex flex-col flex-1">
                        <h3 class="text-2xl font-bold text-brown group-hover:text-gold transition-colors duration-300">{{ $specialist->user->name }}</h3>
                        <p class="text-sm text-stone-400 font-semibold tracking-wide uppercase mt-1">{{ $specialist->salon->name }}</p>

                        <div class="flex items-center justify-center mt-4 bg-stone-50 w-fit mx-auto px-5 py-1.5 rounded-full border border-stone-100">
                            <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="ml-2 text-sm font-black text-brown">{{ number_format($specialist->rating, 1) }}</span>
                            <span class="mx-2 text-stone-300">|</span>
                            <span class="text-[10px] text-stone-400 uppercase font-black tracking-tighter">{{ $specialist->reviews->count() }} reviews</span>
                        </div>

                        <p class="text-stone-500 text-sm mt-6 leading-relaxed flex-1 font-medium">
                            "{{ Str::limit($specialist->bio, 85) }}"
                        </p>

                        <div class="flex items-center justify-center gap-6 mt-6 mb-8 text-stone-400">
                            <div class="text-center">
                                <span class="block text-brown font-bold text-sm">{{ $specialist->experience_years }}Y</span>
                                <span class="text-[9px] uppercase font-bold tracking-widest">Exp.</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-brown font-bold text-sm">{{ $specialist->services->count() }}</span>
                                <span class="text-[9px] uppercase font-bold tracking-widest">Services</span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('client.book', ['specialist' => $specialist->id]) }}"
                               class="inline-block w-full py-4 bg-gold text-white text-[11px] font-black uppercase tracking-[0.25em] rounded-2xl
                              hover:bg-brown shadow-md hover:shadow-xl transition-all duration-300 active:scale-95 text-center">
                                Book
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

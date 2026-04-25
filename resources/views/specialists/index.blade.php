@extends('layouts.app')
@section('title', 'Our Specialists')

@section('content')
    <div class="bg-brown py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white">Our Specialists</h1>
            <p class="text-stone-400 mt-2">Meet the beauty experts at our salons</p>
        </div>
    </div>

    {{-- MASTER OF THE MONTH BANNER --}}
    @if($topMaster)
        <section class="max-w-7xl mx-auto px-4 mt-8">
            <div class="bg-white rounded-3xl overflow-hidden border border-gold/20 shadow-md">
                <div class="bg-gradient-to-r from-brown to-[#4a3728] p-5 flex flex-col md:flex-row items-center justify-between gap-4">

                    {{-- Левая часть: Иконка и текст --}}
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gold/10 rounded-2xl flex items-center justify-center border border-gold/20 shrink-0">
                            <span class="text-2xl">🏆</span>
                        </div>
                        <div>
                            <h2 class="text-white font-bold text-base leading-tight">Master of the Month</h2>
                            <p class="text-stone-400 text-xs mt-0.5">Highest rating in {{ now()->format('F') }}</p>
                        </div>
                    </div>

                    {{-- Правая часть: Данные мастера и кнопка --}}
                    <div class="flex items-center gap-6">
                        <div class="text-right hidden sm:block">
                            <div class="text-gold font-bold text-sm">{{ $topMaster->user->name }}</div>
                            <div class="text-[10px] text-stone-500 font-medium uppercase tracking-wider">
                                {{ number_format($topMaster->reviews_avg_rating, 1) }} ⭐ • {{ $topMaster->reviews_count }} Reviews
                            </div>
                        </div>
                        <a href="/specialists/{{ $topMaster->id }}" class="bg-gold text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all hover:bg-gold/90 active:scale-95 shadow-sm">
                            View Specialist
                        </a>
                    </div>

                </div>
            </div>
        </section>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($specialists as $specialist)
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden hover:shadow-md transition">
                    <div class="btn-gold p-6 text-center">
                        <div class="w-20 h-20 bg-white/90 rounded-full flex items-center justify-center mx-auto">
                            <span class="text-gold text-2xl font-bold">{{ mb_substr($specialist->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="p-5 text-center">
                        <h3 class="text-lg font-semibold text-brown">{{ $specialist->user->name }}</h3>
                        <p class="text-xs text-stone-400 mt-0.5">{{ $specialist->salon->name }}</p>
                        <div class="flex items-center justify-center mt-2">
                            @for($i=1;$i<=5;$i++)
                                <svg class="w-4 h-4 {{ $i <= round($specialist->rating) ? 'text-gold' : 'text-stone-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-1.5 text-sm text-stone-500">{{ number_format($specialist->rating, 1) }} ({{ $specialist->reviews->count() }})</span>
                        </div>
                        <p class="text-stone-500 text-sm mt-3">{{ Str::limit($specialist->bio, 100) }}</p>
                        <p class="text-xs text-stone-400 mt-2">{{ $specialist->experience_years }} years experience</p>
                        <div class="flex flex-wrap justify-center gap-1.5 mt-3">
                            @foreach($specialist->services as $svc)
                                <span class="text-xs bg-cream text-brown px-2 py-0.5 rounded-full border border-stone-200">{{ $svc->name }}</span>
                            @endforeach
                        </div>

                        {{-- Добавим кнопку просмотра профиля и в карточку для удобства --}}
                        <div class="mt-5">
                            <a href="/specialists/{{ $specialist->id }}" class="inline-block text-xs font-bold text-gold border border-gold/30 px-4 py-2 rounded-xl hover:bg-gold hover:text-white transition-all">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

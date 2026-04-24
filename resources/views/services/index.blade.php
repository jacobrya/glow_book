@extends('layouts.app')
@section('title', 'All Services')
@section('content')

    <div class="bg-brown py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white">All Services</h1>
            <p class="text-stone-400 mt-2">Browse services from all our partner salons</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200 hover:shadow-lg hover:border-gold/40 hover:-translate-y-1 transition-all duration-300">

                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 bg-gold/10 text-gold text-xs font-medium rounded-full">{{ $service->category }}</span>
                        <span class="text-gold font-bold text-lg">{{ number_format($service->price, 0, '.', ' ') }} ₸</span>
                    </div>

                    <h3 class="text-lg font-semibold text-brown">{{ $service->name }}</h3>

                    <p class="text-stone-500 text-sm mt-2 leading-relaxed">
                        {{ $service->description }}
                    </p>

                    <p class="text-xs text-stone-400 mt-2">{{ $service->salon->name }}</p>

                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-stone-100">
                        <span class="text-xs text-stone-400">{{ $service->duration_minutes }} min</span>

                        @auth
                            <a href="{{ route('client.book', ['salon_id' => $service->salon_id, 'service_id' => $service->id]) }}" class="btn-gold text-white px-4 py-1.5 rounded-2xl text-sm font-semibold transition">Book</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-gold text-white px-4 py-1.5 rounded-2xl text-sm font-semibold transition">Book</a>
                        @endauth
                    </div>

                </div>

            @endforeach
        </div>
    </div>

@endsection

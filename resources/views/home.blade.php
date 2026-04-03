@extends('layouts.app')
@section('title', 'Book Your Perfect Look')
@section('content')
<section class="bg-brown relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 py-24 md:py-32 text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">Book Your<br><span class="text-gold">Perfect Look</span></h1>
        <p class="text-stone-400 text-lg md:text-xl max-w-2xl mx-auto mb-8">Discover top beauty salons and book with the best specialists across Kazakhstan.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a href="{{ route('client.book') }}" class="btn-gold text-white px-8 py-3.5 rounded-2xl font-semibold text-sm transition inline-block">Book an Appointment</a>
            @else
                <a href="{{ route('register') }}" class="btn-gold text-white px-8 py-3.5 rounded-2xl font-semibold text-sm transition inline-block">Get Started Free</a>
                <a href="{{ route('login') }}" class="border border-stone-600 text-stone-300 px-8 py-3.5 rounded-2xl font-semibold text-sm hover:border-gold hover:text-gold transition inline-block">Sign In</a>
            @endauth
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-brown">Available Salons</h2>
        <p class="text-stone-500 mt-2">Find the perfect salon near you</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($salons as $salon)
        <a href="{{ route('salons.show', $salon) }}" class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200 hover:shadow-md hover:border-gold/30 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-brown group-hover:text-gold transition">{{ $salon->name }}</h3>
                    <p class="text-sm text-stone-500 mt-1 flex items-center"><svg class="w-4 h-4 mr-1 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $salon->address }}</p>
                </div>
                <div class="flex items-center space-x-1 bg-cream px-2.5 py-1 rounded-full">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-sm font-semibold text-brown">{{ number_format($salon->averageRating(), 1) }}</span>
                </div>
            </div>
            <p class="text-stone-500 text-sm mt-3 line-clamp-2">{{ $salon->description }}</p>
            <div class="flex items-center space-x-4 mt-4 pt-3 border-t border-stone-100 text-xs text-stone-400">
                <span>{{ $salon->specialists->count() }} specialists</span>
                <span>{{ $salon->services->count() }} services</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

<section class="bg-white border-y border-stone-200 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brown">Popular Services</h2>
            <p class="text-stone-500 mt-2">Explore what our salons offer</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <div class="bg-cream/50 rounded-2xl p-5 border border-stone-200 hover:border-gold/30 transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 bg-gold/10 text-gold text-xs font-medium rounded-full">{{ $service->category }}</span>
                    <span class="text-gold font-bold">{{ number_format($service->price, 0, '.', ' ') }} ₸</span>
                </div>
                <h3 class="text-lg font-semibold text-brown">{{ $service->name }}</h3>
                <p class="text-stone-500 text-sm mt-1">{{ $service->salon->name }}</p>
                <div class="flex items-center justify-between mt-3 pt-3 border-t border-stone-200">
                    <span class="text-xs text-stone-400">{{ $service->duration_minutes }} min</span>
                    @auth
                        <a href="{{ route('client.book', ['salon_id' => $service->salon_id, 'service_id' => $service->id]) }}" class="text-gold text-sm font-semibold hover:underline">Book &rarr;</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gold text-sm font-semibold hover:underline">Book &rarr;</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('services') }}" class="text-gold font-semibold text-sm hover:underline">View all services &rarr;</a>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')
@section('title', 'Our Salons')

@section('content')
    <div class="bg-brown py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gold">Available Salons</h1>
            <p class="text-stone-400 mt-2 mb-8">Discover premium beauty spots across Kazakhstan</p>

            <!-- Search Form -->
            <div class="max-w-4xl mx-auto bg-cream rounded-2xl md:rounded-full p-2 flex flex-col md:flex-row items-center shadow-lg border border-gold/20">
                <form action="{{ route('salons') }}" method="GET" class="w-full flex flex-col md:flex-row items-center">
                    <div class="flex-1 w-full md:w-auto px-6 py-3 border-b md:border-b-0 md:border-r border-brown/10">
                        <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" class="w-full bg-transparent border-none text-brown placeholder-brown/50 focus:ring-0 p-0 outline-none text-sm font-medium">
                    </div>
                    <div class="w-full md:w-44 px-6 py-3 border-b md:border-b-0 md:border-r border-brown/10">
                        <select name="city" class="w-full bg-transparent border-none text-brown focus:ring-0 p-0 outline-none text-sm font-medium cursor-pointer">
                            <option value="all" {{ request('city', 'all') === 'all' ? 'selected' : '' }}>All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-44 px-6 py-3 border-b md:border-b-0 border-brown/10">
                        <select name="category" class="w-full bg-transparent border-none text-brown focus:ring-0 p-0 outline-none text-sm font-medium cursor-pointer">
                            <option value="all" {{ request('category', 'all') === 'all' ? 'selected' : '' }}>All Categories</option>
                            <option value="Hair" {{ request('category') === 'Hair' ? 'selected' : '' }}>Hair</option>
                            <option value="Nails" {{ request('category') === 'Nails' ? 'selected' : '' }}>Nails</option>
                            <option value="SPA" {{ request('category') === 'SPA' ? 'selected' : '' }}>SPA</option>
                        </select>
                    </div>
                    <div class="w-full md:w-auto p-1 mt-2 md:mt-0">
                        <button type="submit" class="w-full md:w-auto bg-gold text-white px-8 py-3 rounded-xl md:rounded-full font-bold hover:bg-yellow-600 transition shadow-md shadow-gold/30 flex items-center justify-center">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($salons as $salon)
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 group relative overflow-hidden">

                    <div class="flex items-start justify-between relative z-10">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold text-brown group-hover:text-gold transition">{{ $salon->name }}</h3>
                                <span class="bg-gold/10 text-gold text-[10px] uppercase tracking-widest px-2 py-1 rounded-full border border-gold/20 font-bold">
                            Premium
                        </span>
                            </div>

                            <p class="text-sm text-stone-500 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $salon->address }}@if($salon->city), <span class="text-gold font-medium ml-1">{{ $salon->city }}</span>@endif
                            </p>
                        </div>

                        <div class="flex items-center space-x-1 bg-cream px-3 py-1.5 rounded-2xl border border-stone-100">
                            <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-bold text-brown">{{ number_format($salon->averageRating(), 1) }}</span>
                        </div>
                    </div>

                    <p class="text-stone-500 text-sm mt-4 line-clamp-2 leading-relaxed italic">
                        "{{ $salon->description }}"
                    </p>

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
    </div>
@endsection

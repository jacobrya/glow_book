@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="bg-brown py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 btn-gold rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-white text-2xl font-bold">{{ mb_substr($user->name, 0, 1) }}</span>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $user->name }}</h1>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="px-2.5 py-0.5 bg-gold/20 text-gold text-xs font-semibold rounded-full border border-gold/30">Salon Owner</span>
                    <span class="text-stone-400 text-sm">{{ $salon->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left column --}}
        <div class="space-y-6">
            {{-- Personal Info --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Personal Information</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Email</p>
                        <p class="text-stone-700 mt-0.5">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Phone</p>
                        <p class="text-stone-700 mt-0.5">{{ $user->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Member Since</p>
                        <p class="text-stone-700 mt-0.5">{{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-5 inline-flex items-center text-sm font-semibold text-gold hover:underline">
                    Edit Profile &rarr;
                </a>
            </div>

            {{-- Salon Info --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Salon Details</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Salon Name</p>
                        <p class="text-stone-700 mt-0.5 font-semibold">{{ $salon->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">City</p>
                        <p class="text-stone-700 mt-0.5">{{ $salon->city ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Address</p>
                        <p class="text-stone-700 mt-0.5">{{ $salon->address ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Salon Phone</p>
                        <p class="text-stone-700 mt-0.5">{{ $salon->phone ?? '—' }}</p>
                    </div>
                    @if($salon->description)
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Description</p>
                        <p class="text-stone-600 text-sm mt-0.5 leading-relaxed">{{ $salon->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Stats --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Salon Overview</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $specialistCount }}</p>
                        <p class="text-xs text-stone-500 mt-1">Specialists</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $serviceCount }}</p>
                        <p class="text-xs text-stone-500 mt-1">Services</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $totalAppointments }}</p>
                        <p class="text-xs text-stone-500 mt-1">Total Bookings</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-lg font-bold text-brown">{{ number_format($totalRevenue, 0, '.', ' ') }} ₸</p>
                        <p class="text-xs text-stone-500 mt-1">Revenue</p>
                    </div>
                </div>
            </div>

            {{-- Team --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-brown text-lg">Specialists</h2>
                    <a href="{{ route('owner.specialists') }}" class="text-sm text-gold font-semibold hover:underline">Manage &rarr;</a>
                </div>
                @if($salon->specialists->isEmpty())
                    <p class="text-stone-500 text-sm text-center py-6">No specialists yet.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($salon->specialists as $specialist)
                        <div class="flex items-center space-x-3 p-3 bg-cream rounded-xl">
                            <div class="w-9 h-9 btn-gold rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-sm font-bold">{{ mb_substr($specialist->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-brown text-sm">{{ $specialist->user->name }}</p>
                                <div class="flex items-center space-x-1.5">
                                    @if($specialist->rating)
                                        <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-xs text-stone-500">{{ number_format($specialist->rating, 1) }}</span>
                                    @endif
                                    <span class="text-xs text-stone-400">{{ $specialist->experience_years ?? 0 }} yr exp</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 btn-gold rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Dashboard</span>
                    </a>
                    <a href="{{ route('owner.specialists') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 bg-stone-200 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Manage Specialists</span>
                    </a>
                    <a href="{{ route('owner.services') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 bg-stone-200 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Manage Services</span>
                    </a>
                    <a href="{{ route('owner.appointments') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 bg-stone-200 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Appointments</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

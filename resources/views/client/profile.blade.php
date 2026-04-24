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
                    <span class="px-2.5 py-0.5 bg-gold/20 text-gold text-xs font-semibold rounded-full border border-gold/30">Client</span>
                    <span class="text-stone-400 text-sm">Member since {{ $user->created_at->format('M Y') }}</span>
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
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Role</p>
                        <p class="text-stone-700 mt-0.5">Client</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-5 inline-flex items-center text-sm font-semibold text-gold hover:underline">
                    Edit Profile &rarr;
                </a>
            </div>

            {{-- Stats --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Activity</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $total }}</p>
                        <p class="text-xs text-stone-500 mt-1">Total Bookings</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $completed }}</p>
                        <p class="text-xs text-stone-500 mt-1">Completed</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $cancelled }}</p>
                        <p class="text-xs text-stone-500 mt-1">Cancelled</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $reviewsGiven }}</p>
                        <p class="text-xs text-stone-500 mt-1">Reviews Given</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-brown text-lg">Recent Appointments</h2>
                    <a href="{{ route('client.appointments') }}" class="text-sm text-gold font-semibold hover:underline">View All &rarr;</a>
                </div>

                @if($recentAppointments->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-stone-500 text-sm">No appointments yet.</p>
                        <a href="{{ route('client.book') }}" class="mt-3 inline-block btn-gold text-white px-5 py-2 rounded-2xl text-sm font-semibold">Book Now</a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentAppointments as $apt)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-cream rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 btn-gold rounded-xl flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-sm font-bold">{{ mb_substr($apt->specialist->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-brown text-sm">{{ $apt->service->name }}</p>
                                    <p class="text-xs text-stone-500">{{ $apt->specialist->user->name }} · {{ $apt->salon->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 text-right">
                                <div>
                                    <p class="text-sm font-medium text-brown">{{ $apt->appointment_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-stone-400">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</p>
                                </div>
                                @php $sc = ['confirmed'=>'bg-green-50 text-green-700 border-green-200','completed'=>'bg-blue-50 text-blue-700 border-blue-200','cancelled'=>'bg-red-50 text-red-700 border-red-200']; @endphp
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $sc[$apt->status] }}">{{ ucfirst($apt->status) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <a href="{{ route('client.book') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 btn-gold rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Book Appointment</span>
                    </a>
                    <a href="{{ route('client.appointments') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 bg-stone-200 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">My Appointments</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 bg-stone-200 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Edit Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

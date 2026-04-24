@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="bg-brown py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 btn-gold rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-white text-2xl font-bold">{{ mb_substr($specialist->user->name, 0, 1) }}</span>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $specialist->user->name }}</h1>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="px-2.5 py-0.5 bg-gold/20 text-gold text-xs font-semibold rounded-full border border-gold/30">Specialist</span>
                    @if($specialist->salon)
                        <span class="text-stone-400 text-sm">{{ $specialist->salon->name }}</span>
                    @endif
                    @if($specialist->rating)
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-stone-300 text-sm font-medium">{{ number_format($specialist->rating, 1) }}</span>
                        </div>
                    @endif
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
                        <p class="text-stone-700 mt-0.5">{{ $specialist->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Phone</p>
                        <p class="text-stone-700 mt-0.5">{{ $specialist->user->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Experience</p>
                        <p class="text-stone-700 mt-0.5">{{ $specialist->experience_years ?? 0 }} {{ Str::plural('year', $specialist->experience_years ?? 0) }}</p>
                    </div>
                    @if($specialist->salon)
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Salon</p>
                        <p class="text-stone-700 mt-0.5">{{ $specialist->salon->name }}</p>
                    </div>
                    @endif
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-5 inline-flex items-center text-sm font-semibold text-gold hover:underline">
                    Edit Profile &rarr;
                </a>
            </div>

            {{-- Bio --}}
            @if($specialist->bio)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-3">About Me</h2>
                <p class="text-stone-600 text-sm leading-relaxed">{{ $specialist->bio }}</p>
            </div>
            @endif

            {{-- Stats --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Statistics</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $totalCompleted }}</p>
                        <p class="text-xs text-stone-500 mt-1">Completed</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $reviews->count() }}</p>
                        <p class="text-xs text-stone-500 mt-1">Reviews</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $specialist->rating ? number_format($specialist->rating, 1) : '—' }}</p>
                        <p class="text-xs text-stone-500 mt-1">Avg Rating</p>
                    </div>
                    <div class="bg-cream rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-brown">{{ $totalCancelled }}</p>
                        <p class="text-xs text-stone-500 mt-1">Cancelled</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Services --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Services Offered</h2>
                @if($specialist->services->isEmpty())
                    <p class="text-stone-500 text-sm">No services assigned yet.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($specialist->services as $service)
                        <div class="flex items-center justify-between p-3 bg-cream rounded-xl">
                            <div>
                                <p class="font-medium text-brown text-sm">{{ $service->name }}</p>
                                @if($service->category)<p class="text-xs text-stone-400 mt-0.5">{{ $service->category }}</p>@endif
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gold">{{ number_format($service->price, 0, '.', ' ') }} ₸</p>
                                <p class="text-xs text-stone-400">{{ $service->duration_minutes }} min</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Reviews --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Client Reviews</h2>
                @if($reviews->isEmpty())
                    <p class="text-stone-500 text-sm text-center py-6">No reviews yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                        <div class="border-b border-stone-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-stone-200 rounded-full flex items-center justify-center">
                                        <span class="text-stone-600 text-xs font-bold">{{ mb_substr($review->client->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-semibold text-brown">{{ $review->client->name }}</span>
                                </div>
                                <div class="flex items-center space-x-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-gold' : 'text-stone-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-sm text-stone-600 mt-1 ml-10">{{ $review->comment }}</p>
                            @endif
                            <p class="text-xs text-stone-400 mt-1 ml-10">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
                <h2 class="font-semibold text-brown text-lg mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('specialist.dashboard') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 btn-gold rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">My Schedule</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-4 bg-cream rounded-xl hover:shadow-sm hover:border-gold/30 border border-transparent transition group">
                        <div class="w-9 h-9 bg-stone-200 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></div>
                        <span class="text-sm font-semibold text-brown group-hover:text-gold transition">Edit Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

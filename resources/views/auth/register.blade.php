@extends('layouts.app')
@section('title', 'Create Account')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-brown">Join GlowBook</h1>
            <p class="text-stone-500 mt-1">Create your account and start booking</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-8 border border-stone-200">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Phone Number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+7 7XX XXX XXXX" class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-2">I want to join as</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="client" class="peer sr-only" {{ old('role', 'client') === 'client' ? 'checked' : '' }}>
                            <div class="text-center py-2.5 px-2 rounded-2xl border border-stone-200 text-sm font-medium text-stone-600 peer-checked:border-gold peer-checked:bg-gold/10 peer-checked:text-gold hover:border-gold/50 transition">Client</div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="specialist" class="peer sr-only" {{ old('role') === 'specialist' ? 'checked' : '' }}>
                            <div class="text-center py-2.5 px-2 rounded-2xl border border-stone-200 text-sm font-medium text-stone-600 peer-checked:border-gold peer-checked:bg-gold/10 peer-checked:text-gold hover:border-gold/50 transition">Specialist</div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="salon_owner" class="peer sr-only" {{ old('role') === 'salon_owner' ? 'checked' : '' }}>
                            <div class="text-center py-2.5 px-2 rounded-2xl border border-stone-200 text-sm font-medium text-stone-600 peer-checked:border-gold peer-checked:bg-gold/10 peer-checked:text-gold hover:border-gold/50 transition">Salon Owner</div>
                        </label>
                    </div>
                    @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50">
                </div>
                <button type="submit" class="w-full btn-gold text-white py-3 rounded-2xl font-semibold text-sm transition">Create Account</button>
            </form>
        </div>
        <p class="text-center text-sm text-stone-500 mt-6">Already have an account? <a href="{{ route('login') }}" class="text-gold font-semibold hover:underline">Sign in</a></p>
    </div>
</div>
@endsection

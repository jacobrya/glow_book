@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
{{-- Заголовок в стиле GlowBook --}}
<div class="bg-brown py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 btn-gold rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden border-2 border-gold/30">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-white text-2xl font-bold">{{ mb_substr($user->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Edit Profile</h1>
                <p class="text-stone-400 mt-1">Update your account details and specialist profile</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

    {{-- Основная информация --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
        <h2 class="font-semibold text-brown text-lg mb-1">Profile Information</h2>
        <p class="text-stone-500 text-sm mb-5">Update your name, email, and profile picture.</p>

        {{-- ВАЖНО: добавлен enctype для загрузки фото --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            {{-- Поле Аватарки --}}
            <div>
                <label for="avatar" class="block text-sm font-medium text-stone-700 mb-1">Profile Photo</label>
                <input id="avatar" name="avatar" type="file" 
                    class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-gold hover:file:bg-gold/20 transition">
                @error('avatar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email Address</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Phone Number</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="+7 (___) ___-__-__"
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition">
            </div>

            {{-- Поля для Мастера --}}
            @if($user->isSpecialist() && isset($specialist))
            <div class="border-t border-stone-100 pt-4 mt-4 space-y-4">
                <p class="text-sm font-semibold text-brown">Specialist Details</p>
                <div>
                    <label for="bio" class="block text-sm font-medium text-stone-700 mb-1">Bio</label>
                    <textarea id="bio" name="bio" rows="3" class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:ring-gold transition resize-none">{{ old('bio', $specialist->bio) }}</textarea>
                </div>
                <div>
                    <label for="experience_years" class="block text-sm font-medium text-stone-700 mb-1">Years of Experience</label>
                    <input id="experience_years" name="experience_years" type="number" value="{{ old('experience_years', $specialist->experience_years) }}" class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:ring-gold transition">
                </div>
            </div>
            @endif

            {{-- Поля для Владельца Салона --}}
            @if($user->isSalonOwner() && isset($salon))
            <div class="border-t border-stone-100 pt-4 mt-4 space-y-4">
                <p class="text-sm font-semibold text-brown">Salon Details</p>
                <div>
                    <label for="salon_name" class="block text-sm font-medium text-stone-700 mb-1">Salon Name</label>
                    <input id="salon_name" name="salon_name" type="text" value="{{ old('salon_name', $salon->name) }}" class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:ring-gold transition">
                </div>
                {{-- Добавь остальные поля салона по аналогии (address, city и т.д.), если они нужны --}}
            </div>
            @endif

            <div class="flex items-center justify-between pt-2">
                <button type="submit" class="btn-gold text-white px-6 py-2.5 rounded-2xl font-semibold text-sm transition">
                    Save Changes
                </button>
                @if(session('status') === 'profile-updated')
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600 font-medium">Saved!</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Смена пароля --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
        <h2 class="font-semibold text-brown text-lg mb-1">Change Password</h2>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')
            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-stone-700 mb-1">Current Password</label>
                <input id="update_password_current_password" name="current_password" type="password" class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:ring-gold transition">
            </div>
            <div>
                <label for="update_password_password" class="block text-sm font-medium text-stone-700 mb-1">New Password</label>
                <input id="update_password_password" name="password" type="password" class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:ring-gold transition">
            </div>
            <button type="submit" class="btn-gold text-white px-6 py-2.5 rounded-2xl font-semibold text-sm transition">Update Password</button>
        </form>
    </div>

    {{-- Удаление аккаунта --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100" x-data="{ confirm: false }">
        <h2 class="font-semibold text-red-700 text-lg mb-1">Delete Account</h2>
        <p class="text-stone-500 text-sm mb-5">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
        <button @click="confirm = true" x-show="!confirm" class="px-5 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm font-semibold hover:bg-red-100 transition">Delete My Account</button>
        
        <div x-show="confirm" x-transition class="mt-4">
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-3">
                @csrf
                @method('delete')
                <input name="password" type="password" placeholder="Confirm your password" class="w-full border border-red-300 rounded-xl px-4 py-2.5 text-sm focus:ring-red-300">
                <div class="flex space-x-3">
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-2xl text-sm font-semibold">Confirm Delete</button>
                    <button type="button" @click="confirm = false" class="px-5 py-2.5 bg-stone-100 text-stone-600 rounded-2xl text-sm font-semibold">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="bg-brown py-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 btn-gold rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-white text-2xl font-bold">{{ mb_substr($user->name, 0, 1) }}</span>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Edit Profile</h1>
                <p class="text-stone-400 mt-1">Update your account details</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

    {{-- Profile Information --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
        <h2 class="font-semibold text-brown text-lg mb-1">Profile Information</h2>
        <p class="text-stone-500 text-sm mb-5">Update your name, email, and contact details.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('name') border-red-400 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email Address</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Phone Number</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="+7 (___) ___-__-__"
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('phone') border-red-400 @enderror">
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Specialist-specific fields --}}
            @if($user->isSpecialist() && $specialist)
            <div class="border-t border-stone-100 pt-4 mt-4 space-y-4">
                <p class="text-sm font-semibold text-brown">Specialist Details</p>

                <div>
                    <label for="bio" class="block text-sm font-medium text-stone-700 mb-1">Bio</label>
                    <textarea id="bio" name="bio" rows="3" placeholder="Tell clients about yourself..."
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition resize-none @error('bio') border-red-400 @enderror">{{ old('bio', $specialist->bio) }}</textarea>
                    @error('bio')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="experience_years" class="block text-sm font-medium text-stone-700 mb-1">Years of Experience</label>
                    <input id="experience_years" name="experience_years" type="number" min="0" max="60"
                        value="{{ old('experience_years', $specialist->experience_years) }}"
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('experience_years') border-red-400 @enderror">
                    @error('experience_years')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            @endif

            {{-- Owner-specific salon fields --}}
            @if($user->isSalonOwner() && $salon)
            <div class="border-t border-stone-100 pt-4 mt-4 space-y-4">
                <p class="text-sm font-semibold text-brown">Salon Details</p>

                <div>
                    <label for="salon_name" class="block text-sm font-medium text-stone-700 mb-1">Salon Name</label>
                    <input id="salon_name" name="salon_name" type="text" value="{{ old('salon_name', $salon->name) }}" required
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('salon_name') border-red-400 @enderror">
                    @error('salon_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="salon_address" class="block text-sm font-medium text-stone-700 mb-1">Address</label>
                    <input id="salon_address" name="salon_address" type="text" value="{{ old('salon_address', $salon->address) }}"
                        placeholder="e.g. Tole Bi St 59"
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('salon_address') border-red-400 @enderror">
                    @error('salon_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="salon_city" class="block text-sm font-medium text-stone-700 mb-1">City</label>
                    <select id="salon_city" name="salon_city"
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('salon_city') border-red-400 @enderror">
                        <option value="">— Select City —</option>
                        @foreach(\App\Models\Salon::$cities as $city)
                            <option value="{{ $city }}" {{ old('salon_city', $salon->city) === $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    @error('salon_city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="salon_phone" class="block text-sm font-medium text-stone-700 mb-1">Salon Phone</label>
                    <input id="salon_phone" name="salon_phone" type="text" value="{{ old('salon_phone', $salon->phone) }}"
                        placeholder="+7 (___) ___-__-__"
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('salon_phone') border-red-400 @enderror">
                    @error('salon_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="salon_description" class="block text-sm font-medium text-stone-700 mb-1">Description</label>
                    <textarea id="salon_description" name="salon_description" rows="3"
                        placeholder="Describe your salon..."
                        class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition resize-none @error('salon_description') border-red-400 @enderror">{{ old('salon_description', $salon->description) }}</textarea>
                    @error('salon_description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between pt-2">
                <button type="submit" class="btn-gold text-white px-6 py-2.5 rounded-2xl font-semibold text-sm transition">
                    Save Changes
                </button>
                @if(session('success'))
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm text-green-600 font-medium">Saved!</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200">
        <h2 class="font-semibold text-brown text-lg mb-1">Change Password</h2>
        <p class="text-stone-500 text-sm mb-5">Use a strong password to keep your account secure.</p>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-stone-700 mb-1">Current Password</label>
                <input id="current_password" name="current_password" type="password"
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('current_password', 'updatePassword') border-red-400 @enderror">
                @error('current_password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-stone-700 mb-1">New Password</label>
                <input id="password" name="password" type="password"
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition @error('password', 'updatePassword') border-red-400 @enderror">
                @error('password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">Confirm New Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold transition">
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-gold text-white px-6 py-2.5 rounded-2xl font-semibold text-sm transition">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    {{-- Back link --}}
    <div class="text-center pb-4">
        @if($user->isClient())
            <a href="{{ route('client.profile') }}" class="text-sm text-gold font-semibold hover:underline">&larr; Back to My Profile</a>
        @elseif($user->isSpecialist())
            <a href="{{ route('specialist.profile') }}" class="text-sm text-gold font-semibold hover:underline">&larr; Back to My Profile</a>
        @elseif($user->isSalonOwner())
            <a href="{{ route('owner.profile') }}" class="text-sm text-gold font-semibold hover:underline">&larr; Back to My Profile</a>
        @else
            <a href="{{ route('dashboard') }}" class="text-sm text-gold font-semibold hover:underline">&larr; Back to Dashboard</a>
        @endif
    </div>

    {{-- Delete Account --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100" x-data="{ confirm: false }">
        <h2 class="font-semibold text-red-700 text-lg mb-1">Delete Account</h2>
        <p class="text-stone-500 text-sm mb-5">Permanently delete your account and all associated data. This cannot be undone.</p>

        <button @click="confirm = true" x-show="!confirm"
            class="px-5 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-2xl text-sm font-semibold hover:bg-red-100 transition">
            Delete My Account
        </button>

        <div x-show="confirm" x-transition class="space-y-4">
            <p class="text-sm text-red-600 font-medium">Please enter your password to confirm account deletion.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-3">
                @csrf
                @method('DELETE')
                <input name="password" type="password" placeholder="Your password"
                    class="w-full border border-red-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition @error('password', 'userDeletion') border-red-500 @enderror">
                @error('password', 'userDeletion')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                <div class="flex items-center space-x-3">
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-2xl text-sm font-semibold hover:bg-red-700 transition">
                        Confirm Delete
                    </button>
                    <button type="button" @click="confirm = false" class="px-5 py-2.5 bg-stone-100 text-stone-600 rounded-2xl text-sm font-semibold hover:bg-stone-200 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

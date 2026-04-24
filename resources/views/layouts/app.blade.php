<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GlowBook — @yield('title', 'Beauty Salon Booking')</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💄</text></svg>">    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F5F0E8',
                        gold: '#C9A96E',
                        'gold-dark': '#a8845a',
                        brown: '#3D2B1F',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .btn-gold { background: linear-gradient(135deg, #C9A96E 0%, #a8845a 100%); }
        .btn-gold:hover { opacity: 0.9; }
    </style>
</head>
<body class="bg-cream min-h-screen flex flex-col text-[#1a1a1a]">
<nav class="bg-brown sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold text-gold tracking-wide">GlowBook</a>

            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Home</a>
                <a href="{{ route('salons') }}" class="{{ request()->routeIs('salons') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Salons</a>
                <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Services</a>
                <a href="{{ route('specialists') }}" class="{{ request()->routeIs('specialists') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Specialists</a>

                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Dashboard</a>
                        <a href="{{ route('client.book') }}" class="btn-gold text-white px-4 py-2 rounded-2xl font-semibold text-sm transition">Book Now</a>
                    @elseif(auth()->user()->isSpecialist())
                        <a href="{{ route('specialist.dashboard') }}" class="{{ request()->routeIs('specialist.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">My Schedule</a>
                    @elseif(auth()->user()->isSalonOwner())
                        <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">My Salon</a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Admin</a>
                    @endif

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-stone-300 hover:text-gold transition">
                            <div class="w-8 h-8 bg-gold/20 rounded-full flex items-center justify-center">
                                <span class="text-gold text-sm font-semibold">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl py-2 border border-stone-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-stone-700 hover:bg-cream transition">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-gold' : 'text-stone-300' }} hover:text-gold transition text-sm font-medium">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-gold text-white px-4 py-2 rounded-2xl font-semibold text-sm transition">Get Started</a>
                @endauth
            </div>

            <div class="md:hidden" x-data="{ mobileOpen: false }">
                <button @click="mobileOpen = !mobileOpen" class="text-stone-300 hover:text-gold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition class="absolute top-16 left-0 right-0 bg-brown border-t border-stone-700 shadow-xl p-4 space-y-3">
                    <a href="{{ route('home') }}" class="block {{ request()->routeIs('home') ? 'text-gold font-bold' : 'text-stone-300' }} hover:text-gold transition py-1">Home</a>
                    <a href="{{ route('salons') }}" class="block {{ request()->routeIs('salons') ? 'text-gold font-bold' : 'text-stone-300' }} hover:text-gold transition py-1">Salons</a>
                    <a href="{{ route('services') }}" class="block {{ request()->routeIs('services') ? 'text-gold font-bold' : 'text-stone-300' }} hover:text-gold transition py-1">Services</a>
                    <a href="{{ route('specialists') }}" class="block {{ request()->routeIs('specialists') ? 'text-gold font-bold' : 'text-stone-300' }} hover:text-gold transition py-1">Specialists</a>
                    @auth
                        @if(auth()->user()->isClient())
                            <a href="{{ route('client.dashboard') }}" class="block {{ request()->routeIs('client.dashboard') ? 'text-gold' : 'text-stone-300' }} py-1">Dashboard</a>
                            <a href="{{ route('client.book') }}" class="block text-gold font-semibold py-1">Book Now</a>
                        @elseif(auth()->user()->isSpecialist())
                            <a href="{{ route('specialist.dashboard') }}" class="block {{ request()->routeIs('specialist.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold py-1">My Schedule</a>
                        @elseif(auth()->user()->isSalonOwner())
                            <a href="{{ route('owner.dashboard') }}" class="block {{ request()->routeIs('owner.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold py-1">My Salon</a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block {{ request()->routeIs('admin.dashboard') ? 'text-gold' : 'text-stone-300' }} hover:text-gold py-1">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="block text-stone-400 hover:text-red-400 py-1">Sign Out</button></form>
                    @else
                        <a href="{{ route('login') }}" class="block {{ request()->routeIs('login') ? 'text-gold' : 'text-stone-300' }} py-1">Sign In</a>
                        <a href="{{ route('register') }}" class="block text-gold font-semibold py-1">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl flex items-center space-x-2">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    </div>
@endif

<main class="flex-1">@yield('content')</main>

<footer class="bg-cream border-t border-stone-200 mt-12">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <span class="text-lg font-bold text-brown">GlowBook</span>
                <p class="text-sm text-stone-500 mt-2">Your premier beauty booking platform in Kazakhstan.</p>
            </div>

            <div>
                <h4 class="text-brown font-semibold mb-3 text-sm uppercase tracking-wider">Quick Links</h4>
                <div class="space-y-2">
                    <a href="{{ route('salons') }}" class="block text-sm text-stone-500 hover:text-gold transition">Salons</a>
                    <a href="{{ route('services') }}" class="block text-sm text-stone-500 hover:text-gold transition">Services</a>
                    <a href="{{ route('specialists') }}" class="block text-sm text-stone-500 hover:text-gold transition">Specialists</a>
                </div>
            </div>

            <div>
                <h4 class="text-brown font-semibold mb-3 text-sm uppercase tracking-wider">Contact</h4>
                <div class="space-y-2 text-sm text-stone-500">
                    <p>Tole Bi St 59, Almaty</p>
                    <p>+7 (727) 123-45-67</p>
                    <p>hello@glowbook.kz</p>
                </div>
            </div>

            <div>
                <h4 class="text-brown font-semibold mb-3 text-sm uppercase tracking-wider">Working Hours</h4>
                <div class="space-y-2 text-sm text-stone-500 mb-4">
                    <p>Mon – Fri: 09:00 – 21:00</p>
                    <p>Sat – Sun: 10:00 – 20:00</p>
                </div>

                <h4 class="text-brown font-semibold mb-3 text-sm uppercase tracking-wider">Follow Us</h4>
                <div class="space-y-2 text-sm text-stone-500">
                    <p>Instagram: @glowbook.kz</p>
                    <p>Telegram: @glowbook_support</p>
                    <p>TikTok: @glowbook.kz</p>
                </div>
            </div>
        </div>
        <div class="border-t border-stone-200 mt-8 pt-6 text-center text-sm text-stone-400">&copy; {{ date('Y') }} GlowBook. All rights reserved.</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 bg-gold text-white w-10 h-10 rounded-full shadow-md hover:opacity-80 transition">
    ↑
</button>
</body>
</html>

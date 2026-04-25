<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GlowBook — @yield('title', 'Beauty Salon Booking')</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💄</text></svg>">

    <script src="https://cdn.tailwindcss.com"></script>
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
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-stone-300 hover:text-gold transition">
                            <div class="w-8 h-8 bg-gold/20 rounded-full flex items-center justify-center overflow-hidden border border-gold/30">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gold text-sm font-semibold">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl py-2 border border-stone-200">
                            @if(auth()->user()->isClient())
                                <a href="{{ route('client.profile') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-cream transition">My Profile</a>
                            @elseif(auth()->user()->isSpecialist())
                                <a href="{{ route('specialist.profile') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-cream transition">My Profile</a>
                            @elseif(auth()->user()->isSalonOwner())
                                <a href="{{ route('owner.profile') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-cream transition">My Profile</a>
                            @endif

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-cream transition">Settings</a>
                            
                            <div class="border-t border-stone-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-stone-700 hover:bg-cream transition">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-stone-300 hover:text-gold transition text-sm font-medium">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-gold text-white px-4 py-2 rounded-2xl font-semibold text-sm transition">Get Started</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl flex items-center space-x-2">
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

<main class="flex-1">@yield('content')</main>

<footer class="bg-cream border-t border-stone-200 mt-12">
    <div class="max-w-7xl mx-auto px-4 py-12"> <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12"> <div>
                <h4 class="text-brown font-bold mb-4 text-xl">GlowBook</h4>
                <p class="text-lg text-stone-500 leading-relaxed font-light">
                    Your premier beauty booking platform in Kazakhstan.
                </p>
            </div>

            <div>
                <h4 class="text-brown font-bold mb-4 text-xs uppercase tracking-wider">Quick Links</h4>
                <div class="space-y-2">
                    <a href="{{ route('salons') }}" class="block text-lg text-stone-500 hover:text-gold transition font-light">Salons</a>
                    <a href="{{ route('services') }}" class="block text-lg text-stone-500 hover:text-gold transition font-light">Services</a>
                    <a href="{{ route('specialists') }}" class="block text-lg text-stone-500 hover:text-gold transition font-light">Specialists</a>
                </div>
            </div>

            <div>
                <h4 class="text-brown font-bold mb-4 text-xs uppercase tracking-wider">Follow Us</h4>
                <div class="space-y-2 text-lg text-stone-500 font-light">
                    <a href="#" class="block hover:text-gold transition">Instagram: @glowbook.kz</a>
                    <a href="#" class="block hover:text-gold transition">Telegram: @glowbook_support</a>
                    <a href="#" class="block hover:text-gold transition">TikTok: @glowbook.kz</a>
                </div>
            </div>

            <div>
                <h4 class="text-brown font-bold mb-4 text-xs uppercase tracking-wider">Working Hours</h4>
                <div class="space-y-1 text-lg text-stone-500 font-light">
                    <p>Mon – Fri: 09:00 – 21:00</p>
                    <p>Sat – Sun: 10:00 – 20:00</p>
                </div>
            </div>
        </div>

        <div class="border-t border-stone-100 pt-10">
            <h4 class="text-brown font-bold mb-6 text-xs uppercase tracking-wider text-center">Our Locations</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="group rounded-3xl overflow-hidden shadow-sm border border-stone-200 bg-white transition-all duration-500 hover:shadow-xl hover:-translate-y-2">
                    <div class="p-4 bg-white">
                        <p class="text-base font-bold text-brown uppercase">📍 Almaty Branch</p>
                        <p class="text-sm text-stone-400 font-light">Abay Ave 52, Almaty</p>
                    </div>
                    <iframe
                        width="100%" height="200" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.7753383083425!2d76.91428231548446!3d43.23514797913783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836ec800569739%3A0x6b6375084992520!2sAbay%20Ave%2052%2C%20Almaty!5e0!3m2!1sen!2skz!4v1647856321234!5m2!1sen!2skz"
                        class="grayscale group-hover:grayscale-0 transition-all duration-700"
                        allowfullscreen></iframe>
                </div>

                <div class="group rounded-3xl overflow-hidden shadow-sm border border-stone-200 bg-white transition-all duration-500 hover:shadow-xl hover:-translate-y-2">
                    <div class="p-4 bg-white">
                        <p class="text-base font-bold text-brown uppercase">📍 Astana Branch</p>
                        <p class="text-sm text-stone-400 font-light">Mangilik El Ave 34, Astana</p>
                    </div>
                    <iframe
                        width="100%" height="200" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2504.484213123456!2d71.42854321578901!3d51.12345678901234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4245869400000001%3A0x1234567890abcdef!2sMangilik%20El%20Ave%2034%2C%20Astana!5e0!3m2!1sen!2skz!4v1647856324321!5m2!1sen!2skz"
                        class="grayscale group-hover:grayscale-0 transition-all duration-700"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <div class="border-t border-stone-200 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-[10px] text-stone-400 uppercase tracking-widest font-light">
            <p>© {{ date('Y') }} GlowBook. All beauty rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-brown transition">Privacy Policy</a>
                <a href="#" class="hover:text-brown transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 bg-gold text-white w-10 h-10 rounded-full shadow-md hover:opacity-80 transition z-50">
    ↑
</button>
</body>
</html>
@extends('layouts.app')
@section('title', 'All Appointments')
@section('content')
<div class="bg-brown py-10"><div class="max-w-7xl mx-auto px-4"><h1 class="text-2xl md:text-3xl font-bold text-white">All Appointments</h1><p class="text-stone-400 mt-1">View and filter all bookings</p></div></div>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-4 mb-6">
        <div class="flex flex-wrap gap-3 items-center">
            <span class="text-sm font-medium text-stone-600">Filter:</span>
            <a href="{{ route('admin.appointments') }}" class="px-4 py-1.5 text-sm rounded-full border {{ !request('status') ? 'bg-brown text-white border-brown' : 'border-stone-200 text-stone-600 hover:border-gold' }} transition">All</a>
            @foreach(['confirmed', 'completed', 'cancelled'] as $status)
            <a href="{{ route('admin.appointments', ['status' => $status]) }}" class="px-4 py-1.5 text-sm rounded-full border {{ request('status') === $status ? 'bg-brown text-white border-brown' : 'border-stone-200 text-stone-600 hover:border-gold' }} transition">{{ ucfirst($status) }}</a>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-cream border-b border-stone-200"><tr>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Date & Time</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Client</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Salon</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Specialist</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Service</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Price</th>
                    <th class="text-left px-5 py-3 font-semibold text-stone-600">Status</th>
                </tr></thead>
                <tbody class="divide-y divide-stone-50">
                    @foreach($appointments as $apt)
                    <tr class="hover:bg-cream/50">
                        <td class="px-5 py-3"><p class="font-medium text-brown">{{ $apt->appointment_date->format('M d, Y') }}</p><p class="text-xs text-stone-400">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</p></td>
                        <td class="px-5 py-3 text-stone-700">{{ $apt->client->name }}</td>
                        <td class="px-5 py-3 text-stone-700">{{ $apt->salon->name }}</td>
                        <td class="px-5 py-3 text-stone-700">{{ $apt->specialist->user->name }}</td>
                        <td class="px-5 py-3 text-stone-700">{{ $apt->service->name }}</td>
                        <td class="px-5 py-3 text-gold font-semibold">{{ number_format($apt->service->price, 0, '.', ' ') }} ₸</td>
                        <td class="px-5 py-3">@php $sc=['confirmed'=>'bg-green-50 text-green-700 border-green-200','completed'=>'bg-blue-50 text-blue-700 border-blue-200','cancelled'=>'bg-red-50 text-red-700 border-red-200']; @endphp<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $sc[$apt->status] }}">{{ ucfirst($apt->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div>

    </div>
@endsection

@extends('layouts.app')
@section('title', 'Edit Salon')
@section('content')
<div class="bg-brown py-10"><div class="max-w-7xl mx-auto px-4"><h1 class="text-2xl font-bold text-white">Edit Salon</h1></div></div>
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.salons.update', $salon) }}" class="space-y-5">@csrf @method('PUT')
            <div><label class="block text-sm font-medium text-stone-700 mb-1">Salon Name</label><input type="text" name="name" value="{{ old('name', $salon->name) }}" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50"></div>
            <div><label class="block text-sm font-medium text-stone-700 mb-1">Description</label><textarea name="description" rows="3" class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50 resize-none">{{ old('description', $salon->description) }}</textarea></div>
            <div><label class="block text-sm font-medium text-stone-700 mb-1">Address</label><input type="text" name="address" value="{{ old('address', $salon->address) }}" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50"></div>
            <div><label class="block text-sm font-medium text-stone-700 mb-1">City</label><select name="city" class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50"><option value="">— Select City —</option>@foreach(\App\Models\Salon::$cities as $city)<option value="{{ $city }}" {{ old('city', $salon->city) === $city ? 'selected' : '' }}>{{ $city }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-stone-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', $salon->phone) }}" class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none text-sm bg-cream/50"></div>
            <div><label class="block text-sm font-medium text-stone-700 mb-1">Owner</label><select name="owner_id" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm bg-cream/50 focus:border-gold outline-none">@foreach($owners as $o)<option value="{{ $o->id }}" {{ $salon->owner_id == $o->id ? 'selected' : '' }}>{{ $o->name }} ({{ $o->email }})</option>@endforeach</select></div>
            <div class="flex space-x-3 pt-2"><button type="submit" class="flex-1 btn-gold text-white py-3 rounded-2xl font-semibold text-sm transition">Update Salon</button><a href="{{ route('admin.salons') }}" class="flex-1 text-center py-3 bg-stone-100 text-stone-700 rounded-2xl font-semibold text-sm hover:bg-stone-200 transition">Cancel</a></div>
        </form>
    </div>
</div>
@endsection

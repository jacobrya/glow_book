<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Salon;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $todayBookings = Appointment::where('appointment_date', now()->toDateString())->count();
        $totalRevenue = Appointment::where('status', 'completed')->with('service')->get()->sum(fn($a) => $a->service->price);
        $totalSalons = Salon::count();
        $totalUsers = User::count();
        return view('admin.dashboard', compact('todayBookings', 'totalRevenue', 'totalSalons', 'totalUsers'));
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with(['client', 'specialist.user', 'service', 'salon']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $appointments = $query->orderByDesc('appointment_date')->orderByDesc('appointment_time')->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function salons()
    {
        $salons = Salon::with(['owner', 'specialists', 'services'])->get();
        return view('admin.salons.index', compact('salons'));
    }

    public function createSalon()
    {
        $owners = User::where('role', 'salon_owner')->get();
        return view('admin.salons.create', compact('owners'));
    }

    public function storeSalon(Request $request)
    {
        $this->authorize('create', Salon::class);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string|max:500',
            'city'        => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:20',
            'owner_id'    => 'required|exists:users,id',
        ]);
        Salon::create($request->only(['name', 'description', 'address', 'city', 'phone', 'owner_id']));
        return redirect()->route('admin.salons')->with('success', 'Salon created!');
    }

    public function editSalon(Salon $salon)
    {
        $this->authorize('update', $salon);
        $owners = User::where('role', 'salon_owner')->get();
        return view('admin.salons.edit', compact('salon', 'owners'));
    }

    public function updateSalon(Request $request, Salon $salon)
    {
        $this->authorize('update', $salon);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string|max:500',
            'city'        => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:20',
            'owner_id'    => 'required|exists:users,id',
        ]);
        $salon->update($request->only(['name', 'description', 'address', 'city', 'phone', 'owner_id']));
        return redirect()->route('admin.salons')->with('success', 'Salon updated!');
    }

    public function destroySalon(Salon $salon)
    {
        $this->authorize('delete', $salon);
        $salon->delete();
        return redirect()->route('admin.salons')->with('success', 'Salon deleted.');
    }
}

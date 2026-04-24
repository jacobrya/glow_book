<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    private function salon()
    {
        return Salon::where('owner_id', auth()->id())->first();
    }

    public function dashboard()
    {
        $salon = $this->salon();

        if (!$salon) {
            return view('owner.no-salon');
        }

        $todayBookings = Appointment::where('salon_id', $salon->id)->where('appointment_date', now()->toDateString())->count();
        $totalRevenue = Appointment::where('salon_id', $salon->id)->where('status', 'completed')->with('service')->get()->sum(fn($a) => $a->service->price);
        $activeSpecialists = Specialist::where('salon_id', $salon->id)->count();
        return view('owner.dashboard', compact('salon', 'todayBookings', 'totalRevenue', 'activeSpecialists'));
    }

    public function specialists()
    {
        $salon = $this->salon();
        if (!$salon) return redirect()->route('owner.dashboard');
        $specialists = Specialist::where('salon_id', $salon->id)->with(['user', 'services'])->get();
        $availableUsers = User::where('role', 'specialist')->whereDoesntHave('specialist')->get();
        return view('owner.specialists', compact('salon', 'specialists', 'availableUsers'));
    }

    public function addSpecialist(Request $request)
    {
        $this->authorize('create', Specialist::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bio' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
        ]);

        $salon = $this->salon();
        if (!$salon) return redirect()->route('owner.dashboard');
        Specialist::create([
            'user_id' => $request->user_id,
            'salon_id' => $salon->id,
            'bio' => $request->bio,
            'experience_years' => $request->experience_years,
        ]);

        return back()->with('success', 'Specialist added successfully!');
    }

    public function removeSpecialist(Specialist $specialist)
    {
        $this->authorize('delete', $specialist);
        $specialist->delete();
        return back()->with('success', 'Specialist removed.');
    }


    public function services()
    {
        $salon = $this->salon();
        if (!$salon) return redirect()->route('owner.dashboard');
        $services = Service::where('salon_id', $salon->id)->get();
        return view('owner.services.index', compact('salon', 'services'));
    }

    public function createService()
    {
        if (!$this->salon()) return redirect()->route('owner.dashboard');
        return view('owner.services.create');
    }

    public function storeService(Request $request)
    {
        $this->authorize('create', Service::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'category' => 'nullable|string|max:100',
        ]);

        $salon = $this->salon();
        if (!$salon) return redirect()->route('owner.dashboard');
        Service::create(array_merge($request->only(['name', 'description', 'price', 'duration_minutes', 'category']), ['salon_id' => $salon->id]));

        return redirect()->route('owner.services')->with('success', 'Service created successfully!');
    }

    public function editService(Service $service)
    {
        $this->authorize('update', $service);
        return view('owner.services.edit', compact('service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'category' => 'nullable|string|max:100',
        ]);

        $service->update($request->only(['name', 'description', 'price', 'duration_minutes', 'category']));
        return redirect()->route('owner.services')->with('success', 'Service updated!');
    }

    public function destroyService(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('owner.services')->with('success', 'Service deleted.');
    }

    public function profile()
    {
        $user = auth()->user();
        $salon = $this->salon();

        if (!$salon) {
            return view('owner.no-salon');
        }

        $salon->load(['specialists.user', 'services']);
        $totalAppointments = Appointment::where('salon_id', $salon->id)->count();
        $totalRevenue = Appointment::where('salon_id', $salon->id)->where('status', 'completed')->with('service')->get()->sum(fn($a) => $a->service->price);
        $specialistCount = $salon->specialists->count();
        $serviceCount = $salon->services->count();

        return view('owner.profile', compact('user', 'salon', 'totalAppointments', 'totalRevenue', 'specialistCount', 'serviceCount'));
    }

    public function appointments()
    {
        $salon = $this->salon();
        if (!$salon) return redirect()->route('owner.dashboard');
        $appointments = Appointment::where('salon_id', $salon->id)->with(['client', 'specialist.user', 'service'])->orderByDesc('appointment_date')->orderByDesc('appointment_time')->get();
        return view('owner.appointments', compact('salon', 'appointments'));
    }
}

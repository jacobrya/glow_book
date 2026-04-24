<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsAppNotification;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        $upcoming = Appointment::where('client_id', auth()->id())
            ->where('status', 'confirmed')
            ->where('appointment_date', '>=', now()->toDateString())
            ->with(['specialist.user', 'service', 'salon'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('client.dashboard', compact('upcoming'));
    }

    public function appointments()
    {
        $appointments = Appointment::where('client_id', auth()->id())
            ->with(['specialist.user', 'service', 'salon', 'review'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        return view('client.appointments', compact('appointments'));
    }

    public function bookForm(Request $request)
    {
        $salons = Salon::all();
        $selectedSalon = $request->query('salon_id') ? Salon::find($request->query('salon_id')) : null;
        $services = collect();
        $specialists = collect();
        $availableSlots = [];
        $selectedService = null;
        $selectedSpecialist = null;
        $selectedDate = $request->query('date');

        if ($selectedSalon) {
            $services = Service::where('salon_id', $selectedSalon->id)->get();
            $selectedService = $request->query('service_id') ? Service::find($request->query('service_id')) : null;
        }

        if ($selectedService) {
            $specialists = Specialist::where('salon_id', $selectedSalon->id)
                ->whereHas('services', fn($q) => $q->where('services.id', $selectedService->id))
                ->with('user')->get();
            $selectedSpecialist = $request->query('specialist_id') ? Specialist::with('user')->find($request->query('specialist_id')) : null;
        }

        if ($selectedSpecialist && $selectedDate) {
            $booked = Appointment::where('specialist_id', $selectedSpecialist->id)
                ->where('appointment_date', $selectedDate)
                ->where('status', 'confirmed')
                ->pluck('appointment_time')
                ->map(fn($t) => substr($t, 0, 5))
                ->toArray();

            $allSlots = [];
            for ($m = 9 * 60; $m < 20 * 60; $m += 30) {
                $allSlots[] = sprintf('%02d:%02d', intdiv($m, 60), $m % 60);
            }
            $availableSlots = array_diff($allSlots, $booked);
        }

        return view('client.book', compact('salons', 'selectedSalon', 'services', 'selectedService', 'specialists', 'selectedSpecialist', 'selectedDate', 'availableSlots'));
    }

    public function bookStore(Request $request)
    {
        $request->validate([
            'salon_id' => 'required|exists:salons,id',
            'service_id' => 'required|exists:services,id',
            'specialist_id' => 'required|exists:specialists,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $exists = Appointment::where('specialist_id', $request->specialist_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', 'confirmed')
            ->exists();

        if ($exists) {
            return back()->with('error', 'This time slot is already booked. Please choose another.');
        }

        $appointment = Appointment::create([
            'client_id'        => auth()->id(),
            'specialist_id'    => $request->specialist_id,
            'service_id'       => $request->service_id,
            'salon_id'         => $request->salon_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => 'confirmed',
            'notes'            => $request->notes,
        ]);

        SendWhatsAppNotification::dispatch($appointment);

        return redirect()->route('client.appointments')->with('success', 'Appointment booked and confirmed!');
    }

    public function profile()
    {
        $user = auth()->user();
        $total = Appointment::where('client_id', $user->id)->count();
        $completed = Appointment::where('client_id', $user->id)->where('status', 'completed')->count();
        $cancelled = Appointment::where('client_id', $user->id)->where('status', 'cancelled')->count();
        $reviewsGiven = Review::where('client_id', $user->id)->count();
        $recentAppointments = Appointment::where('client_id', $user->id)
            ->with(['specialist.user', 'service', 'salon'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->limit(5)
            ->get();

        return view('client.profile', compact('user', 'total', 'completed', 'cancelled', 'reviewsGiven', 'recentAppointments'));
    }

    public function storeReview(Request $request, Appointment $appointment)
    {
        $this->authorize('review', $appointment);

        if ($appointment->status !== 'completed') {
            return back()->with('error', 'You can only review completed appointments.');
        }

        if ($appointment->review !== null) {
            return back()->with('error', 'You have already reviewed this appointment.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'client_id' => auth()->id(),
            'specialist_id' => $appointment->specialist_id,
            'appointment_id' => $appointment->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $appointment->specialist->updateRating();

        return back()->with('success', 'Thank you for your review!');
    }
}

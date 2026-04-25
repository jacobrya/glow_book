<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Specialist; // Added Specialist model
use App\Models\Review;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    /**
     * Display the specialist's dashboard with today's and all appointments.
     */
    public function dashboard()
    {
        $specialist = auth()->user()->specialist;

        if (!$specialist) {
            return view('specialist.no-salon');
        }

        $todayAppointments = Appointment::where('specialist_id', $specialist->id)
            ->where('appointment_date', now()->toDateString())
            ->with(['client', 'service'])
            ->orderBy('appointment_time')
            ->get();

        $allAppointments = Appointment::where('specialist_id', $specialist->id)
            ->with(['client', 'service', 'salon'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        return view('specialist.dashboard', compact('todayAppointments', 'allAppointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $specialist = auth()->user()->specialist;
        if (!$specialist || $appointment->specialist_id !== $specialist->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        $msg = $request->status === 'completed' ? 'Appointment marked as completed!' : 'Appointment has been cancelled.';
        return back()->with('success', $msg);
    }
}

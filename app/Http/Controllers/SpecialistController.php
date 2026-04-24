<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
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

    public function profile()
    {
        $specialist = auth()->user()->specialist;

        if (!$specialist) {
            return view('specialist.no-salon');
        }

        $specialist->load(['user', 'salon', 'services']);
        $totalCompleted = Appointment::where('specialist_id', $specialist->id)->where('status', 'completed')->count();
        $totalCancelled = Appointment::where('specialist_id', $specialist->id)->where('status', 'cancelled')->count();
        $reviews = Review::where('specialist_id', $specialist->id)->with('client')->orderByDesc('created_at')->get();

        return view('specialist.profile', compact('specialist', 'totalCompleted', 'totalCancelled', 'reviews'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorize('updateStatus', $appointment);

        $request->validate([
            'status' => 'required|in:completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        $msg = $request->status === 'completed' ? 'Appointment marked as completed!' : 'Appointment has been cancelled.';
        return back()->with('success', $msg);
    }
}

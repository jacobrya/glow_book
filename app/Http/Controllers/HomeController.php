<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Display the landing page with featured content.
     */
    public function index()
    {
        $salons = Salon::with('specialists')->get();
        $services = Service::with('salon')->take(6)->get();

        // FEATURE: Fetch the top specialist of the current month
        $topMaster = Specialist::getMasterOfTheMonth();

        return view('home', compact('salons', 'services', 'topMaster'));
    }

    /**
     * Display a listing of all salons.
     */
    public function salons()
    {
        $salons = Salon::with('specialists', 'services')->get();
        return view('salons.index', compact('salons'));
    }

    /**
     * Display a specific salon with its specialists and recent reviews.
     */
    public function showSalon(Salon $salon)
    {
        $salon->load(['specialists.user', 'specialists.services', 'specialists.reviews', 'services']);

        // Fetch the 6 most recent reviews for this specific salon
        $reviews = Review::whereIn('specialist_id', $salon->specialists->pluck('id'))
            ->with(['client', 'specialist.user'])
            ->latest()
            ->take(6)
            ->get();

        return view('salons.show', compact('salon', 'reviews'));
    }

    /**
     * Display a listing of all available services.
     */
    public function services()
    {
        // Fetch all services with their associated salon
        $services = Service::with('salon')->get();

        // Fetch the best specialist of the current month for the recommendation banner
        $topMaster = Specialist::getMasterOfTheMonth();

        return view('services.index', compact('services', 'topMaster'));
    }

    /**
     * Display a listing of all specialists.
     */
    public function specialists()
    {
        // Загружаем всех специалистов с их данными
        $specialists = Specialist::with(['user', 'salon', 'services', 'reviews'])->get();

        // Получаем нашего чемпиона месяца
        $topMaster = Specialist::getMasterOfTheMonth();

        return view('specialists.index', compact('specialists', 'topMaster'));
    }
}

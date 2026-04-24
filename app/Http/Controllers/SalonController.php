<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index(Request $request)
    {
        $query = Salon::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->filled('city') && $request->city !== 'all') {
            $query->byCity($request->city);
        }

        if ($request->sort === 'top') {
            $query->bestRated();
        }

        $salons = $query->with(['specialists', 'services'])->get();
        $cities = Salon::$cities;

        return view('salons.index', compact('salons', 'cities'));
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Fishpond;
use App\Models\TempHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $fishponds = Fishpond::with(['temp_histories' => function($query) {
            $query->latest()->limit(1);
        }])->get();

        $tempHistories = TempHistory::with('fishpond')->latest()->get();

        return Inertia::render('Dashboard', [
            'fishponds' => $fishponds,
            'tempHistories'=> $tempHistories
        ]);
    }

}

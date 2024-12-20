<?php

namespace App\Http\Controllers;

use App\Http\Resources\DashboardFishpondCardsResource;
use Inertia\Inertia;
use App\Models\Fishpond;
use App\Models\TempHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $fishponds = Fishpond::select('fishponds.*')
            ->leftJoin('temp_histories', function($join) {
                $join->on('fishponds.id', '=', 'temp_histories.fishpond_id')
                     ->whereIn('temp_histories.id', function($query) {
                         $query->select(\DB::raw('MAX(id)'))
                               ->from('temp_histories as th')
                               ->whereRaw('th.fishpond_id = temp_histories.fishpond_id')
                               ->groupBy('th.fishpond_id');
                     });
            })
            ->addSelect(['latest_temp' => 'temp_histories.temperature'])
            ->get();
        $tempHistories = TempHistory::with('fishpond')->latest()->get();

        return Inertia::render('Dashboard', [
            'fishponds' => $fishponds,
            'tempHistories' => $tempHistories
        ]);
    }

}

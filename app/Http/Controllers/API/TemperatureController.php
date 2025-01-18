<?php

namespace App\Http\Controllers\API;

use App\Models\TempHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemperatureController extends Controller
{
    public function store(Request $request)
    {
        $temp1 = $request->input('temp1');
        $temp2 = $request->input('temp2');

        TempHistory::create(['fishpond_id' => 1, 'temperature'=> $temp1]);
        TempHistory::create(['fishpond_id' => 2, 'temperature'=> $temp2]);

        // // Dispatch event to update real-time temperature history
        // $temperatureHistory = TempHistory::with('fishpond')->latest()->get();
        // event(new TemperatureUpdated($temperatureHistory));

        return response()->json(['message' => 'Temperature data saved successfully']);
    }
}

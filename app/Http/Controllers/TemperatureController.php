<?php

namespace App\Http\Controllers;

use App\Models\TempHistory;
use Illuminate\Http\Request;
use App\Events\TemperatureUpdated;

class TemperatureController extends Controller
{
    public function store(Request $request)
    {
        $temp1 = $request->input('temp1');
        $temp2 = $request->input('temp2');

        TempHistory::create(['fishpond_id' => 1,'temperature'=> $temp1]);
        TempHistory::create(['fishpond_id' => 2,'temperature'=> $temp2]);

        // Broadcast the temperature update
        event(new TemperatureUpdated($temp1, $temp2));

        return response()->json(['message' => 'Temperature data saved successfully']);
    }
}

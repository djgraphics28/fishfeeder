<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    public function store(Request $request)
    {
        $temperature = $request->input('temperature');

        // Save the temperature data to the database or perform any other necessary actions

        return response()->json(['message' => 'Temperature data saved successfully']);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Fishpond;
use App\Models\TempHistory;
use Illuminate\Http\Request;
use App\Mail\HighTemperatureAlert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TemperatureController extends Controller
{
    public function store(Request $request)
    {
        $temp1 = $request->input('temp1');
        $temp2 = $request->input('temp2');

        // Fetch fishpond data
        $fishpond1 = Fishpond::find(1);
        $fishpond2 = Fishpond::find(2);

        // Store temperature history
        TempHistory::create(['fishpond_id' => 1, 'temperature' => $temp1]);
        TempHistory::create(['fishpond_id' => 2, 'temperature' => $temp2]);

        // Check high temperature for fishpond 1
        if ($fishpond1 && $temp1 >= $fishpond1->high_temp) {
            $this->sendTemperatureAlert($fishpond1, $temp1);
        }

        // Check high temperature for fishpond 2
        if ($fishpond2 && $temp2 >= $fishpond2->high_temp) {
            $this->sendTemperatureAlert($fishpond2, $temp2);
        }

        return response()->json(['message' => 'Temperature data saved successfully']);
    }

    /**
     * Send high temperature alert email.
     */
    protected function sendTemperatureAlert($fishpond, $temperature)
    {
        $adminEmail = User::find(1)->email; // Set this in config/mail.php
        Mail::to($adminEmail)->send(new HighTemperatureAlert($fishpond, $temperature));
    }
}

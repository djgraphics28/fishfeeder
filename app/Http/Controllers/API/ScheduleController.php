<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Check if the current time matches a schedule for the provided fishpond ID.
     */
    public function checkSchedule(Request $request)
    {
        // Validate incoming request parameters
        $request->validate([
            'deviceCode' => 'required|string',
            'fishpond_id' => 'required|integer',
        ]);

        $deviceCode = $request->input('deviceCode');
        $fishpondId = $request->input('fishpond_id');

        $device = Device::where( 'code',$deviceCode)->first();
        if (!$device) {
            return response()->json([
                'status' => false,
                'message' => 'Device not found.',
            ], 404);
        }

        // Get the current time
        $currentTime = now()->format('H:i:s'); // Ensure it matches the format in the database

        // Check for a schedule that matches the current time and fishpond ID
        $schedule = Schedule::where('time', $currentTime)
            ->where('fishpond_id', $fishpondId)
            ->first();

        if ($schedule) {
            return response()->json([
                'status' => true,
                'message' => 'Schedule matched',
                'schedule' => $schedule,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No matching schedule found',
        ], 200);
    }
}

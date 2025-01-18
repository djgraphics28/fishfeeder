<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use App\Models\Fishpond;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedController extends Controller
{
   /**
     * Check if the fishpond is currently feeding.
     */
    public function checkFeedingStatus(Request $request)
    {
        // Validate incoming request parameters
        $request->validate([
            'deviceCode' => 'required|string',
            'fishpond_id' => 'required|integer',
        ]);

        $deviceCode = $request->input('deviceCode');
        $fishpondId = $request->input('fishpond_id');

        $device = Device::find( $deviceCode);
        if (!$device) {
            return response()->json([
                'status' => false,
                'message' => 'Device not found.',
            ], 404);
        }
        // Find the fishpond by ID
        $fishpond = Fishpond::find($fishpondId);

        // Check if the fishpond exists and is currently feeding
        if ($fishpond && $fishpond->is_feeding == 1) {
            return response()->json([
                'status' => true,
                'message' => 'Fishpond is feeding.',
                'fishpond' => $fishpond,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => $fishpond ? 'Fishpond is not feeding.' : 'Fishpond not found.',
        ], 404);
    }
}

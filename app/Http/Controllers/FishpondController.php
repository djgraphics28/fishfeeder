<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Fishpond;
use Illuminate\Http\Request;

class FishpondController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fishponds = Fishpond::all(); // Fetch all fishponds
        return Inertia::render('Fishponds', [
            'fishponds' => $fishponds,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Fishpond::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('fishponds.index');
    }

    // public function edit(Fishpond $fishpond)
    // {
    //     return Inertia::render('Fishponds', [
    //         'fishpond' => $fishpond,
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fishpond $fishpond)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $fishpond->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('fishponds.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fishpond = Fishpond::find($id);
        $fishpond->delete();
        return redirect()->route('fishponds.index');
    }
}

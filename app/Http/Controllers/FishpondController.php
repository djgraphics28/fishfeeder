<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Fishpond;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class FishpondController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fishponds = Fishpond::all();
        return view('fishponds.index', compact('fishponds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devices = Device::all();
        return view('fishponds.create', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'fishpondImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'high_temp' => 'required|numeric',
        ]);

        $fishpond = Fishpond::create([
            'name' => $request->name,
            'description' => $request->description,
            'device_id' => $request->device,
            'high_temp' => $request->high_temp,
        ]);

        if ($request->hasFile('fishpondImage')) {
            $fishpond->addMediaFromRequest('fishpondImage')
                ->toMediaCollection('fishpond-image');
        }

        if ($fishpond instanceof Model) {
            toastr()->success('Fishpond has been created successfully!');
            return redirect()->route('fishponds.index');
        }

        toastr()->error('An error has occurred please try again later.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fishpond = Fishpond::findOrFail($id);
        return view('fishponds.show', compact('fishpond'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $devices = Device::all();
        $fishpond = Fishpond::findOrFail($id);
        return view('fishponds.edit', compact('fishpond', 'devices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:50|unique:fishponds,name,' . $id,
            'fishpondImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'high_temp' => 'required|numeric',
        ]);

        $fishpond = Fishpond::findOrFail($id);
        $fishpond->update([
            'name' => $request->name,
            'description' => $request->description,
            'device_id' => $request->device,
            'high_temp' => $request->high_temp,
        ]);

        // Clear the media collection and handle the image upload if a new image is provided
        if ($request->hasFile('fishpondImage')) {
            $fishpond->clearMediaCollection('fishpond-image'); // Clear the existing media
            $fishpond->addMediaFromRequest('fishpondImage')
                ->toMediaCollection('fishpond-image'); // Add the new image
        }

        toastr()->success('Fishpond has been updated successfully!');
        return redirect()->route('fishponds.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fishpond = Fishpond::findOrFail($id);
        $fishpond->delete();
        toastr()->success('Fishpond deleted successfully!');
        return redirect()->route('fishponds.index');
    }
}

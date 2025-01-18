<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::all();
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:devices',
            'deviceImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $device = Device::create([
            'code' => $request->code
        ]);

        if ($request->hasFile('deviceImage')) {
            $device->addMediaFromRequest('deviceImage')
                ->toMediaCollection('device-image');
        }

        if ($device instanceof Model) {
            toastr()->success('Device has been created successfully!');
            return redirect()->route('devices.index');
        }

        toastr()->error('An error has occurred please try again later.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $device = Device::findOrFail($id);
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $device = Device::findOrFail($id);
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:devices,code,' . $id,
            'deviceImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $device = Device::findOrFail($id);
        $device->update([
            'code' => $request->code
        ]);

        // Clear the media collection and handle the image upload if a new image is provided
        if ($request->hasFile('deviceImage')) {
            $device->clearMediaCollection('device-image'); // Clear the existing media
            $device->addMediaFromRequest('deviceImage')
                ->toMediaCollection('device-image'); // Add the new image
        }

        toastr()->success('Device has been updated successfully!');
        return redirect()->route('devices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = Device::findOrFail($id);
        $device->delete();
        toastr()->success('Device deleted successfully!');
        return redirect()->route('devices.index');
    }
}

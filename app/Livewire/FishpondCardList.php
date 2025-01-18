<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fishpond;
use App\Models\Schedule;

class FishpondCardList extends Component
{
    public $fishponds;
    public $selectedFishpondId = null;
    public $selectedFishpondName = '';
    public $schedule_id;
    public $schedule_time;
    public $schedule_description;
    public $schedules = [];

    protected $rules = [
        'schedule_time' => 'required',
        'schedule_description' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->fishponds = Fishpond::with('latestTemperature')->get();
    }

    public function updatedSelectedFishpondId()
    {
        if ($this->selectedFishpondId) {
            $fishpond = Fishpond::find($this->selectedFishpondId);
            if ($fishpond) {
                $this->selectedFishpondName = $fishpond->name;
                $this->schedules = Schedule::where('fishpond_id', $this->selectedFishpondId)->get();
            }
        }
    }

    public function saveSchedule()
    {
        $this->validate();

        if ($this->schedule_id) {
            Schedule::where('id', $this->schedule_id)->update([
                'fishpond_id' => $this->selectedFishpondId,
                'time' => $this->schedule_time,
                'description' => $this->schedule_description,
            ]);
        } else {
            Schedule::create([
                'fishpond_id' => $this->selectedFishpondId,
                'time' => $this->schedule_time,
                'description' => $this->schedule_description,
            ]);
        }

        $this->schedule_id = '';
        $this->schedule_time = '';
        $this->schedule_description = '';
        $this->updatedSelectedFishpondId();
        // $this->dispatch('close-modal');
    }

    public function editSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $this->schedule_id = $id;
        $this->schedule_time = $schedule->time;
        $this->schedule_description = $schedule->description;
    }

    public function deleteSchedule($id)
    {
        Schedule::findOrFail($id)->delete();
        $this->updatedSelectedFishpondId();
    }

    public function openScheduleModal($id)
    {
        $this->selectedFishpondId = $id;
        $this->updatedSelectedFishpondId();
        $this->dispatch('open-modal');
    }

    public function feed($id)
    {
        $checkIfIsFeeding = Fishpond::find($id)->is_feeding;

        if (!$checkIfIsFeeding) {
            Fishpond::where('id', $id)->update([
                'is_feeding' => true
            ]);
            toastr()->success('Started feeding!');
            $this->fishponds = Fishpond::with('latestTemperature')->get(); // Refresh fishponds data
            $this->dispatch('fishpond-updated'); // Dispatch event for frontend reactivity
        } else {
            Fishpond::where('id', $id)->update([
                'is_feeding' => false
            ]);
            toastr()->success('Stopped feeding!');
            $this->fishponds = Fishpond::with('latestTemperature')->get(); // Refresh fishponds data
            $this->dispatch('fishpond-updated'); // Dispatch event for frontend reactivity
        }
    }
    public function render()
    {
        return view('livewire.fishpond-card-list');
    }
}

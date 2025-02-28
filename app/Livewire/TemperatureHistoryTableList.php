<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fishpond;
use App\Models\TempHistory;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class TemperatureHistoryTableList extends Component
{
    use WithPagination;

    #[Url]
    public $selectedPond = 'all';
    #[Url]
    public $startDate;
    #[Url]
    public $endDate;
    public $fishponds = [];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->fishponds = Fishpond::all();
        $this->startDate = now()->toDateString();
        $this->endDate = now()->toDateString();
    }

    public function refreshData()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $query = TempHistory::query();

        if ($this->selectedPond !== 'all') {
            $query->where('fishpond_id', $this->selectedPond);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        } else {
            $query->whereDate('created_at', now()->toDateString());
        }

        $temperatures = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.temperature-history-table-list', [
            'temperatures' => $temperatures,
        ]);
    }
}

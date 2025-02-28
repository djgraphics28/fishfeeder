<div>
    <div class="row" wire:poll.5s>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Temperature History</h3>
                <div class="card-tools">
                    <div class="row">
                        <div class="col-md-4">
                            <small>Filter by Ponds</small>
                            <select class="form-control" wire:model.live="selectedPond">
                                <option value="all">All Ponds</option>
                                @foreach ($fishponds as $pond)
                                    <option value="{{ $pond->id }}">{{ ucfirst($pond->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <small>Start</small>
                            <input type="date" class="form-control" wire:model.live="startDate"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <small>End</small>
                            <input type="date" class="form-control" wire:model.live="endDate"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Toggle Buttons for Table and Chart -->
                <div class="mb-3">
                    <button class="btn btn-primary" onclick="toggleView('table')">Table View</button>
                    <button class="btn btn-primary" onclick="toggleView('chart')">Chart View</button>
                </div>

                <!-- Table View -->
                <div id="tableView">
                    <table class="table table-bordered table-striped position-relative">
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>Pond</th>
                                <th>Temperature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($temperatures as $temperature)
                                <tr class="{{ $temperature->temperature > 36 ? 'table-danger' : '' }}">
                                    <td>{{ $temperature->created_at->format('F j, Y g:i A') }}</td>
                                    <td>{{ ucfirst($temperature->fishpond->name) }}</td>
                                    <td>{{ $temperature->temperature }}°C</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No temperature records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $temperatures->links() }}
                    </div>
                </div>

                <!-- Chart View (Hidden by Default) -->
                <div id="chartView" style="display: none;">
                    <canvas id="temperatureChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Toggle between table and chart views
        function toggleView(view) {
            if (view === 'table') {
                document.getElementById('tableView').style.display = 'block';
                document.getElementById('chartView').style.display = 'none';
            } else {
                document.getElementById('tableView').style.display = 'none';
                document.getElementById('chartView').style.display = 'block';
                renderChart(); // Render chart when toggling to chart view
            }
        }

        // Render the bar chart using Chart.js
        function renderChart() {
            const labels = @json(
                $temperatures->pluck('created_at')->map(function ($date) {
                    return $date->format('F j, Y g:i A');
                }));

            // Separate data for Fishpond 1 and Fishpond 2
            const pond1Data = @json($temperatures->where('fishpond_id', 1)->pluck('temperature'));
            const pond2Data = @json($temperatures->where('fishpond_id', 2)->pluck('temperature'));

            // Debugging step: log the data to the console to see if the temperature values are correct
            console.log('Pond 1 Data:', pond1Data);
            console.log('Pond 2 Data:', pond2Data);

            // If there's no data for Fishpond 1 or Fishpond 2, log a warning
            if (pond1Data.length === 0) {
                console.warn('No data available for Fishpond 1');
            }
            if (pond2Data.length === 0) {
                console.warn('No data available for Fishpond 2');
            }

            const ctx = document.getElementById('temperatureChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Change type to 'bar' for bar chart
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Fishpond 1',
                            data: pond1Data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Fishpond 2',
                            data: pond2Data,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw + '°C';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Temperature (°C)'
                            }
                        }
                    }
                }
            });
        }
    </script>

    <script>
        setInterval(() => {
            Livewire.emit('refreshData');
        }, 5000); // Refresh every 5 seconds
    </script>
@endpush

<div>
    <div class="row {{ count($fishponds) < 3 ? 'justify-content-center' : '' }}">
        @forelse($fishponds as $fishpond)
            <div class="col-md-6" wire:poll.5s>
                <div
                    class="card bg-{{ $fishpond->latestTemperature?->temperature >= 0 && $fishpond->latestTemperature?->temperature <= 36 ? 'success' : 'danger' }}">
                    <div class="card-header">
                        <h3 class="card-title text-white">{{ $fishpond->name }}</h3>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('fishponds.edit', $fishpond->id) }}" class="btn btn-outline-default btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body text-white">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Image on the left -->
                                <img src="{{ $fishpond->getFirstMediaUrl('fishpond-image') ?? '' }}"
                                    alt="Fishpond Image" class="img-thumbnail mr-3"
                                    style="max-width: 150px; max-height: 100px; height: auto; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <h4>Temperature: {{ $fishpond->latestTemperature?->temperature ?? '0' }}°C
                                    <i class="fas fa-thermometer-half float-right"></i>
                                </h4>
                                <p>{!! nl2br(string: strip_tags($fishpond->description)) !!}</p>
                                <p>Updated On:
                                    {{ $fishpond->latestTemperature?->created_at?->diffForHumans() ?? 'Never' }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button wire:click="openScheduleModal({{ $fishpond->id }})"
                                class="btn btn-warning">Schedule</button>
                            <button wire:click="feed({{ $fishpond->id }})"
                                class="btn btn-{{ $fishpond->is_feeding ? 'danger' : 'info' }}"
                                wire:loading.attr="disabled" wire:target="feed({{ $fishpond->id }})">
                                <span wire:loading.remove
                                    wire:target="feed({{ $fishpond->id }})">{{ $fishpond->is_feeding ? 'Stop Feeding' : 'Feed Now' }}</span>
                                <span wire:loading wire:target="feed({{ $fishpond->id }})">
                                    <i class="fas fa-spinner fa-spin"></i> Processing...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <h3 class="mt-2 text-sm font-medium text-gray-900">No fishponds found</h3>
            </div>
        @endforelse
    </div>

    <!-- Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Schedules - {{ $selectedFishpondName }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveSchedule">
                        <div class="form-group">
                            <label>Schedule Time</label>
                            <input type="time" class="form-control" wire:model.defer="schedule_time">
                            @error('schedule_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" wire:model.defer="schedule_description"></textarea>
                            @error('schedule_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-{{ $schedule_id ? 'warning' : 'primary' }}">{{ $schedule_id ? 'Update' : 'Save' }}
                            Schedule</button>
                    </form>

                    <hr>

                    <h6>Existing Schedules</h6>
                    <div class="schedules-list">
                        @forelse($schedules as $schedule)
                            <div class="schedule-item d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ date('h:i A', strtotime($schedule->time)) }}</strong>
                                    <p class="mb-0">{{ $schedule->description }}</p>
                                </div>
                                <div>
                                    <button wire:click="editSchedule({{ $schedule->id }})"
                                        class="btn btn-sm btn-info">Edit</button>
                                    <button wire:click="deleteSchedule({{ $schedule->id }})"
                                        class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No schedules found</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('open-modal', () => {
            $('#scheduleModal').modal('show');
        });

        window.addEventListener('close-modal', () => {
            $('#scheduleModal').modal('hide');
        });
    </script>

    <script>
        setInterval(() => {
            Livewire.emit('refreshData');
        }, 5000); // Refresh every 5 seconds
    </script>
@endpush

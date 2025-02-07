<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;

class Fishpond extends Model implements HasMedia
{
    use InteractsWithMedia;
    use LogsActivity;
    protected $guarded = [];

    protected $fillable = ['name', 'description', 'is_feeding', 'device_id', 'high_temp'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function latestTemperature()
    {
        return $this->hasOne(TempHistory::class)->latest();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Log only changes to the 'name' and 'is_feeding' attributes
            ->logOnly(['name', 'is_feeding'])
            // Prevent logging if only 'description' changes
            ->dontLogIfAttributesChangedOnly(['description']);
    }
}

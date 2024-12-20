<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fishpond extends Model
{
    protected $fillable = [
        'name',
        'location', 
        'device_id',
        'is_active'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function temp_histories() 
    {
        return $this->hasMany(TempHistory::class);
    }

    public function latest_temp_history()
    {
        return $this->hasOne(TempHistory::class)->latest();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];

    public function fishpond()
    {
        return $this->hasOne(Fishpond::class, 'device_id', 'id');
    }
}

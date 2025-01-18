<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function fishpond()
    {
        return $this->belongsTo(Fishpond::class);
    }
}

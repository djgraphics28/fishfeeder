<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempHistory extends Model
{
    protected $guarded = [];

    public function fishpond()
    {
        return $this->belongsTo(Fishpond::class);
    }
}

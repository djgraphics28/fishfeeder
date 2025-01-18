<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Device extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

    public function fishponds()
    {
        return $this->hasMany(Fishpond::class);
    }
}

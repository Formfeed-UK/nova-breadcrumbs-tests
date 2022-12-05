<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelTwoC extends Model
{
    use HasFactory;

    public function levelOne()
    {
        return $this->belongsTo(LevelOne::class);
    }

    public function levelThreeB()
    {
        return $this->hasMany(LevelThreeB::class);
    }
}

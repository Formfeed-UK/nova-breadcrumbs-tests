<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelThreeB extends Model
{
    use HasFactory;

    public function levelTwoC()
    {
        return $this->belongsTo(LevelTwoC::class);
    }

    public function levelOne()
    {
        return $this->belongsToThrough(LevelOne::class, LevelTwoC::class);
    }
}

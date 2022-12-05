<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelThreeA extends Model
{
    use HasFactory;

    public function levelTwoA()
    {
        return $this->belongsTo(LevelTwoA::class);
    }

    public function levelOne()
    {
        return $this->belongsToThrough(LevelOne::class, LevelTwoA::class);
    }
}

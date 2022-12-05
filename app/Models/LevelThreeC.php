<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelThreeC extends Model
{
    use HasFactory;

    public function levelTwoD()
    {
        return $this->belongsTo(LevelTwoD::class);
    }

    public function levelOne()
    {
        return $this->belongsToThrough(LevelOne::class, LevelTwoD::class);
    }
}

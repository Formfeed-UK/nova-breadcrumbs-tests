<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelTwoA extends Model
{
    use HasFactory;

    public function levelOne()
    {
        return $this->belongsTo(LevelOne::class);
    }

    public function levelThreeA()
    {
        return $this->hasMany(LevelThreeA::class);
    }
}

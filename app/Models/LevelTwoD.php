<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelTwoD extends Model
{
    use HasFactory;

    public function levelOne()
    {
        return $this->belongsTo(LevelOne::class);
    }

    public function levelThreeC()
    {
        return $this->hasMany(LevelThreeC::class);
    }
}

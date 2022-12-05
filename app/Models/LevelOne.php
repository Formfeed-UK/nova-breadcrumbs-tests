<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelOne extends Model
{
    use HasFactory;

    public function levelTwoA()
    {
        return $this->hasMany(LevelTwoA::class);
    }

    public function levelTwoBs()
    {
        return $this->belongsToMany(LevelTwoB::class, 'level_two_b_s_level_ones', 'level_ones_id', 'level_two_b_s_id', 'id', 'id');
    }

    public function levelTwoC()
    {
        return $this->hasMany(LevelTwoC::class);
    }

    public function levelTwoD()
    {
        return $this->hasMany(LevelTwoD::class);
    }


}

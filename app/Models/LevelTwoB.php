<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelTwoB extends Model
{
    use HasFactory;

    public function levelOnes()
    {
        return $this->belongsToMany(LevelOne::class, 'level_two_b_s_level_ones', 'level_two_b_s_id', 'level_ones_id', 'id', 'id');
    }
}

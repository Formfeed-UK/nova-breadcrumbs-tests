<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelThreeD3 extends Model
{
    use HasFactory;

    public $table = 'level_three_d_s';

    public function parent2() {
        return $this->levelTwoB();
    }

    public function levelTwoA()
    {
        return $this->belongsTo(LevelTwoA::class);
    }

    public function levelTwoB()
    {
        return $this->belongsTo(LevelTwoB::class);
    }

}

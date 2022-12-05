<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelThreeD extends Model
{
    use HasFactory;

    public function levelTwoA()
    {
        return $this->belongsTo(LevelTwoA::class);
    }

    public function levelTwoB()
    {
        return $this->belongsTo(LevelTwoB::class);
    }

}

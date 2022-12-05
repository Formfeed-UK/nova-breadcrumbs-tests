<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelTwoA2 extends Model
{
    use HasFactory;

    public $table = 'level_two_a_s';

    public function levelOne() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LevelOne::class);
    }
}

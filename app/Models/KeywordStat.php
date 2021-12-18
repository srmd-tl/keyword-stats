<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordStat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDifficultyAttribute($value)
    {
        if ($value <= 10) {
            $value = "Very Easy";
        } else if ($value > 10 && $value <= 20) {
            $value = "Easy";
        } else if ($value > 20 && $value <= 50) {
            $value = "Medium";
        } else if ($value > 50 && $value <= 100) {
            $value = "Hard";
        } else if ($value > 100) {
            $value = "Very Hard";
        }
        return $value;
    }
}

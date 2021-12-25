<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KeywordStat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDifficultyAttribute($value)
    {
        if ($value == 0) {
            $value = "Very Easy";
        } else if ($value == 1) {
            $value = "Easy";
        } else if ($value ==2) {
            $value = "Medium";
        } else if ($value ==3) {
            $value = "Hard";
        } else if ($value ==4) {
            $value = "Very Hard";
        }
        return $value;
    }

    public function scopeProjects($query){
        return $query->where('user_id', auth()->user()->id);

    }
    protected static function boot()
    {
        parent::boot();
        // Customize your own rule here!
        if (request()->project) {
            static::addGlobalScope('project', function (Builder $builder) {
                $builder->where('project_id', request()->project);
            });
        }
    }
}

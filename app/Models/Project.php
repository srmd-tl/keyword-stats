<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class Project extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function scopeProjects($query){
        return $query->where('user_id', auth()->user()->id);
    }
    protected static function boot()
    {
        parent::boot();

        // Customize your own rule here!
        if (!Auth::user()->hasRole('admin')) {
            static::addGlobalScope('user', function (Builder $builder) {
                $builder->where('user_id', '=', Auth::user()->id);
            });
        }
    }
}

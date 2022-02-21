<?php

namespace App\Models;

use App\Models\User;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_name',
        'workout_type',
        'user_id',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}

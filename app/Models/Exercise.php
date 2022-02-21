<?php

namespace App\Models;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercise extends Model
{
    protected $fillable = [
        'input-1',
        'input-2',
        'input-3',
        'input-4',
        'workout_id'
    ];
    public function workout() {
        return $this->belongsTo(Workout::class);
    }
    use HasFactory;
}

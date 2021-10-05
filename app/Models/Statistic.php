<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'movements',
        'bad_movements',
        'start_at',
        'end_at',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

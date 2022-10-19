<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestTime extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Constant variables for days
     *
     * @var array<int, string>
     */
    const DAYS = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'day_id',
        'start_time',
        'end_time',
        'description',
    ];

    /**
     * Get the students that belongs to the rest time.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        return $this->belongsToMany(Student::class, 'student_rest_time')->withTimestamps();
    }
}

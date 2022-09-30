<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEmailVerify extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'email',
        'token',
        'created_at',
    ];

    protected $dates = [
        'created_at'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}

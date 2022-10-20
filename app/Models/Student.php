<?php

namespace App\Models;

use App\Notifications\StudentResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'username',
        'email',
        'allow_email_notify',
        'password',
        'phone',
        'address',
        'is_a_sandbox_student',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the carts for the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the orders for the student.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the rest times that belong to the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function restTimes()
    {
        return $this->belongsToMany(RestTime::class, 'student_rest_time')->withTimestamps();
    }

    /**
     * Get the email verify model for the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emailVerify(){
        return $this->hasOne(StudentEmailVerify::class);
    }

    /**
     * Get admin identity for the student.
     *
     * @return false
     */
    public function isAdmin(){
        return false;
    }

    /**
     * Get food seller identity for the student.
     *
     * @return false
     */
    public function isFoodSeller(){
        return false;
    }

    /**
     * Get student identity for the student.
     *
     * @return bool
     */
    public function isStudent(){
        return true;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StudentResetPasswordNotification($token));
    }
}

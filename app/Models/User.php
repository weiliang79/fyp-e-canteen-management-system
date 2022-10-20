<?php

namespace App\Models;

use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'role_id',
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
     * Get the role that own the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the store for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store(){
        return $this->hasOne(Store::class);
    }

    /**
     * Get the email verify model for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emailVerify(){
        return $this->hasOne(UserEmailVerify::class);
    }

    /**
     * Get the admin identity for the user.
     *
     * @return bool
     */
    public function isAdmin(){
        return $this->role->id == Role::ROLE_ADMIN;
    }

    /**
     * Get the food seller identity for the user.
     *
     * @return bool
     */
    public function isFoodSeller(){
        return $this->role->id == Role::ROLE_SELLER;
    }

    /**
     * Get the student identity for the user.
     *
     * @return false
     */
    public function isStudent(){
        return false;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }
}

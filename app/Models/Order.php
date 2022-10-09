<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const PAYMENT_PENDING = 1, PAYMENT_FAILURE = 2, PAYMENT_SUCCESS = 3, PICKUP_PARTIALLY = 4, PICKUP_ALL = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'pick_up_start',
        'pick_up_end',
        'total_price',
        'status',
        'is_sandbox_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pick_up_start' => 'datetime',
        'pick_up_end' => 'datetime',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function getStatusString(){
        return match ($this->status) {
            Order::PAYMENT_PENDING => 'Payment Pending',
            Order::PAYMENT_FAILURE => 'Payment Failure',
            Order::PAYMENT_SUCCESS => 'Payment Success',
            Order::PICKUP_PARTIALLY => 'Partially Picked Up',
            Order::PICKUP_ALL => 'All Picked Up',
            default => 'Undefined',
        };
    }

    public function getStatusBg(){
        return match ($this->status) {
            Order::PAYMENT_PENDING, Order::PICKUP_PARTIALLY => 'bg-warning',
            Order::PAYMENT_FAILURE => 'bg-error',
            Order::PAYMENT_SUCCESS, Order::PICKUP_ALL => 'bg-success',
            default => '',
        };
    }
}

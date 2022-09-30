<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDetailStripe extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 1, STATUS_SUCCESS = 2, STATUS_ABORT = 3;

    protected $table = 'payment_details_stripe';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_intent_id',
        'client_secret',
        'payment_method_id',
        'status',
    ];

    public function payment(){
        return $this->hasOne(Payment::class, 'payment_detail_stripe_id');
    }
}

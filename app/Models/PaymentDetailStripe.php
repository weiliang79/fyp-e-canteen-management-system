<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDetailStripe extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Constant variables for Stripe payment detail status.
     *
     * @var int
     */
    const STATUS_PENDING = 1, STATUS_SUCCESS = 2, STATUS_ABORT = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
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

    /**
     * Get the payment associated with the Stripe payment detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'payment_detail_stripe_id');
    }
}

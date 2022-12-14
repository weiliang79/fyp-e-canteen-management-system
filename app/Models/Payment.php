<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Constant variables for payment status.
     *
     * @var int
     */
    const STATUS_PENDING = 1, STATUS_FAILURE = 2, STATUS_ABORT = 3, STATUS_SUCCESS = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'payment_type_id',
        'payment_detail_2c2p_id',
        'payment_detail_stripe_id',
        'amount',
        'status',
        'is_sandbox_payment',
    ];

    /**
     * Get the order that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the payment type that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    /**
     * Get the 2C2P payment detail that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentDetail2c2p()
    {
        return $this->belongsTo(PaymentDetail2c2p::class, 'payment_detail_2c2p_id');
    }

    /**
     * Get the Stripe payment detail that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentDetailStripe()
    {
        return $this->belongsTo(PaymentDetailStripe::class, 'payment_detail_stripe_id');
    }

    /**
     * Get the payment status in string.
     *
     * @return string
     */
    public function getStatusString()
    {
        return match ($this->status) {
            Payment::STATUS_PENDING => 'Payment Pending',
            Payment::STATUS_FAILURE => 'Payment Failure',
            Payment::STATUS_ABORT => 'Payment Abort',
            Payment::STATUS_SUCCESS => 'Payment Success',
            default => 'Undefined',
        };
    }

    /**
     * Get the payment status background color based on Bootstrap 5.
     *
     * @return string
     */
    public function getStatusBg()
    {
        return match ($this->status) {
            Payment::STATUS_PENDING => 'bg-warning',
            Payment::STATUS_FAILURE, Payment::STATUS_ABORT => 'bg-danger',
            Payment::STATUS_SUCCESS => 'bg-success',
            default => '',
        };
    }

    /**
     * Get the payment type in string.
     *
     * @return string
     */
    public function getPaymentTypeString()
    {
        return match ($this->payment_type_id) {
            PaymentType::PAYMENT_2C2P => '2C2P',
            PaymentType::PAYMENT_STRIPE => 'Stripe',
            PaymentType::PAYMENT_CASH => 'Cash',
            default => 'Undefined',
        };
    }

}

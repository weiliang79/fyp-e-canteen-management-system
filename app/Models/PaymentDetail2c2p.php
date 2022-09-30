<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDetail2c2p extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 1, STATUS_SUCCESS = 2, STATUS_FAILURE = 3;

    protected $table = 'payment_details_2c2p';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_no',
        'amount',
        'currency_code',
        'transaction_time',
        'agent_code',
        'channel_code',
        'approval_code',
        'reference_no',
        'tran_ref',
        'resp_code',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_time' => 'datetime',
    ];

    public function payment(){
        return $this->hasOne(Payment::class, 'payment_detail_2c2p_id');
    }
}

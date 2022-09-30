<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details_2c2p', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->decimal('amount');
            $table->string('currency_code');
            $table->timestamp('transaction_time')->nullable();
            $table->string('agent_code')->nullable();
            $table->string('channel_code')->nullable();
            $table->string('approval_code')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('tran_ref')->nullable();
            $table->string('resp_code')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_details_2c2p');
    }
};

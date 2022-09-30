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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('payment_type_id');
            $table->foreignId('payment_detail_2c2p_id')->nullable();
            $table->foreignId('payment_detail_stripe_id')->nullable();
            $table->decimal('amount');
            $table->tinyInteger('status');
            $table->boolean('is_sandbox_payment')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
            $table->foreign('payment_detail_2c2p_id')->references('id')->on('payment_details_2c2p')->onDelete('cascade');
            $table->foreign('payment_detail_stripe_id')->references('id')->on('payment_details_stripe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};

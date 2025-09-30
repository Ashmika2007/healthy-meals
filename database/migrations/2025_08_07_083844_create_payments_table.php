<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id')->nullable();
        $table->unsignedBigInteger('subscription_id')->nullable();
        $table->decimal('amount', 8, 2);
        $table->string('payment_method');
        $table->timestamp('payment_date')->useCurrent();
        $table->timestamps();

        $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

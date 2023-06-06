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
        Schema::create('order_temps', function (Blueprint $table) {
            $table->id();
            $table->string('orders_number');
            $table->string('ip_address');
            $table->text('details')->nullable();
            $table->dateTime('transaction_date')->nullable()->comment('วันที่ทำรายการ');
            $table->dateTime('shipping_date')->nullable()->comment('วันที่รับบริการ');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_temps');
    }
};

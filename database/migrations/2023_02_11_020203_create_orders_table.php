<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orders_number');
            $table->integer('status_id')->default(1);
            $table->text('delivery_drop')->nullable();
            $table->text('delivery_drop_address')->nullable();
            $table->text('delivery_drop_address_more')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('second_phone_number')->nullable();
            $table->dateTime('transaction_date')->nullable()->comment('วันที่ทำรายการ');
            $table->dateTime('shipping_date')->nullable()->comment('วันที่รับบริการ');
            $table->integer('total_price')->default(0);
            $table->integer('delivery_price')->default(0);
            $table->string('distance')->default(0)->comment('Km.');
            $table->dateTime('date_drop')->nullable();
            $table->dateTime('date_pickup')->nullable();
            $table->string('drop_image')->nullable();
            $table->string('language')->default('th');

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
        Schema::dropIfExists('orders');
    }
};

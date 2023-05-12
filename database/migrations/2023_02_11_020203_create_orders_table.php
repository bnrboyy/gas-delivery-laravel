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
            $table->integer('member_id')->default(0);
            $table->integer('branch_id')->nullable();
            $table->integer('status_id')->default(1);
            $table->text('delivery_pickup')->nullable();
            $table->text('delivery_pickup_address')->nullable();
            $table->text('delivery_pickup_address_more')->nullable();
            $table->text('delivery_drop')->nullable();
            $table->text('delivery_drop_address')->nullable();
            $table->text('delivery_drop_address_more')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('details')->nullable();
            $table->dateTime('transaction_date')->nullable()->comment('วันที่ทำรายการ');
            $table->dateTime('shipping_date')->nullable()->comment('วันที่รับบริการ');
            $table->dateTime('date_pickup')->nullable();
            $table->dateTime('date_drop')->nullable();
            $table->string('type_order')->nullable();
            $table->string('pickup_image')->nullable();
            $table->string('drop_image')->nullable();
            $table->string('currency')->nullable();
            $table->integer('delivery_price')->default(0);
            $table->string('distance')->default(0);
            $table->integer('total_price')->default(0);
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

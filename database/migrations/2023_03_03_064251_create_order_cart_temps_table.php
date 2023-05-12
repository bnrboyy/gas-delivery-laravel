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
        Schema::create('order_cart_temps', function (Blueprint $table) {
            $table->id();
            $table->string('orders_number');
            $table->integer('cart_number')->default(0);
            $table->integer('product_id');
            $table->string('product_title');
            $table->integer('product_cate_id');
            $table->integer('minutes_add')->default(0);
            $table->integer('page_id')->default(0);
            $table->integer('microwave_id')->default(0);
            $table->integer('sweetness_id')->default(0);
            $table->string('requirements')->nullable();
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('order_cart_temps');
    }
};

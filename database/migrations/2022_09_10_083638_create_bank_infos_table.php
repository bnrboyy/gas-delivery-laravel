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
        Schema::create('bank_infos', function (Blueprint $table) {
            $table->id();
            $table->string('bank_ref')->nullable();
            $table->string('bank_name');
            $table->string('bank_account');
            $table->string('bank_number');
            $table->string('bank_image');
            $table->timestamps();
        });

        DB::table('bank_infos')->insert([
            [
                'bank_name' => 'Siam Commercial Bank Public Company Limited',
                'bank_account' => 'Mr.Manami vendingcafe',
                'bank_number' => '123-456-7890',
                'bank_image' => 'img/order_summary/bankicon1.png'
            ],
            [
                'bank_name' => 'BANGKOK BANK PUBLIC COMPANY LIMITED',
                'bank_account' => 'Mr.Manami vendingcafe',
                'bank_number' => '123-456-7890',
                'bank_image' => 'img/order_summary/bankicon2.png'
            ],
            [
                'bank_name' => 'Bank of Ayudhya Public Company Limited',
                'bank_account' => 'Mr.Manami vendingcafe',
                'bank_number' => '123-456-7890',
                'bank_image' => 'img/order_summary/bankicon3.png'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_infos');
    }
};

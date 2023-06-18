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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('language');
            $table->integer('display')->default(true);
            $table->unique(['language', 'id']);
            $table->timestamps();
        });

        DB::table('order_statuses')->insert([
            [
                'id' => 1,
                'name' => 'รอยืนยัน',
                'language' => 'th',
                'display' => true,
            ],
            [
                'id' => 2,
                'name' => 'รอดำเนินการ',
                'language' => 'th',
                'display' => true,
            ],
            [
                'id' => 3,
                'name' => 'กำลังดำเนินการ',
                'language' => 'th',
                'display' => true,
            ],
            [
                'id' => 4,
                'name' => 'จัดส่งสำเร็จ',
                'language' => 'th',
                'display' => true,
            ],
            [
                'id' => 5,
                'name' => 'จัดส่งไม่สำเร็จ',
                'language' => 'th',
                'display' => true,
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
        Schema::dropIfExists('order_statuses');
    }
};

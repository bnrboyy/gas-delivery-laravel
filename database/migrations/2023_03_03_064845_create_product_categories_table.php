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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id('id');
            $table->string('title')->nullable();
            $table->string('details')->nullable();
            $table->string('thumbnail_title')->nullable();
            $table->string('thumbnail_link')->nullable();
            $table->string('thumbnail_alt')->nullable();
            $table->boolean('display')->default(true);

            $table->string('language');
            $table->boolean('defaults');
            $table->unique(['language', 'id']);
            $table->boolean('is_new_product')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        DB::statement('ALTER TABLE `product_categories` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `language`) USING BTREE');

        DB::table('product_categories')->insert([
            [
                'title' => 'เปลี่ยนถัง',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_alt' => '',
                'display' => true,
                'is_new_product' => false,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'ถังแก๊ส',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_alt' => '',
                'display' => true,
                'is_new_product' => true,
                'language' => 'th',
                'defaults' => true

            ],
            [
                'title' => 'อุปกรณ์อื่นๆ',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_alt' => '',
                'display' => true,
                'is_new_product' => true,
                'language' => 'th',
                'defaults' => true

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
        Schema::dropIfExists('product_categories');
    }
};

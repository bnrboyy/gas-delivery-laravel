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
            $table->boolean('display')->default(true);
            $table->boolean('is_food')->default(false);
            $table->string('thumbnail_title')->nullable();
            $table->string('thumbnail_link')->nullable();
            $table->string('thumbnail_size')->nullable();
            $table->string('thumbnail_alt')->nullable();
            $table->string('language');
            $table->boolean('defaults');
            $table->unique(['language', 'id']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        DB::statement('ALTER TABLE `product_categories` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `language`) USING BTREE');

        DB::table('product_categories')->insert([
            [
                'title' => 'Clothing type',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => false,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Washing or Drying',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => false,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Capacity(kg)',
                'details' => 'The choice will  affect the price of using the service.',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => false,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Water Temperature ',
                'details' => 'The choice will affect the price of using the service.',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => false,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Drying time',
                'details' => 'The choice will affect the price of using the service.',
                'thumbnail_title' => '',
                'thumbnail_link' => '',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => false,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Snack',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/icons/cookie.svg',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => true,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Bread',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/icons/pie.svg',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => true,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Easy Food',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/icons/50-02.svg',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => true,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Fruit',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/icons/lemon.svg',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => true,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Drink',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/icons/drink.svg',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => true,
                'language' => 'th',
                'defaults' => true
            ],
            [
                'title' => 'Milk',
                'details' => '',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/icons/milk1.svg',
                'thumbnail_size' => '',
                'display' => true,
                'is_food' => true,
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

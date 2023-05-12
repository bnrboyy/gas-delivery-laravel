<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_slides', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->default(0);
            $table->string('ad_image');
            $table->string('ad_image_alt')->nullable();
            $table->string('ad_image_title')->nullable();
            $table->string('ad_title')->nullable();
            $table->string('ad_description')->nullable();
            $table->integer('ad_type')->default(1)->comment('1: ภาพหน้าหลัก, 2: ภาพโฆษณา');
            $table->integer('ad_position_id')->default(1);
            $table->integer('ad_priority')->default(1);
            $table->string('ad_link')->nullable();
            $table->string('ad_redirect')->nullable();
            $table->string('ad_h1')->nullable();
            $table->string('ad_h2')->nullable();
            $table->boolean('ad_status_display')->default(true);
            $table->dateTime('ad_date_display')->nullable();
            $table->dateTime('ad_date_hidden')->nullable();
            $table->string('language')->nullable();
            $table->string('defaults')->default(false);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE `ad_slides` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `language`) USING BTREE');

        DB::table('ad_slides')->insert([
            [
                'page_id' => 9,
                'ad_title' => 'Wash & Dry',
                'ad_description' => '',
                'ad_image' => 'img/drying/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 10,
                'ad_title' => 'Washing',
                'ad_description' => '',
                'ad_image' => 'img/drying/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 11,
                'ad_title' => 'Drying',
                'ad_description' => '',
                'ad_image' => 'img/drying/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 12,
                'ad_title' => 'Wash and Dry list',
                'ad_description' => '',
                'ad_image' => 'img/drying/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 13,
                'ad_title' => 'Order Summary',
                'ad_description' => '',
                'ad_image' => 'img/drying/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 14,
                'ad_title' => 'Vending & Cafe’',
                'ad_description' => '',
                'ad_image' => 'img/vending&cafe/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 15,
                'ad_title' => 'Foods',
                'ad_description' => '',
                'ad_image' => 'img/vending&cafe/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 16,
                'ad_title' => 'Drinks',
                'ad_description' => '',
                'ad_image' => 'img/vending&cafe/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
                'defaults' => true
            ],
            [
                'page_id' => 17,
                'ad_title' => 'Cart',
                'ad_description' => '',
                'ad_image' => 'img/vending&cafe/headerbgimg.png',
                'ad_position_id' => 1,
                'ad_priority' => 1,
                'language' => "th",
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
        Schema::dropIfExists('ad_slides');
    }
};

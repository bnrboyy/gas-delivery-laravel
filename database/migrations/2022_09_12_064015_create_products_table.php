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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->integer('cate_id')->default(0);
            $table->text('details')->nullable();
            $table->text('more_details')->nullable();
            $table->integer('price')->default(0);
            $table->integer('page_id')->default(0);
            $table->boolean('display')->default(true);
            $table->text('short_url')->nullable();
            $table->string('thumbnail_title')->nullable();
            $table->string('thumbnail_link')->nullable();
            $table->string('thumbnail_alt')->nullable();
            $table->boolean('defaults')->default(false);
            $table->string('language');
            $table->unique(['language', 'id']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        DB::statement('ALTER TABLE `products` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `language`) USING BTREE');

        DB::table('products')->insert([
            [
                'title' => '18 KG. ฟ้า',
                'details' => 'เปลี่ยนถังแก๊สขนาด 18 KG.',
                'cate_id' => 1,
                'price' => 150,
                'language' => 'th',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/gas/gas-cylinder.png',
                'short_url' => '',
                'defaults' => true,
            ],
            [
                'title' => '18 KG. แดง',
                'details' => 'เปลี่ยนถังแก๊สขนาด 18 KG.',
                'cate_id' => 1,
                'price' => 250,
                'language' => 'th',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/gas/gas-cylinder.png',
                'short_url' => '',
                'defaults' => true,
            ],
            [
                'title' => '20 KG. ฟ้า',
                'details' => 'เปลี่ยนถังแก๊สขนาด 18 KG.',
                'cate_id' => 1,
                'price' => 250,
                'language' => 'th',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/gas/gas-cylinder.png',
                'short_url' => '',
                'defaults' => true,
            ],
            [
                'title' => '18 KG. แดง',
                'details' => 'เปลี่ยนถังแก๊สขนาด 18 KG.',
                'cate_id' => 1,
                'price' => 150,
                'language' => 'th',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/gas/gas-cylinder.png',
                'short_url' => '',
                'defaults' => true,
            ],
            [
                'title' => '18 KG.',
                'details' => 'เปลี่ยนถังแก๊สขนาด 18 KG.',
                'cate_id' => 1,
                'price' => 100,
                'language' => 'th',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/gas/gas-cylinder.png',
                'short_url' => '',
                'defaults' => true,
            ],
            [
                'title' => '25 KG.',
                'details' => 'เปลี่ยนถังแก๊สขนาด 18 KG.',
                'cate_id' => 1,
                'price' => 150,
                'language' => 'th',
                'thumbnail_title' => '',
                'thumbnail_link' => 'images/gas/gas-cylinder.png',
                'short_url' => '',
                'defaults' => true,
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
        Schema::dropIfExists('products');
    }
};

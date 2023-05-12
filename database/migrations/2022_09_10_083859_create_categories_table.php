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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('cate_name')->nullable();
            $table->string('cate_title')->nullable();
            $table->string('cate_keyword')->nullable();
            $table->string('cate_description')->nullable();
            $table->string('cate_thumbnail')->nullable();
            $table->string('cate_thumbnail_title')->nullable();
            $table->string('cate_thumbnail_alt')->nullable();
            $table->string('cate_url')->nullable();
            $table->string('cate_topic')->nullable();
            $table->string('cate_h1')->nullable();
            $table->string('cate_h2')->nullable();
            $table->string('cate_freetag')->nullable();
            $table->string('cate_attr')->nullable();
            $table->string('cate_redirect')->nullable();
            $table->integer('cate_parent_id')->default(0);
            $table->integer('cate_root_id')->default(0);
            $table->integer('cate_level')->default(0);
            $table->boolean('cate_status_display')->default(true);
            $table->boolean('is_menu')->default(false);
            $table->boolean('is_topside')->default(false);
            $table->boolean('is_leftside')->default(false);
            $table->boolean('is_rightside')->default(false);
            $table->boolean('is_bottomside')->default(false);
            $table->integer('cate_priority')->default(1);
            $table->integer('cate_position')->default(1);
            $table->boolean('on_product')->default(false); //('ถ้าเป็น false จะใช้สำหรับ content category');
            $table->boolean('is_main_page')->default(true);
            $table->dateTime('cate_date_display')->nullable();
            $table->dateTime('cate_date_hidden')->nullable();
            $table->string('language');
            $table->boolean('defaults')->default(false);
            $table->unique(['language', 'cate_url']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        DB::statement('ALTER TABLE `categories` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `language`) USING BTREE');


        #flook mockup
        DB::table('categories')->insert([
            [
                'id' => 1,
                'cate_url' => 'profile',
                'cate_title' => 'Profile',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headerusericon.png"
            ],
            [
                'id' => 2,
                'cate_url' => 'infomation',
                'cate_title' => 'Personal Infomation',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headerusericon.png"
            ],
            [
                'id' => 3,
                'cate_url' => 'editphone',
                'cate_title' => 'Edit Phone Number',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/edit_information/headericon.png"
            ],
            [
                'id' => 4,
                'cate_url' => 'order_details',
                'cate_title' => 'Order Detail',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/orderdetail/headericon.png"
            ],
            [
                'id' => 5,
                'cate_url' => 'view_slip',
                'cate_title' => 'View slip',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/slip/headericon.png"
            ],
            [
                'id' => 6,
                'cate_url' => 'photo_evidence',
                'cate_title' => 'Photo Evidence',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/evidence/headericon.png"
            ],
            [
                'id' => 9,
                'cate_url' => 'washanddry',
                'cate_title' => 'Wash & Dry',
                'is_menu' => true,
                'cate_parent_id' => 18,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 10,
                'cate_url' => 'washing',
                'cate_title' => 'Washing',
                'is_menu' => true,
                'cate_parent_id' => 18,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 11,
                'cate_url' => 'drying',
                'cate_title' => 'Drying',
                'is_menu' => true,
                'cate_parent_id' => 18,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/drying/headericon.png"
            ],
            [
                'id' => 12,
                'cate_url' => 'washing-cart',
                'cate_title' => 'Wash and Dry list',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "Order list",
                'cate_h2' => "The choice will affect the price of using the service.",
                'cate_thumbnail' => "img/wash&drylist/headericon.png"
            ],
            [
                'id' => 13,
                'cate_url' => 'washing-payment',
                'cate_title' => 'Order Summary',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/order_summary/headericon.png"
            ],
            [
                'id' => 14,
                'cate_url' => 'vending_and_cafe',
                'cate_title' => 'Vending & Cafe’',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/vending&cafe/headericon.png"
            ],
            [
                'id' => 15,
                'cate_url' => 'foods',
                'cate_title' => 'Foods',
                'is_menu' => true,
                'cate_parent_id' => 18,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/food/headericon.png"
            ],
            [
                'id' => 16,
                'cate_url' => 'drinks',
                'cate_title' => 'Drinks',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 17,
                'cate_url' => 'cart',
                'cate_title' => 'Cart',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/cart/headericon.png"
            ],
            [
                'id' => 18,
                'cate_url' => 'product',
                'cate_title' => 'Product',
                'is_menu' => false,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 19,
                'cate_url' => 'auth-login',
                'cate_title' => 'Login',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 20,
                'cate_url' => 'auth-signup',
                'cate_title' => 'Sign Up',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 21,
                'cate_url' => 'auth-forgot',
                'cate_title' => 'Forgot Password?',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/wash&dry/headericon.png"
            ],
            [
                'id' => 22,
                'cate_url' => 'termsofservice',
                'cate_title' => 'Terms of Service',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/term_of_service/headericon.png"
            ],
            [
                'id' => 23,
                'cate_url' => 'privacypolicy',
                'cate_title' => 'Privacy Policy',
                'is_menu' => true,
                'cate_parent_id' => 0,
                'language' => 'th',
                'defaults' => true,
                'cate_h1' => "",
                'cate_h2' => "",
                'cate_thumbnail' => "img/privacy_policy/headericon.png"
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
        Schema::dropIfExists('categories');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('member_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('member_name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('line_id')->nullable();
            $table->string('phone_number');
            $table->string('member_status')->nullable();
            $table->string('account_role')->nullable();
            $table->dateTime('member_verify_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->text('address')->nullable();
            $table->text('address_location')->nullable();
            $table->string('display_name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('member_note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('member_accounts')->insert([

            [
                'email' => 'member@example.com',
                'member_name' => 'member1',
                'password' => '$2y$10$04UeYnHznvv7r1rDutzLNOHWV14i.5xErpwpQ4m6IWsBD2P3s8KJC', #password = w1111111
                'line_id' => '',
                'phone_number' => '0900000000',
                'member_status' => 'confirm',
                'address' => '120/34-35 Moo 24 Sila Khonkean Kho...',
                'facebook_id' => '',
                'google_id' => '',
                'line_id' => '',
                'apple_id' => '',
                'member_note' => '',
                'member_verify_at' => '',
                'apple_id' => '',

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
        Schema::dropIfExists('member_accounts');
    }
};

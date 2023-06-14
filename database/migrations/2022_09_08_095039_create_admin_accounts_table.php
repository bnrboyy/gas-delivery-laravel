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
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->integer('admin_level')->default(4);
            $table->integer('admin_status')->default(2);
            $table->string('language')->nullable();
            $table->string('display_name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string("gender")->nullable();
            $table->dateTime("birthday")->nullable();
            $table->string('cover_image')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('line_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('admin_note')->nullable();
            $table->dateTime('admin_verify_at')->nullable();
            $table->timestamps();
        });

        #MOCKUP
        DB::table('admin_accounts')->insert([
            [
                'account_id' => 1,
                'admin_level' => 1,
                'admin_status' => 1,
                'language' => ",th,en",
                'display_name' => "Tester",
                'admin_note' => "Account devmode",
                'admin_verify_at' => "2022-9-17 08:30",
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accounts');
    }
};

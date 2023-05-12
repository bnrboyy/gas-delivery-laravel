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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->text('profile_image')->nullable();
            $table->string("gender")->nullable();
            $table->dateTime("birthday")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("address")->nullable();
            $table->string("moo")->nullable();
            $table->string("district")->nullable();
            $table->string("subdistrict")->nullable();
            $table->string("province")->nullable();
            $table->string("zipcode")->nullable();
            $table->integer('status')->default(2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('employees')->insert([
            [
                "username" => "test",
                "password" => "1234",
                "firstname" => "first",
                "lastname" => "last",
                "gender" => "men",
                "birthday" => date('Ymd'),
                "phone_number" => "0000000000",
                "address" => "124",
                "moo" => "moo",
                "district" => "district",
                "subdistrict" => "subdistrict",
                "province" => "province",
                "zipcode" => "zipcode",
                "status" => 1
            ],
            [
                "username" => "test12",
                "password" => "1234",
                "firstname" => "first",
                "lastname" => "last",
                "gender" => "men",
                "birthday" => date('Ymd'),
                "phone_number" => "0000000000",
                "address" => "124",
                "moo" => "moo",
                "district" => "district",
                "subdistrict" => "subdistrict",
                "province" => "province",
                "zipcode" => "zipcode",
                "status" => 1
            ],
            [
                "username" => "test122",
                "password" => "1234",
                "firstname" => "first",
                "lastname" => "last",
                "gender" => "men",
                "birthday" => date('Ymd'),
                "phone_number" => "0000000000",
                "address" => "124",
                "moo" => "moo",
                "district" => "district",
                "subdistrict" => "subdistrict",
                "province" => "province",
                "zipcode" => "zipcode",
                "status" => 1
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
        Schema::dropIfExists('employees');
    }
};

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
        Schema::create('product_more_details', function (Blueprint $table) {
            $table->id('id');
            $table->string('type')->comment('microwave, sweetness');
            $table->string('name')->nullable();
            $table->string('details')->nullable();
            $table->boolean('display')->default(true);
            $table->string('language');
            $table->unique(['language', 'id']);
            $table->timestamps();
        });

        DB::table('product_more_details')->insert([
            [
                'type' => 'Microwave',
                'name' => 'Warm Food',
                'details' => 'The choice will affect the price of using the service.',
                'display' => 1,
                'language' => 'th'
            ],
            [
                'type' => 'Microwave',
                'name' => 'Normal',
                'details' => '',
                'display' => 1,
                'language' => 'th'
            ],
            [
                'type' => 'Sweetness',
                'name' => 'Not sweet',
                'details' => 'The choice will affect the price of using the service.',
                'display' => 1,
                'language' => 'th'
            ],
            [
                'type' => 'Sweetness',
                'name' => 'Little sweet',
                'details' => '',
                'display' => 1,
                'language' => 'th'
            ],
            [
                'type' => 'Sweetness',
                'name' => 'Normal sweet',
                'details' => '',
                'display' => 1,
                'language' => 'th'
            ],
            [
                'type' => 'Sweetness',
                'name' => 'Very sweet',
                'details' => '',
                'display' => 1,
                'language' => 'th'
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
        Schema::dropIfExists('product_more_details');
    }
};

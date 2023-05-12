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
        Schema::create('branch_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->integer('priority')->default(0);
            $table->string('language');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('branch_infos')->insert([
            [
                'id' => 1,
                'name' => 'First branch',
                'address' => '111/1 St.xxx',
                'location' => '16.487389659798943,102.83510324187017',
                'priority' => 1,
                'language' => 'th',
            ],
            [
                'id' => 2,
                'name' => 'Second branch',
                'address' => '111/2 St.xxx',
                'location' => '16.43742124295392,102.79682070880122',
                'priority' => 2,
                'language' => 'th',
            ],
            [
                'id' => 3,
                'name' => 'Third branch',
                'address' => '111/3 St.xxx',
                'location' => '16.42527008391066,102.86110475791111',
                'priority' => 3,
                'language' => 'th',
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
        Schema::dropIfExists('branch_infos');
    }
};

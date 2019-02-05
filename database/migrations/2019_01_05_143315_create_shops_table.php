<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('link');
        });

        DB::table('shops')->insert(
        array(
            'name' => 'nipponyasan',
            'link' => 'https://www.nippon-yasan.com/',
        )
    );

    DB::table('shops')->insert(
    array(
        'name' => 'biginjapan',
        'link' => 'https://www.biginjap.com/',
    )
);

DB::table('shops')->insert(
array(
    'name' => 'amiami',
    'link' => 'https://www.amiami.com/eng/',
)
);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}

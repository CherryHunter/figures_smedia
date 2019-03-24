<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('body');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('figure_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('figure_id')->references('id')->on('figures');

            $table->integer('reported')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

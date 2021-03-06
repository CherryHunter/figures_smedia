<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualNotificaionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('actual_notifications', function (Blueprint $table) {
             $table->increments('id');
             $table->unsignedInteger('user_id');
             $table->unsignedInteger('sale_id');

             $table->foreign('user_id')->references('id')->on('users');
             $table->foreign('sale_id')->references('id')->on('sales');
         });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actual_notificaions');
    }
}

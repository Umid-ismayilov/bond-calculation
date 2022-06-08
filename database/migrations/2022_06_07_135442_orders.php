<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('Hansı müştəri alıb');//Auth qoşulmayıb
            $table->integer('bond_id')->comment('Hansı İstiqrazin alıb');
            $table->integer('quantity')->comment('Neçədənə alıb');
            $table->date('order_date')->comment('Sifariş tarixi'); //Deye bilersiniz ki, created_at var neye lazimdi ola bil ki, order yaransın amma sonra ödəniş edilsin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}

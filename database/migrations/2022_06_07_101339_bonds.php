<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Bonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->string('name',25)->comment('ISTIQRAZ ADI');
            $table->decimal('nominal_price',$precision = 8, $scale = 2)->comment('Nominal Qiymət');
            $table->integer('coupon_pay_interval')->comment('Kuponların ödənilmə tezliyi');
            $table->integer('percent_calculating_period')->comment('Faizlərin hesablanma periodu');
            $table->decimal('coupon_percent', $precision = 8, $scale = 2)->comment('Kupon faizi');
            $table->string('currency',10)->comment('valyuta');
            $table->date('emission_date')->comment('Emissiya tarixi');
            $table->date('turnover_date')->comment('Son tədavül tarixi');
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
        Schema::drop('bonds');
    }
}

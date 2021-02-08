<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');;
            $table->bigInteger('device_id')->unsigned()->nullable(false);
            $table->enum('status',['STARTED','RENEWED','CANCELED'])->nullable(true);
            $table->bigInteger('receipt_id')->nullable(true);
            $table->dateTime('expiry_date')->nullable(true);
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices');
            $table->unique('device_id');
            $table->index(['receipt_id']);
            $table->index(['expiry_date','status']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}

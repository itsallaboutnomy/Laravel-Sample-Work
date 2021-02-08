<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('app_id')->unsigned();
            $table->string('uid',255)->nullable(false);
            $table->string('client_token',255)->nullable(false)->unique();
            $table->enum('os',['iOS','GOOGLE'])->default(null);
            $table->string('language',255)->default(null);
            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('applications');
            $table->unique(['app_id', 'uid']);
            $table->index(['app_id', 'client_token']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}

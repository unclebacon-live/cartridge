<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmulatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emulators', function (Blueprint $table) {
            $table->id();

            $table->string('platform_slug');
            $table->foreign('platform_slug')->references('slug')->on('platforms');

            $table->string('name');
            $table->string('download_url');

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
        Schema::dropIfExists('emulators');
    }
}

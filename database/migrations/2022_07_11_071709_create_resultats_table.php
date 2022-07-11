<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("nom");
            $table->string("description");
            $table->string("image")->nullable();

            $table->foreignId("portrait_id")->constrained();
        });

        //remplacé par ->constrained()
        // Schema::table('resultats', function (Blueprint $table) {         
        //     $table->foreign('portrait_id')->references('id')->on('portraits');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultats');
    }
};

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
        Schema::create('portraits', function (Blueprint $table) {
            $table->id(); //type : unsigned big integer 
            $table->timestamps(); //created_at & update_at
            $table->string("nom");
            $table->string("description");
            $table->string("image")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portraits');
    }
};

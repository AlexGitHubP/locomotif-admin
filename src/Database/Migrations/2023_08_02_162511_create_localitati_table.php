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
        Schema::create('localitati', function (Blueprint $table) {
            $table->id();
            $table->integer('zip_code')->nullable();
            $table->string('denumire', 25)->nullable();
            $table->string('judet')->nullable();
            $table->string('judet_code');
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
        Schema::dropIfExists('localitati');
    }
};

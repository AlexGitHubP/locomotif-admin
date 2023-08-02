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
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tva');
            $table->enum('tax_type', ['percent', 'fixed']);
            $table->tinyInteger('maintenance');
            $table->string('success_page');
            $table->string('brand_logo');
            $table->string('brand_name');
            $table->string('brand_contact');
            $table->string('brand_email');
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
        Schema::dropIfExists('shop_settings');
    }
};

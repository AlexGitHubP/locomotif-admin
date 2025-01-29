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
        Schema::create('account_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->string('contact_person');
            $table->string('street');
            $table->string('nr');
            $table->string('bloc');
            $table->string('scara');
            $table->string('apartament');
            $table->string('city');
            $table->string('county');
            $table->string('country');
            $table->string('zip_code');
            $table->text('comments');
            $table->unsignedInteger('ordering')->nullable();
            $table->boolean('is_billing_address')->default(false);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_addresses');
    }
};

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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id',            )->length(10);
            $table->unsignedBigInteger('user_id');
            $table->enum('type', array('client', 'designer', 'administrator', 'guest'));
            $table->string('name',              255);
            $table->string('surname',           255);
            $table->string('email',             255)->unique();
            $table->string('phone',             255)->nullable();
            $table->string('url',               255);
            $table->string('description',       255);
            $table->integer('ordering'             )->length(10)->unsigned()->nullable();
            $table->enum('status', array('hidden', 'published', 'pending'));
            $table->boolean('is_company')->default(false);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};

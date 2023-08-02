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
        Schema::create('account_company_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->string('company_name')->charset('utf8mb4');
            $table->string('company_type')->charset('utf8mb4');
            $table->string('company_vat_type')->charset('utf8mb4');
            $table->string('company_cui')->charset('utf8mb4');
            $table->string('company_j')->charset('utf8mb4');
            $table->string('company_nr')->charset('utf8mb4');
            $table->string('company_series')->charset('utf8mb4');
            $table->string('company_year')->charset('utf8mb4');
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
        Schema::dropIfExists('account_company_infos');
    }
};

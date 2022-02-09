<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('sender');
            $table->string('receiver');
            $table->string('reference');
            $table->string('description');
            $table->integer('amount');
            $table->string('method');
            $table->string('phoneNumber');
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
        Schema::dropIfExists('cash_transfers');
    }
}
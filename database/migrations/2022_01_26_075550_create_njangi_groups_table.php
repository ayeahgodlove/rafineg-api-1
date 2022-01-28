<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNjangiGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('njangi_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumText('description', 500);
            $table->integer('minimum_savings')->nullable();
            $table->integer('maximum_savings')->nullable();
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
        Schema::dropIfExists('njangi_groups');
    }
}
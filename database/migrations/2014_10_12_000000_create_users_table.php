<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 120);
            $table->string('lastname', 120);
            $table->string('email', 100)->unique();
            $table->tinyInteger('phonenumber')->unique();
            $table->boolean('isVerified')->default(false)->comment('false: user not verified, true: user verified');
            $table->string('utype')->default('USR')->comment('ADM for admin, USR for customer/client');
            $table->string('referal_link', 120);
            $table->string('parent_referal_code', 120);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
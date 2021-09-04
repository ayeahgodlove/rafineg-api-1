<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Stmt\Enum_;

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
            $table->string('name', 30);
            $table->string('email', 50);
            $table->integer('phone_number');
            $table->string('password');
            $table->string('firstname', 20);
            $table->string('lastname', 20);
            // $table->boolean('registration_fee_paid')->default(false);
            // $table->string('gender', enum(["male", "female"]))->default("male");
            $table->boolean('isVerified')->default(false)->comment('false: user not verified, true: user verified');
            $table->timestamp('email_verified_at')->nullable();
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
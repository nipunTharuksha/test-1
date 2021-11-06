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
            $table->string('name');
            $table->string('user_name', 20);
            $table->text('avatar')->nullable();
            $table->string('email')->unique();
            $table->enum('user_role', ['admin', 'user'])->default('user');
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('otp_verified')->default(false);
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

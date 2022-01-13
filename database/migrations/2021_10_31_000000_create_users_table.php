<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->nullable();
            $table->string('username',20)->nullable()->unique();
            $table->string('email',30)->unique();
            $table->string('password',100)->nullable();
            $table->string('avatar')->nullable();
            $table->char('user_role',5)->default('user');
            $table->string('registered_at')->nullable();
            $table->string('invitation_token')->nullable();
            $table->timestamps();
            $table->index(['username']);
        });
        DB::statement('ALTER TABLE users ADD CONSTRAINT chk_user_role CHECK (user_role = "admin" or user_role = "user"  );');
    }
    
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

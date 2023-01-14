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
            $table->increments('id');
            $table->integer('type')->default(21);
            $table->string('school_cn', 100)->nullable();
            $table->string('school_zh', 100)->nullable();
            $table->string('name_cn', 50)->nullable();
            $table->string('name_zh', 50)->nullable();
            $table->string('account', 50);
            $table->string('password', 100);
            $table->string('cellphone', 20);
            $table->integer('birthday');
            $table->string('wechat', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('lineid', 50)->nullable();
            $table->string('email', 200)->nullable();
            $table->integer('authority')->default(7);
            $table->string('token');
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

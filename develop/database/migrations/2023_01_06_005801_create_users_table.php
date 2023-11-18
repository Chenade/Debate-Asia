<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->integer('type');
            $table->string('school_cn', 100)->nullable();
            $table->string('school_zh', 100)->nullable();
            $table->string('name_cn', 50);
            $table->string('name_zh', 50);
            $table->string('name_en', 255);
            $table->string('gender', 10);
            $table->string('account', 50);
            $table->text('region')->nullable();
            $table->text('address');
            $table->string('password', 100);
            $table->string('cellphone', 20);
            $table->integer('birthday');
            $table->string('wechat', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('lineid', 50)->nullable();
            $table->string('email', 200)->nullable();
            $table->text('mentor')->nullable();
            $table->integer('authority')->default(7);
            $table->string('token', 255)->nullable();
            $table->tinyInteger('locked')->default(0);
            $table->timestamps();
            $table->index('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //平台 | 連結 | 圖片 | 條列介紹
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->default(1);
            $table->json('content');
            $table->string('image')->default('');
            $table->string('link')->nullable()->default('');
            $table->string('link_alt')->nullable()->default('');
            $table->integer('ord')->default(1);
            $table->integer('del')->default(0);
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
        Schema::dropIfExists('media');
    }
}

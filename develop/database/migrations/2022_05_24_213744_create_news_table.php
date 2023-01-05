<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category')->default(1);
            $table->string('title');
            $table->json('content');
            $table->string('image')->default('');
            $table->string('link')->nullable()->default('');
            $table->string('link_alt')->nullable()->default('');
            $table->integer('ts')->useCurrent();
            $table->integer('start_at')->useCurrent();
            $table->integer('end_at')->useCurrent();
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
        Schema::dropIfExists('news');
    }
}

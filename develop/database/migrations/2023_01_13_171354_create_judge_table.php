<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judge', function (Blueprint $table) {
            $table->id();
            $table->integer('mid');
            $table->integer('aid');
            $table->integer('score_1')->default(0);
            $table->integer('score_2')->default(0);
            $table->integer('score_3')->default(0);
            $table->integer('score_4')->default(0);
            $table->integer('score_5')->default(0);
            $table->integer('score')->default(0);
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('judge');
    }
}

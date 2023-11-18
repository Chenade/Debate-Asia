<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudgeTable extends Migration
{
    public function up()
    {
        Schema::create('judge', function (Blueprint $table) {
            $table->id();
            $table->integer('round_id');
            $table->integer('score_1')->default(0);
            $table->integer('score_2')->default(0);
            $table->integer('score_3')->default(0);
            $table->integer('score_4')->default(0);
            $table->integer('score_5')->default(0);
            $table->integer('status')->default(0);
            $table->string('comment', 500)->nullable();
            $table->timestamps();
            $table->index('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('judge');
    }
}

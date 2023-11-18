<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->integer('round_id')->nullable();
            $table->integer('type');
            $table->text('content')->nullable();
            $table->timestamps();
            $table->index('article_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

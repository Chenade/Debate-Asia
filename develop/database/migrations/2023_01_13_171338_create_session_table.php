<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->nullable();
            $table->string('session_name')->nullable();
            $table->text('session_config')->nullable();
            $table->string('pos_title', 50)->nullable();
            $table->string('neg_title', 50)->nullable();
            $table->integer('date');
            $table->date('updated_at');
            $table->date('created_at');
            $table->index('id');
            $table->index('group_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}

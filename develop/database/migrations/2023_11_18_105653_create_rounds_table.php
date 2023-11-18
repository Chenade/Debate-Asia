<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id')->nullable();
            $table->integer('round_number')->nullable();
            $table->integer('role')->default(0);
            $table->integer('user_id')->nullable();
            $table->string('camera', 120)->nullable();
            $table->integer('camera_ts')->nullable();
            $table->integer('start')->nullable();
            $table->text('round_config')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->index('id');
            $table->index('session_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}

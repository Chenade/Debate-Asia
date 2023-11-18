<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->integer('competition_id')->nullable();
            $table->string('group_name')->nullable();
            $table->text('group_config')->nullable();
            $table->integer('t_write')->nullable();
            $table->integer('t_read')->nullable();
            $table->integer('t_debate')->nullable();
            $table->timestamps();
            $table->index('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
}

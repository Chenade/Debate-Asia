<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_log', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->integer('competition_id')->default(1);
            $table->integer('group_id');
            $table->longText('date')->nullable();
            $table->string('language', 5);
            $table->string('invoice_name', 50)->nullable();
            $table->string('invoice_no', 20)->nullable();
            $table->string('proof', 50);
            $table->tinyInteger('approval')->default(0);
            $table->date('updated_at');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_log');
    }
}

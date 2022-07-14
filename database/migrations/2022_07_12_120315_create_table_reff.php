<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reff', function (Blueprint $table) {
            $table->id();
            $table->string('name', 131);
            $table->integer('value');
            $table->string('show', 255);
            $table->integer('status')->comment("1 active, 2 inactive");
            $table->string('creator', 51);
            $table->string('editor', 51);
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
        Schema::dropIfExists('reff');
    }
}

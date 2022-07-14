<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 151);
            $table->string('npm', 31);
            $table->text('address')->nullable();
            $table->string('phone', 51)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('gender')->default(1)->comment('1 Laki-laki, 2 Perempuan');
            $table->integer('religion')->default(1)->comment('1 Islam, 2 Hindu, 3 Budha, 4 Kristen, 5 Protestan, 6 Other');
            $table->string('photo', 255);
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
        Schema::dropIfExists('students');
    }
}

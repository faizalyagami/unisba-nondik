<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudentActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('sub_activity_id');
            $table->string('attachment', 255)->nullable();
            $table->text('notes');
            $table->integer('status')->default(1)->comment("1 open, 2 review, 3 approve, 4 reject");
            $table->string('creator', 51);
            $table->string('editor', 51);
            $table->timestamps();
        });

        Schema::create('student_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('student_activity_id');
            $table->integer('sub_activity_id');
            $table->text('notes');
            $table->integer('status')->default(1)->comment("1 open, 2 review, 3 approve, 4 reject");
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
        Schema::dropIfExists('student_activity_logs');
        Schema::dropIfExists('student_activities');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeriodeStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->integer('class_of')->after('pansus')->nullable();
            $table->date('period')->after('class_of')->nullable();
            $table->integer('certificate_approve')->after('period')->default(0)->comment('0 Not Approve, 1 Approve, 2 Reject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->indropColumnteger('class_of');
            $table->dropColumn('period');
            $table->dropColumn('certificate_approve');
        });
    }
}

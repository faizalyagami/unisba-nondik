<?php

use App\Models\Reff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrderStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->integer('order')->after('class_of')->nullable();
            $table->date('certificate_approve_date')->after('certificate_approve')->nullable();
        });

        Schema::table('sub_activities', function (Blueprint $table) {
            $table->boolean('required')->after('sks')->default(0);
        });

        Schema::table('student_activities', function (Blueprint $table) {
            $table->string('organizer')->after('attachment')->nullable();
            $table->string('place')->after('organizer')->nullable();
            $table->date('held_date')->after('place')->nullable();
            $table->string('participation')->after('held_date')->nullable();
        });

        Reff::insert([
            [
                'name' => 'RequiredActivity', 
                'value' => 2,
                'show' => 2,
                'creator' => 'admin', 
                'editor' => 'admin', 
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('certificate_approve_date');
        });

        Schema::table('sub_activities', function (Blueprint $table) {
            $table->dropColumn('required');
        });

        Schema::table('student_activities', function (Blueprint $table) {
            $table->dropColumn('organizer');
            $table->dropColumn('place');
            $table->dropColumn('held_date');
            $table->dropColumn('participation');
        });
    }
}

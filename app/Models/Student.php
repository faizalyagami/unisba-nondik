<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->hasOne('App\Models\User');
    }

    public function studentActivities() {
        return $this->hasMany('App\Models\StudentActivity');
    }

    public static function lastOrder($clas_of) {
        $student = static::select('order')
            ->where('class_of', $clas_of)
            ->orderBy('id', 'desc')
            ->first();

        //$last = $student->order;
        $last = $student ? $student->order : 0;

        return $last;
    }
}

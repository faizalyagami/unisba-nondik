<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student() {
        return $this->belongsTo('App\Models\Student');
    }

    public function subActivity() {
        return $this->belongsTo('App\Models\SubActivity');
    }

    public function studentActivityLogs() {
        return $this->hasMany('App\Models\StudentActivityLog');
    }
}

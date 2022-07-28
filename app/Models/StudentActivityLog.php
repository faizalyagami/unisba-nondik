<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivityLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function studentActivity() {
        return $this->belongsTo('App\Models\StudentActivity');
    }

    public function subActivity() {
        return $this->belongsTo('App\Models\SubActivity');
    }
}

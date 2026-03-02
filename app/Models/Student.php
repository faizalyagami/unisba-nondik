<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->hasOne(User::class, 'student_id');
    }

    /**
     * Relasi ke StudentActivity
     */
    public function studentActivities()
    {
        return $this->hasMany(StudentActivity::class, 'student_id');
    }

    /**
     * Relasi ke Period
     */
    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    /**
     * Mendapatkan nomor order terakhir berdasarkan angkatan
     */
    public function lastOrder($class_of)
    {
        $last = self::where('class_of', $class_of)->orderBy('order', 'desc')->first();
        return $last ? $last->order : 0;
    }
}
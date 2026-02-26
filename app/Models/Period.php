<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['name', 'tahun_awal', 'tahun_akhir', 'semester', 'is_active'];

    public function subActivities() {
        return $this->hasMany(SubActivity::class);
    }
}

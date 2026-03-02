<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'tahun_awal', 'tahun_akhir', 'semester', 'is_active', 'start_order', 'current_order'];

    public function subActivities() {
        return $this->hasMany(SubActivity::class);
    }

    /**
     * Mendapatkan nomor urut berikutnya untuk periode aktif
     */
    public static function getNextOrderNumber()
    {
        $activePeriod = self::where('is_active', true)->first();
        
        if (!$activePeriod) {
            throw new \Exception('Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.');
        }
        
        $nextOrder = $activePeriod->current_order + 1;
        
        // Update current_order di periode aktif
        $activePeriod->current_order = $nextOrder;
        $activePeriod->save();
        
        // Format nama periode untuk tampilan
        $periodName = $activePeriod->tahun_awal . '/' . $activePeriod->tahun_akhir . ' ' . ucfirst($activePeriod->semester);
        
        return [
            'order' => $nextOrder,
            'period_id' => $activePeriod->id,
            'period_name' => $periodName,
            'tahun_awal' => $activePeriod->tahun_awal,
            'tahun_akhir' => $activePeriod->tahun_akhir,
            'semester' => $activePeriod->semester
        ];
    }

    /**
     * Reset nomor urut periode ke nilai awal
     */
    public function resetOrder()
    {
        $this->current_order = $this->start_order - 1;
        $this->save();
    }
}
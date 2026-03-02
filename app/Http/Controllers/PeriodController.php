<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $active = 'periods';
        $sub_active = 'periods';
        
        $periods = Period::orderBy('tahun_awal', 'desc')
            ->orderByRaw("FIELD(semester, 'ganjil', 'genap', 'antara')")
            ->get();
            
        return view('pages.periods.index', compact('periods', 'active', 'sub_active'));
    }

    public function create()
    {
        $active = 'periods';
        $sub_active = 'periods-create';
        
        return view('pages.periods.create', compact('active', 'sub_active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_awal' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|min:2000|max:2100|gt:tahun_awal',
            'semester' => 'required|in:ganjil,genap,antara',
            'start_order' => 'required|integer|min:1'
        ]);

        $name = $request->tahun_awal . '/' . $request->tahun_akhir . ' Semester ' . ucfirst($request->semester);

        Period::create([
            'name' => $name,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'semester' => $request->semester,
            'start_order' => $request->start_order,
            'current_order' => $request->start_order - 1,
            'is_active' => false
        ]);

        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil ditambahkan');
    }

    public function show(Period $period)
    {
        $active = 'periods';
        $sub_active = 'periods-show';
        
        return view('pages.periods.show', compact('period', 'active', 'sub_active'));
    }

    public function edit(Period $period)
    {
        $active = 'periods';
        $sub_active = 'periods-edit';
        
        return view('pages.periods.edit', compact('period', 'active', 'sub_active'));
    }

    public function update(Request $request, Period $period)
    {
        $request->validate([
            'tahun_awal' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|min:2000|max:2100|gt:tahun_awal',
            'semester' => 'required|in:ganjil,genap,antara',
            'start_order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $name = $request->tahun_awal . '/' . $request->tahun_akhir . ' Semester ' . ucfirst($request->semester);

        $period->update([
            'name' => $name,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
            'semester' => $request->semester,
            'start_order' => $request->start_order,
            'is_active' => $request->is_active ?? false
        ]);

        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy(Period $period)
    {
        $period->delete();
        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil dihapus');
    }

    public function activate(Period $period)
    {
        // Nonaktifkan semua periode
        Period::query()->update(['is_active' => false]);
        
        // Aktifkan periode yang dipilih
        $period->is_active = true;
        $period->current_order = $period->start_order - 1; // reset ke awal periode
        $period->save();

        return redirect()->route('admin.periods.index')->with('success', 'Periode ' . $period->name . ' diaktifkan');
    }

    public function resetOrder(Period $period)
    {
        $period->current_order = $period->start_order - 1;
        $period->save();

        return redirect()->route('admin.periods.index')->with('success', 'Nomor urut periode ' . $period->name . ' telah direset');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Userdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');

    $pemeriksaan = Pemeriksaan::when($search, function ($query, $search) {
        return $query->where('userdata.name', 'like', "%{$search}%")
                     ->select('userdata.name','pemeriksaan.*');
    })->selectRaw('userdata.name, pemeriksaan.*')
    ->join('userdata', 'userdata.id', '=', 'pemeriksaan.pasien_id')
    ->where('pemeriksaan.dokter_id', '=', auth()->id())
    ->paginate(10);
    return view('pemeriksaan.index', compact('pemeriksaan'));

    }

    public function create()
    {
        $data['pasien'] = Userdata::where('level', 'pasien')->get();
        return view('pemeriksaan.create', compact('data'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pasien' => 'required',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'systole' => 'nullable|numeric',
            'diastole' => 'nullable|numeric',
            'heart_rate' => 'nullable|numeric',
            'respiration_rate' => 'nullable|numeric',
            'suhu_tubuh' => 'nullable|numeric',
            'pemeriksaan_dokter' => 'nullable',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1048',
        ]);
        $filePath=null;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
        }

        $getidpasien=$request->pasien;
        $userData = Userdata::where('id', $getidpasien)->first();
        if ($userData==null) {
            $insertPasien = UserData::create([
                'name' => $request->pasien,
                'username' => $request->pasien,
                'level' => "pasien",
                'password' => bcrypt($request->pasien),
            ]);
            $getidpasien=$insertPasien->id;
        }
        
        Pemeriksaan::create([
            'dokter_id' => auth()->id(),
            'pasien_id' => $getidpasien,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'systole' => $request->systole,
            'diastole' => $request->diastole,
            'heart_rate' => $request->heart_rate,
            'respiration_rate' => $request->respiration_rate,
            'suhu_tubuh' => $request->suhu_tubuh,
            'pemeriksaan_dokter' => $request->pemeriksaan_dokter,
            'berkas' => $filePath,
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->route('pemeriksaan.index')->with('success', 'Pemeriksaan added successfully.');
    }

    public function show($id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        return view('pemeriksaan.show', compact('pemeriksaan'));
    }

    public function edit($id)
    {
        $data['pemeriksaan'] = Pemeriksaan::findOrFail($id);
        $data['pasien'] = Userdata::where('level', 'pasien')->get();
        return view('pemeriksaan.edit', compact('data'));
    }
    
    public function update(Request $request, Pemeriksaan $pemeriksaan)
    {
        $request->validate([
            'pasien' => 'required',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'systole' => 'nullable|numeric',
            'diastole' => 'nullable|numeric',
            'heart_rate' => 'nullable|numeric',
            'respiration_rate' => 'nullable|numeric',
            'suhu_tubuh' => 'nullable|numeric',
            'pemeriksaan_dokter' => 'nullable',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1048',
        ]);
        
        $filePath=$request->oldberkas;
        if ($request->hasFile('berkas')) {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $file = $request->file('berkas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
        }

        $getidpasien=$request->pasien;
        $userData = Userdata::where('id', $getidpasien)->first();
        if ($userData==null) {
            $insertPasien = UserData::create([
                'name' => $request->pasien,
                'username' => $request->pasien,
                'level' => "pasien",
                'password' => bcrypt($request->pasien),
            ]);
            $getidpasien=$insertPasien->id;
        }

        $pemeriksaan->update([
            'dokter_id' => auth()->id(),
            'pasien_id' => $getidpasien,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'systole' => $request->systole,
            'diastole' => $request->diastole,
            'heart_rate' => $request->heart_rate,
            'respiration_rate' => $request->respiration_rate,
            'suhu_tubuh' => $request->suhu_tubuh,
            'pemeriksaan_dokter' => $request->pemeriksaan_dokter,
            'berkas' => $filePath,
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pemeriksaan.index')->with('success', 'Pemeriksaan updated successfully.');
    }

    public function destroy($id)
    {
        $Pemeriksaan = Pemeriksaan::findOrFail($id);
        $Pemeriksaan->delete();
        return redirect()->route('pemeriksaan.index')->with('success', 'User deleted successfully.');
    }
}

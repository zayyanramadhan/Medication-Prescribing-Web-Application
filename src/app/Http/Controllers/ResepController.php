<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Userdata;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');

    $resep = Pemeriksaan::when($search, function ($query, $search) {
        return $query->where('userdata.name', 'like', "%{$search}%")
                     ->select('userdata.name','pemeriksaan.*');
    })->select('userdata.name', 'pemeriksaan.*',  DB::raw('MAX(resep.status) as status'))
    ->join('resep', 'resep.pemeriksaan_id', '=', 'pemeriksaan.id')
    ->join('userdata', 'userdata.id', '=', 'pemeriksaan.pasien_id')
    ->whereOr('pemeriksaan.dokter_id', '=', auth()->id())
    ->whereOr('pemeriksaan.apoteker_id', '=', auth()->id())
    ->groupBy('pemeriksaan.id')
    ->paginate(10);
    return view('resep.index', compact('resep'));

    }

    public function create($pemeriksaan)
    {
        $this->authenticateAPI();
        $dataPemeriksaan = Pemeriksaan::findOrFail($pemeriksaan);
        $data['pasien'] = Userdata::where('id', $dataPemeriksaan->pasien_id)->first();
        $data['pemeriksaan_id'] = $pemeriksaan;
        $apiToken = session('api_token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
        $data['obat'] = $response->successful() ? $response->json()['medicines'] : [];
        return view('resep.create', compact('data'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pemeriksaan_id' => 'required',
            'obat_id' => 'required',
            'obat_name' => 'required|string|max:255',
            'obat_price' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);
        
        Resep::create([
            'pemeriksaan_id' => $request->pemeriksaan_id,
            'obat_name' => $request->obat_name,
            'obat_id' => $request->obat_id,
            'obat_price' => $request->obat_price,
            'jumlah' => $request->jumlah,
            'status' => "dokter",
            'total_price' => $request->obat_price*$request->jumlah,
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->route('resep.show',$request->pemeriksaan_id)->with('success', 'Resep added successfully.');
    }

    public function show($pemeriksaan)
    {
        $this->authenticateAPI();
        $dataPemeriksaan = Pemeriksaan::findOrFail($pemeriksaan);
        $data['pasien'] = Userdata::where('id', $dataPemeriksaan->pasien_id)->first();
        $data['resep'] = Resep::where('pemeriksaan_id', $pemeriksaan)->get();
        $data['pemeriksaan_id'] = $pemeriksaan;
        $apiToken = session('api_token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
        $data['obat'] = $response->successful() ? $response->json()['medicines'] : [];
        return view('resep.create', compact('data'));
    }
    
    public function update(Request $request, $resepid)
    {
        $resep = Resep::findOrFail($resepid);
        $request->validate([
            'pemeriksaan_id' => 'required|numeric',
            'obat_id' => 'required',
            'obat_name' => 'required|string|max:255',
            'obat_price' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);     
        $level="dokter";   
        if (auth()->user()->level == "dokter") {
            $level= "dokter";
            if ($resep->status== 'apoteker' && $resep->status== 'selesai') {
                return redirect()->route('resep.index')->with('error', 'Resep diproses apoteker');
            }
        }else if (auth()->user()->level == "apoteker") {
            $level= "apoteker";
            if ($resep->status== 'selesai') {
                return redirect()->route('resep.index')->with('error', 'Resep telah selesai');
            }
        }
        $resep->update([
            'pemeriksaan_id' => $request->pemeriksaan_id,
            'obat_name' => $request->obat_name,
            'obat_id' => $request->obat_id,
            'obat_price' => $request->obat_price,
            'jumlah' => $request->jumlah,
            'status' => $level,
            'total_price' => $request->obat_price*$request->jumlah,
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ]);

        return redirect()->route('resep.show',$request->pemeriksaan_id)->with('success', 'Resep updated successfully.');
    }

    public function delete($id)
    {
        $resep = Resep::findOrFail($id);
        $resep->delete();
        return redirect()->route('resep.index')->with('success', 'Resep deleted successfully.');
    }

    public function exportPdf($pemeriksaan)
    {
        $dataPemeriksaan = Pemeriksaan::findOrFail($pemeriksaan);
        
        Resep::where('pemeriksaan_id', $pemeriksaan)->update([
            'status' => "selesai",
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ]);
        $data = [
            'resep' => Resep::where('pemeriksaan_id', $pemeriksaan)->get(),
            'pasien' => Userdata::where('id', $dataPemeriksaan->pasien_id)->first(),
        ];
        $pdf = Pdf::loadView('resep.pdf', $data);
        return $pdf->download('resi-resep.pdf');
    }

    public function authenticateAPI()
    {
        $email = env('API_USERNAME');
        $password = env('API_PASSWORD');

        $response = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
            'email' => $email,
            'password' => $password,
        ]);
        if ($response->successful()) {
            $token = $response->json()['access_token'];
            session()->put('api_token', $token);
        } else {
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\disposisi;
use App\SuratKeluar;
use App\SuratMasuk;
use app\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index(){
        $surat_keluar=SuratKeluar::all();

        // passing data transaksi ke view transaksi.blade.php
        return view('keluar.index',['surat_keluar'=>$surat_keluar]);

    }

    public function show($id){
        $surat_keluar = SuratKeluar::findOrFail($id);
        return view('keluar.index', ['surat_keluar' => $surat_keluar]);
    }

    public function create(){
        return view('keluar.create');
    }

    public function store(Request $request){
    $this->validate($request, [
        'kode_klasifikasi'=>'required',
        'no_surat' => 'required',
        'isi_ringkasan' => 'required',
        'tanggal' => 'required',
        'asal' => 'required',
        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
        'keterangan' => 'nullable',
    ]);

    // Ambil file dari input
    $file = $request->file('file');

    // Buat nama file unik
    $nama_file = time() . '_' . $file->getClientOriginalName();

    // Tentukan folder tujuan upload
    $tujuan_upload = public_path('data_file');

    // Upload file ke folder tujuan
    $file->move($tujuan_upload, $nama_file);

    // Simpan data ke database
    SuratKeluar::create([
        'kode_klasifikasi'=>$request->kode_klarifikasi,
        'isi_ringkasan' => $request->isi_ringkasan,
        'tanggal' => $request->tanggal,
        'no_surat' => $request->no_surat,
        'asal' => $request->asal,
        'file' => $nama_file, // ✅ FIX di sini
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('surat-keluar.index')->with('sukses', 'berhasil ditambahkan');
}


    public function edit($id){
        $surat_keluar = SuratKeluar::findorFail($id);
        return view('keluar.edit', ['surat_keluar'=>$surat_keluar]);
    }

    public function update(Request $request, $id){
        $surat_keluar = SuratKeluar::findOrFail($id);
        $surat_keluar->kode_klasifikasi = $request->kode_klarifikasi;
        $surat_keluar->isi_ringkasan = $request->isi_ringkasan;
        $surat_keluar->no_surat = $request->no_surat;
        $surat_keluar->tanggal = $request->tanggal;
        $surat_keluar->asal = $request->asal;
        $surat_keluar->keterangan = $request->keterangan;


    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $nama_file = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('data_file'), $nama_file);
        $surat_keluar->file = $nama_file;
    }

    $surat_keluar->save();

    return redirect()->route('surat-keluar.index')->with('sukses', 'Data Surat Keluar berhasil diperbarui.');
    }

    public function destroy($id){
        // Ambil data transaksi berdasarkan id, kemudian hapus
        $surat_keluar = SuratKeluar::find($id);
        $surat_keluar ->delete();

        // Alihkan halaman kembali ke halaman transaksi sambil mengirim pesan notifikasi
        return redirect()->route('surat-keluar.index')->with("sukses","Surat Keluar berhasul dihapus");
    }

    public function file($filename)
    {
        $file_path = public_path('data_file/' . $filename);

        if (file_exists($file_path)) {
            return response()->file($file_path);
        } else {
            abort(404, 'File not found.');
        }
    }

}

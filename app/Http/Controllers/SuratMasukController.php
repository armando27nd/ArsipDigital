<?php

namespace App\Http\Controllers;
use App\SuratMasuk;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index(){
        $surat_masuk=SuratMasuk::all();

        // passing data transaksi ke view transaksi.blade.php
        return view('masuk.index',['surat_masuk'=>$surat_masuk]);

    }

    public function create(){
        return view('masuk.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'kode_klasifikasi'=>'required',
            'no_surat' => 'required',
            'isi_ringkasan' => 'required',
            'tanggal' => 'required',
            'asal' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:255',
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
        SuratMasuk::create([
        'kode_klasifikasi'=> $request->kode_klasifikasi,
        'isi_ringkasan' => $request->isi_ringkasan,
        'tanggal' => $request->tanggal,
        'no_surat'=>$request->no_surat,
        'asal'=>$request->asal,
        'file'=>$nama_file,
        'keterangan'=> $request-> keterangan,
    ]);

        return redirect()->route('surat-masuk.index')->with('sukses', 'berhasil ditambahkan');
    }

    public function edit($id){
        $surat_masuk = SuratMasuk::findorFail($id);
        return view('masuk.edit', ['surat_masuk'=>$surat_masuk]);
    }

    public function update(Request $request, $id){
        $surat_masuk = SuratMasuk::findOrFail($id);
        $surat_masuk->kode_klasifikasi=$request->kode_klasifikasi;
        $surat_masuk->isi_ringkasan = $request->isi_ringkasan;
        $surat_masuk->no_surat = $request->no_surat;
        $surat_masuk->tanggal = $request->tanggal;
        $surat_masuk->asal = $request->asal;
        $surat_masuk->keterangan = $request->keterangan;


    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $nama_file = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('data_file'), $nama_file);
        $surat_masuk->file = $nama_file;
    }

    $surat_masuk->save();

    return redirect()->route('surat-masuk.index')->with('sukses', 'Data Surat Masuk berhasil diperbarui.');
    }

    public function destroy($id){
        // Ambil data transaksi berdasarkan id, kemudian hapus
        $surat_masuk = SuratMasuk::find($id);
        $surat_masuk ->delete();

        // Alihkan halaman kembali ke halaman transaksi sambil mengirim pesan notifikasi
        return redirect()->route('surat-masuk.index')->with("sukses","Surat Masuk berhasul dihapus");
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


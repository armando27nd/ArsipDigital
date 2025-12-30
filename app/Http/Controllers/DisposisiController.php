<?php

namespace App\Http\Controllers;
use App\Disposisi;
use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DisposisiController extends Controller
{
    /**
     * Menampilkan daftar disposisi.
     * Admin melihat semua data, user hanya melihat data miliknya.
     */
    public function index()
    {
        $user = Auth::user();
        $disposisis = collect(); // Inisialisasi sebagai koleksi kosong

        // FIX: Menggunakan properti 'role' untuk pengecekan, bukan method hasRole()
        if ($user->role == 'admin') {
            $disposisis = Disposisi::with('user')->latest()->get();
        } else {
            $disposisis = Disposisi::where('user_id', $user->id)->latest()->get();
        }

        return view('disposisi.index', compact('disposisis'));
    }

    /**
     * Menampilkan form untuk membuat disposisi baru.
     */
    public function create()
    {
        return view('disposisi.create');
    }

    /**
     * Menyimpan disposisi baru ke database.
     */
    public function store(Request $request)
    {
        // FIX: Menyesuaikan validasi dengan form create.blade.php
        $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'no_registrasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'perihal' => 'required|string',
            'no_dan_tanggal' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $nama_file = null;
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            // Simpan file ke folder storage/app/public/data_file
            $file->storeAs('public/data_file', $nama_file);
        }

        // FIX: Menyesuaikan field yang disimpan dengan form dan tabel database
        Disposisi::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'no_registrasi' => $request->no_registrasi,
            'tanggal' => $request->tanggal,
            'perihal' => $request->perihal,
            'no_dan_tanggal' => $request->no_dan_tanggal,
            'asal' => $request->asal,
            'catatan' => $request->catatan,
            'file_surat' => $nama_file,
            'status' => 'proses', // Status awal saat dibuat
        ]);

        // FIX: Redirect dinamis berdasarkan peran pengguna
        $redirectRoute = Auth::user()->role == 'admin' ? 'admin.disposisi.index' : 'user.disposisi.index';

        return redirect()->route($redirectRoute)->with('sukses', 'Disposisi berhasil diajukan.');
    }

    /**
     * Menampilkan detail sebuah disposisi.
     */
    public function show($id)
    {
        $disposisi = Disposisi::with(['user', 'admin'])->findOrFail($id);

        // Otorisasi: user hanya boleh lihat miliknya, admin boleh lihat semua
        if (Auth::user()->role == 'user' && $disposisi->user_id != Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('disposisi.show', compact('disposisi'));
    }

    /**
     * Menampilkan form untuk mengedit disposisi (khusus Admin).
     */
    public function edit($id)
    {
        $disposisi = Disposisi::with('user')->findOrFail($id);
        return view('disposisi.edit', compact('disposisi'));
    }

    /**
     * Memperbarui data disposisi di database (khusus Admin).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'instruksi_admin' => 'required|string',
            'diteruskan' => 'nullable|string',
            'status' => 'required|in:proses,disetujui,ditolak',
        ]);

        $disposisi = Disposisi::findOrFail($id);

        $disposisi->update([
            'admin_id' => Auth::id(),
            'instruksi_admin' => $request->instruksi_admin,
            'diteruskan' => $request->diteruskan,
            'status' => $request->status,
            'waktu_instruksi_admin' => now(),
        ]);

        // Logika untuk membuat agenda bisa ditambahkan di sini jika diperlukan
        // if ($request->status == 'disetujui' && ...) { ... }

        return redirect()->route('admin.disposisi.index')->with('sukses', 'Disposisi berhasil diperbarui.');
    }

    /**
     * Menyiapkan data untuk dicetak.
     */
    public function cetak($id)
    {
        $disposisi = Disposisi::with(['user', 'admin'])->findOrFail($id);

        // Otorisasi: user hanya boleh cetak miliknya, admin boleh cetak semua
        if (Auth::user()->role == 'user' && $disposisi->user_id != Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('disposisi.cetak', compact('disposisi'));
    }

    public function agenda($id){
        $agenda = Agenda::findOrFail($id);
        $disposisi = Disposisi::all();
        return view('disposisi.agenda', compact('agenda', 'disposisi'));

    }

    public function agenda_store(Request $request, $id){
    $agenda = Agenda::findOrFail($id);
    $agenda->jam = $request->jam;
    $agenda->kegiatan = $request->kegiatan;
    $agenda->tempat = $request->tempat;
    $agenda->pejabat = $request->pejabat;
    $agenda->keterangan = $request->keterangan;
    $agenda->save();

    return redirect('/agenda')->with('sukses', 'Data agenda berhasil diperbarui.');
    }

}

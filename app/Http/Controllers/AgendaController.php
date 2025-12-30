<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disposisi;
use App\Agenda;
use App\SuratKeluar;
use App\SuratMasuk;


class AgendaController extends Controller
{

 public function index()
    {
        // FIX: Mengirim variabel $agendas (jamak), bukan $agenda (tunggal)
        $agendas = Agenda::with('disposisi')->latest()->get();
        return view('agenda.index', compact('agendas'));
    }

    /**
     * Menampilkan form untuk membuat agenda dari SATU disposisi spesifik.
     */
    public function create(Disposisi $disposisi)
    {
        // FIX: Menggunakan Route Model Binding untuk mendapatkan SATU objek disposisi
        return view('agenda.create', compact('disposisi'));
    }

    public function createnew()
    {
        $disposisi = Disposisi::all();
        return view('agenda.new', compact('disposisi'));
    }

    /**
     * Menyimpan agenda baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'disposisi_id' => 'required|exists:disposisi,id|unique:agenda,disposisi_id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kegiatan' => 'required|string',
            'tempat' => 'required|string',
            'pejabat' => 'required|string',
            'keterangan' => 'nullable|string', // Sebaiknya nullable agar tidak wajib
        ]);

        Agenda::create($request->all());

        // FIX: Redirect yang benar dengan pesan sukses
        return redirect()->route('agenda.index')->with('sukses', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit agenda.
     */
    public function edit(Agenda $agenda)
    {
        return view('agenda.edit', compact('agenda'));
    }

    /**
     * Memperbarui data agenda di database.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'tanggal' => 'required|date', // <-- PASTIKAN VALIDASI INI ADA
            'kegiatan' => 'required|string',
            'tempat' => 'required|string',
            'pejabat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $agenda->update($request->all());

        return redirect()->route('agenda.index')->with('sukses', 'Agenda berhasil diperbarui.');
    }

    /**
     * Menghapus agenda dari database.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')->with('sukses', 'Agenda berhasil dihapus.');
    }

    /**
     * Menyiapkan data untuk dicetak.
     */
    public function cetak()
    {
        $agendas = Agenda::whereDate('created_at', today())->get();
        return view('agenda.cetak', compact('agendas'));
    }

}

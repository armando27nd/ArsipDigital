<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';
    protected $primaryKey = 'id_sk';

    protected $fillable = [
        'kode_klasifikasi',
        'isi_ringkasan',
        'nama_surat',
        'no_surat',
        'asal',
        'tanggal',
        'file',
        'keterangan',
    ];


}

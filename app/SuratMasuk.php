<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    protected $primaryKey = 'id_sm';

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

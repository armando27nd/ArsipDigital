<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User; // Tambahkan ini
use App\Agenda; // Tambahkan ini

class Disposisi extends Model
{
    protected $table = 'disposisi';

    protected $fillable = [
        'user_id', 'admin_id', 'no_registrasi', 'tanggal', 'perihal',
        'no_dan_tanggal', 'asal', 'file_surat', 'catatan', 'status',
        'instruksi_admin', 'diteruskan', 'waktu_instruksi_admin', 'index_kartu',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_instruksi_admin' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function agenda()
    {
        return $this->hasOne(Agenda::class, 'disposisi_id');
    }
}

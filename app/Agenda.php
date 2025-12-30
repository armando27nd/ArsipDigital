<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Disposisi; // Tambahkan ini

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $primaryKey = 'id';
    protected $fillable = [
        'disposisi_id',
        'jam',
        'tanggal',
        'kegiatan',
        'tempat',
        'pejabat',
        'keterangan',
    ];

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class);
    }
}

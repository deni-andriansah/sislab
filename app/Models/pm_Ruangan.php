<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pm_Ruangan extends Model
{
    use HasFactory;
    protected $fillable = ['id','penanggungjawab','instansi','jenis_kegiatan','id_ruangan','tanggal_peminjaman','tanggal_pengembalian','keterangan','cover'];
    public $timestamps = true;

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function deleteImage(){
        if($this->cover && file_exists(public_path('images/pm_ruangan' . $this->cover))){
            return unlink(public_path('images/pm_ruangan' . $this->cover));
        }
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pm_Barang extends Model
{
    use HasFactory;
    protected $fillable = ['id','code_peminjaman','id_angota','jenis_kegitan','id_barang','id_ruangan','tanggal_peminjaman','waktu_pengerjaan','cover'];
    public $timestamps = true;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function l_barang()
    {
        return $this->hasMany(l_barang::class, 'id_pm_barang');
    }

    public function deleteImage(){
        if($this->cover && file_exists(public_path('images/pm_barang' . $this->cover))){
            return unlink(public_path('images/pm_barang' . $this->cover));
        }
    }


}

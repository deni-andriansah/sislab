<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anggota extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama_peminjam','email','no_telepon','instansi_lembaga'];
    public $timestamps = true;

    public function pm_barang()
    {
        return $this->hasMany(pm_barang::class, 'id_anggota');
    }
}

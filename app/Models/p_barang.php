<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class p_barang extends Model
{
    use HasFactory;
    protected $fillable = ['id','id_pm_barang','nama_pengembali','tanggal_pengembalian','keterangan'];
    public $timestamps = true;

    public function pm_barang()
    {
        return $this->belongsTo(pm_barang::class, 'id_pm_barang');
    }
}

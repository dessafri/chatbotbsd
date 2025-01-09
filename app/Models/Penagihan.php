<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penagihan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_order',
        'nama_customer',
        'nomor_handphone',
        'nilai_faktur',
        'piutang',
        'status',
        'nomorfaktur',
        'pembayaran',
        'waktu_upload',
        'waktu_kirim',
        'kode_cabang',
        'bukti_faktur'
    ];

    public $timestamps = true;
}

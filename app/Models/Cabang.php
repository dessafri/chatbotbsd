<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    // Define the fillable fields
    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'nomor_rekening',
        'nama_rekening',
        'kode_bank',
    ];

    // Disable the timestamps if they are not needed
    public $timestamps = true;
}

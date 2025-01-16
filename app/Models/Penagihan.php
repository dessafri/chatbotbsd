<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penagihan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function logBuktiFaktur()
    {
        return $this->hasMany(LogBuktiFaktur::class, 'nohandphone', 'nohandphone');
    }

    // Change from non-static to static
    public static function getTotalNilaiPenagihan()
    {
        return self::where('status', 1)->sum('nilai_faktur');
    }

    public static function getCountDeliverPenagihan()
    {
        return self::where('status', 1)->count('id');
    }

    public static function getCountPenagihan()
    {
        return self::count('id');
    }

    public static function getCountNotDeliverPenagihan()
    {
        return self::where('status', 0)->count('id');
    }
}

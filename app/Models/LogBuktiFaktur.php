<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBuktiFaktur extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_bukti_fakturs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nohandphone',
        'id_penagihan',
        'access_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id_penagihan' => 'integer',
    ];

    public function logBuktiFaktur()
    {
        return $this->hasMany(LogBuktiFaktur::class, 'nohandphone', 'nohandphone');
    }
}

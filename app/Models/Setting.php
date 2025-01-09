<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    // Define the fillable fields
    protected $fillable = [
        'key',
        'value',
    ];

    // Disable the timestamps if they are not needed
    public $timestamps = true;
}

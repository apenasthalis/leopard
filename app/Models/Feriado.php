<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    use HasFactory;

    protected $table = 'tb_feriado';
    public $timestamps = false;



    protected $fillable = [
        'cd_feriado',
        'dt_feriado',
        'ds_feriado',
        'tempo'
    ];
 
}

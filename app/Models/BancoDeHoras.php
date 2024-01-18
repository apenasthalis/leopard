<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancoDeHoras extends Model
{
    use HasFactory;


    protected $table = 'tb_banco_horas';
    protected $primaryKey = 'cd_banco_horas';
    public $timestamps = false;



    protected $fillable = [
        'cd_banco_horas',
        'nu_mes',
        'horas',
        'horastosegundos',
        'cd_funcionario',
        'nu_ano'
    ];
 

    
}

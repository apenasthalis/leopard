<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justificativa extends Model
{
    use HasFactory;

    protected $table = 'tb_justificativa';
    public $timestamps = false;
    protected $primaryKey = 'cd_funcionario';



    protected $fillable = [
        'cd_justificativa',
        'dt_registro',
        'ts_registro',        
        'cd_funcionario',
        'ds_justificativa',
        'img',
        'bo_aceito'
    ];
 
}

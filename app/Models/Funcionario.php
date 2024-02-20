<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;


    protected $table = 'tb_funcionario';
    public $timestamps = false;
    protected $primaryKey = 'cd_funcionario';

    
    protected $fillable = [
        'cd_funcionario',
        'no_funcionario',
        'nu_cpf',
        'tb_grade_cd_grade',
        'tb_carga_horaria_cd_cargahoraria',
        'vl_salario',
        'ds_endereco',
        'ponto_apartir_mes',
        'bo_ativo',
        'ponto_apartir_ano', 
        'dt_demissao',
        'dt_admissao'
    ];

}

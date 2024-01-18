<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use  HasFactory;

    protected $table = 'tb_usuario';
    public $timestamps = false;



    protected $fillable = [
        'cd_usuario',
        'cd_funcionario',
        'login',
        'senha',
        'email'
    ];
 
}

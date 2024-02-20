<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $usuarios = Funcionario::where('bo_ativo', 1)->get();

        // $nomes =[];

        // foreach ($usuarios as $usuario){
        //     $nomes[] = $usuario->no_funcionario;
        // }


        return $usuarios;

    }


    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }


    public function update(Request $request, string $id)
    {
    }

    public function destroy($id)
    {
        $usuario = Funcionario::where('cd_funcionario', $id)->first();

        $usuario->update(['bo_ativo' => 0]);

        return $usuario;
    }

}

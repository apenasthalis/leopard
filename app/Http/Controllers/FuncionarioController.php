<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $usuarios = Funcionario::where('bo_ativo', 1)->get();
        return $usuarios;

    }


    public function store(Request $request)
    {
        
        $request->validate([
            'nome' => 'required|string',
            // 'cpf' => 'required|string',
            'dataAdmissao' => 'required|date',
            'email' => 'required|email',
            'senha' => 'required|string',
            // 'podeBaterForaDaRede' => 'boolean',
            // 'imagem' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        
        $nome = $request->input('nome');
        $cpf = $request->input('cpf');
        $dataAdmissao = $request->input('dataAdmissao');
        $email = $request->input('email');
        $senha = md5($request->input('senha'));
        $podeBaterForaDaRede = $request->input('podeBaterForaDaRede');

        if ($request->hasFile('imagem')) {
            $nomeOriginal = $request->file('imagem')->getClientOriginalName();
            $nomeLimpo = time() . '_' . str_replace(' ', '_', $nomeOriginal);

            $imagemPath = $request->file('imagem')->storeAs('public/imagens', $nomeLimpo);

            $imagemPath = str_replace('public', 'storage', $imagemPath);
        } else {
            $imagemPath = null;
        }


        $numero = 1;


       $funcionario = Funcionario::Create([
            'no_funcionario' => $nome,
            'nu_cpf' => $cpf,
            'tb_cargahoraria_cd_cargahoraria' => $numero,
            'tb_grade_cd_grade' => '1',
            'dt_admissao' => $dataAdmissao,
            'bo_ativo' => 1,
            'ds_endereco' => "",
            'ponto_apartir_mes' => 03,
            'ponto_apartir_ano' => 2024,
            'imagem_path' => $imagemPath,
        ]);

        $cd_funcionario = $funcionario->cd_funcionario;


        Usuario::Create([
            'cd_funcionario' => $cd_funcionario,
            'login' => $nome,
            'senha' => $senha,
            'email' => $email, 


        ]);


    }



        

    public function show(string $id)
    {
        $usuario = Funcionario::where('cd_funcionario', $id)->get();
        return $usuario;
        
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

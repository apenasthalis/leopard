<?php

namespace App\Http\Controllers;

use App\Models\CargaHorariaFuncionario;
use App\Models\Justificativa;
use Illuminate\Http\Request;

class JustificativaController extends Controller
{
    public function index()
{
    $faltas = Justificativa::join('tb_funcionario', 'tb_justificativa.cd_funcionario', '=', 'tb_funcionario.cd_funcionario')
            ->where('tb_justificativa.bo_aceito', 0)
            ->select('tb_justificativa.*', 'tb_funcionario.no_funcionario as nome_usuario')
            ->get();
    return $faltas;
}




    public function store(Request $request)
    {

        
        
        Justificativa::Create([
            'dt_registro' => $request->dia,
            'ts_registro' => $request->horario,
            'cd_funcionario' => $request->user_id,
            'ds_justificativa' => $request->justificativa,
            // 'img' =>$request->imagem,
            'bo_aceito' => 0,
        ]);


        // Acesse o arquivo enviado
        // if ($request->hasFile('arquivo')) {
        //     $arquivo = $request->file('arquivo');

        //     // Faça o que for necessário com o arquivo (salvar no disco, por exemplo)
        //     $arquivo->storeAs('pasta_destino', $arquivo->getClientOriginalName());
        // }

        // // Faça o que for necessário com os dados (salvar no banco de dados, por exemplo)

        // // Retorne a resposta adequada
        // return response()->json(['message' => 'Dados recebidos com sucesso']);
    }

    public function show(string $id)
    {
    }


    public function update(Request $request){
        $operacao = $request->operacao;
        $data = $request->dt_registro;
        $id = $request->cd_funcionario;



        $usuarios = Justificativa::where('cd_funcionario', $id )
        ->where('dt_registro', $data)
        ->first();

        if ($usuarios) {
                if ($operacao == "aceitar") {
                    $usuarios->update(['bo_aceito' => 1]);


                $calcular = new CargaHorariaFuncionarioController();
                $resultado = $calcular->falta($request);
                return $resultado;
    
                } 
                
                if ($operacao == "rejeitar") {
                    $usuarios->update(['bo_aceito' => 0]);
                }
            

        }





    }

    public function destroy(string $id)
    {
    }
}

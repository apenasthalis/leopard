<?php

namespace App\Http\Controllers;

use App\Models\CargaHorariaFuncionario;
use Illuminate\Http\Request;

class CargaHorariaFuncionarioController extends Controller
{
    public function index()
    {
        return CargaHorariaFuncionario::all();
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $dt_registro = isset($data['dt_registro']) ? $data['dt_registro'] : null;
        $ts_registro = isset($data['ts_registro']) ? $data['ts_registro'] : null;

        $cargaHoraria = new CargaHorariaFuncionario([
            'dt_registro' => $dt_registro,
            'ts_registro' => $ts_registro,
            'tb_funcionario_cd_funcionario' => $data['tb_funcionario_cd_funcionario'],
        ]);

        $cargaHoraria->save();

        return response()->json(['message' => 'Dados criados com sucesso']);
    }

    public function show( $id, $ano, $mes)
    {
        $calcular = new CargaHorariaFuncionario();
        $resultado = $calcular->HorasPorMes($id, $ano, $mes);
        return $resultado;
    }


    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
// $somasPorDiaEmSegundos = [];

//         foreach ($diferencasPorDia as $data => $diferencas) {
//             $totalSegundos = 0;

//             foreach ($diferencas as $diferenca) {
//                 $totalSegundos += $diferenca->s + $diferenca->i * 60 + $diferenca->h * 3600;
//             }

//             $somasPorDiaEmSegundos[$data] = $totalSegundos;
//         }

//         dd($);




  // $somasPorDia = [];

        // foreach ($diferencasPorDia as $data => $diferencas) {
        //     $soma = new DateTime('00:00:00'); 

        //     foreach ($diferencas as $diferenca) {
        //         $soma->add($diferenca);
        //     }

        //     $somasPorDia[$data] = $soma->format('H:i:s');
        // }
        // dd($somasPorDia);
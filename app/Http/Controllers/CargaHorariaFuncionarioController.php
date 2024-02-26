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
        $numRegistrosHoje = CargaHorariaFuncionario::where('tb_funcionario_cd_funcionario', $request->id)
            ->whereDate('dt_registro', now()->toDateString())
            ->count();

        if ($numRegistrosHoje < 4) {
            CargaHorariaFuncionario::create([
                'dt_registro' => $request->data,
                'ts_registro' => $request->horario,
                'tb_funcionario_cd_funcionario' => $request->id,
                // 'img' =>$request->imagem,
            ]);

            return response()->json(['message' => 'Registro criado com sucesso'], 200);
        } else {
            return response()->json(['message' => 'Limite diário atingido'], 403);
        }
    }

    public function show($id, $ano, $mes)
    {
        $calcular = new CargaHorariaFuncionario();
        $resultado = $calcular->HorasPorMes($id, $ano, $mes);
        return $resultado;
    }


    public function update(Request $request, string $id)
    {
    }

    public function falta(Request $request)
    {
        $data1 = $request['dt_registro'];
        $id = $request['cd_funcionario'];
        $horario = $request['ts_registro'];

        // $registros = CargaHorariaFuncionario::where('tb_funcionario_cd_funcionario', $id)
        // ->where('dt_registro', $data1)
        // ->where('ts_registro', $horario)
        // ->first();


         CargaHorariaFuncionario::updateOrInsert([
            'dt_registro' => $data1,
            'ts_registro' => $horario,
            'tb_funcionario_cd_funcionario' => $id,
         ]);
}
}

// $registros = CargaHorariaFuncionario::where('tb_funcionario_cd_funcionario', $id)
//     ->where('dt_registro', $data1)
//     ->get();

// $alternarEntradaSaida = true;
// $horarios = [];

// foreach ($registros as $registro) {
//     $data = $registro->dt_registro;
//     $hora = $registro->ts_registro;

//     if ($alternarEntradaSaida) {
//         $horarios[$data][] = ['data' => $data, 'hora' => $hora, 'tipo' => 'entrada'];
//     } else {
//         $horarios[$data][] = ['data' => $data, 'hora' => $hora, 'tipo' => 'saida'];
//     }

//     $alternarEntradaSaida = !$alternarEntradaSaida;
// }

// $horariosNovos = [];

// foreach ($horarios as $data => $registrosDia) {
//     $numI = count($registrosDia);

//     if ($numI == 1) {

//         $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
//         $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
//         $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
//     }

//     if ($numI == 2) {

//         $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
//         $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
//     }

//     if ($numI == 3) {

//         $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
//     }



//     $horariosNovos[$data] = $registrosDia;
// }

// foreach ($horariosNovos as $data => $registrosDia) {
//     $registrosDia[0] = ['data' => $data, 'hora' => '08:00:00', 'tipo' => 'entrada'];
//     $registrosDia[1] = ['data' => $data, 'hora' => '12:00:00', 'tipo' => 'saída'];
//     $registrosDia[2] = ['data' => $data, 'hora' => '14:00:00', 'tipo' => 'entrada'];
//     $registrosDia[3] = ['data' => $data, 'hora' => '18:00:00', 'tipo' => 'saída'];

//     $horariosNovos[$data] = $registrosDia;
// }



// // Deleta os registros antigos do mesmo dia
// CargaHorariaFuncionario::where('tb_funcionario_cd_funcionario', $request->cd_funcionario)
//     ->whereDate('dt_registro', $data1)
//     ->delete();


// foreach ($horariosNovos as $horariosDia) {
//     foreach ($horariosDia as $horario) {
//         CargaHorariaFuncionario::create([
//             'dt_registro' => $horario['data'],
//             'ts_registro' => $horario['hora'],
//             'tb_funcionario_cd_funcionario' => $request->cd_funcionario,
//         ]);
//     }
// }
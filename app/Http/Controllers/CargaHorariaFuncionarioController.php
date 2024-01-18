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
    }

    public function show(string $id)
    {
        $calcular = new CargaHorariaFuncionario();
        $resultado = $calcular->HorasPorMes($id, 2024, 1);
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
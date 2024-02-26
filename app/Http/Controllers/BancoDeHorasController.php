<?php

namespace App\Http\Controllers;

use App\Models\BancoDeHoras;
use Illuminate\Http\Request;

class BancoDeHorasController extends Controller
{
    public function index()
    {
        return BancoDeHoras::all();

    }


    public function store(Request $request)
    {
        BancoDeHoras::create($request->all());

    }

    public function show(string $id)
    {
        $result = BancoDeHoras::where('cd_funcionario', $id)
            ->selectRaw('SUM(horastosegundos) as total_segundos')
            ->first();

        $totalSegundos = $result->total_segundos;
        $horas = ($totalSegundos / 3600);
        $minutos = (($totalSegundos % 3600) / 60);
        $segundos = $totalSegundos % 60;

        $resultadoFinal = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);

        return $resultadoFinal;
    }



    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}

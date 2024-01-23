<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BancoDeHoras;
use Illuminate\Database\Eloquent\Model;

class CargaHorariaFuncionario extends Model
{
    use HasFactory;

    protected $table = 'tb_cargahoraria_funcionario';
    protected $primaryKey = 'cd_cargahoraria_funcionario';
    public $timestamps = false;

    protected $fillable = [
        'cd_cargahoraria_funcionario',
        'dt_registro',
        'ts_registro',
        'tb_funcionario_cd_funcionario',
        'qt_update',
        'justificativa',
        'img',
        'bo_ativo',
        'dc_recusa'
    ];

    public function HorasPorMes($id, $ano, $mes)
    {

        $registros = CargaHorariaFuncionario::where('tb_funcionario_cd_funcionario', $id)
            ->whereYear('dt_registro', $ano)
            ->whereMonth('dt_registro', $mes)
            ->orderBy('dt_registro')
            ->orderBy('ts_registro')
            ->get();

        $horarios = ['entradas' => [], 'saidas' => []];
        $alternarEntradaSaida = true;

        foreach ($registros as $registro) {
            $data = $registro->dt_registro;
            $hora = $registro->ts_registro;

            if ($alternarEntradaSaida) {
                $horarios['entradas'][] = ['data' => $data, 'hora' => $hora];
            } else {
                $horarios['saidas'][] = ['data' => $data, 'hora' => $hora];
            }

            $alternarEntradaSaida = !$alternarEntradaSaida;
        }

        // dd($horarios);

        $numRegistros = count($horarios['entradas']);

        $diferencasPorDia = [];
        for ($i = 0; $i < $numRegistros; $i++) {

            $entrada = $horarios['entradas'][$i];
            $saida = $horarios['saidas'][$i];

            $dataEntrada = $entrada['data'];
            $horaEntrada = $entrada['hora'];

            $dataSaida = $saida['data'];
            $horaSaida = $saida['hora'];

            $inicio = new DateTime("$dataEntrada $horaEntrada");
            $fim = new DateTime("$dataSaida $horaSaida");

            $diferenca = $inicio->diff($fim);

            $dataFormatada = $inicio->format('Y-m-d');
            $diferencasPorDia[$dataFormatada][] = $diferenca;
        }

        $somasPorDiaEmSegundos = [];

        foreach ($diferencasPorDia as $data => $diferencas) {
            $totalSegundos = 0;

            foreach ($diferencas as $diferenca) {
                $totalSegundos += $diferenca->s + ($diferenca->i * 60) + ($diferenca->h * 3600);
            }

            $somasPorDiaEmSegundos[$data] = $totalSegundos;
        }

        // dd($somasPorDiaEmSegundos);

        function setPositive($value)
        {
            return ($value < 0 ? $value * -1 : $value);
        }

        function verifyHours($horas, $minutos, $segundos) {
            if ($horas <= 0) {
                $minutos;
                $segundos = $segundos * (-1);
            }
        }

        function segundosParaMinutos($totalSegundos)
        {
            $totalSegundos -= 28800;
            $horas = $totalSegundos / 3600;
            $minutos = ($totalSegundos % 3600) / 60;
            $segundos = $totalSegundos % 60;
            $formattedTime = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
            return ['totalSegundos' => $totalSegundos, 'formattedTime' => $formattedTime];
        }

        $somasPorDiaEmMinutos = [];
        $totalSegundosGlobal = 0;

        foreach ($somasPorDiaEmSegundos as $data => $totalSegundos) {
            $result = segundosParaMinutos($totalSegundos);
            $somasPorDiaEmMinutos[$data] = $result['formattedTime'];
            $totalSegundosGlobal += $result['totalSegundos'];
        }
        
        $horasTotais = $totalSegundosGlobal / 3600;
        $minutosTotais = ($totalSegundosGlobal % 3600) / 60;
        $segundosRestantes = $totalSegundosGlobal % 60;
        $resultadoFinal = sprintf('%02d:%02d:%02d', $horasTotais, $minutosTotais, $segundosRestantes);


        dd($somasPorDiaEmMinutos);
        // BancoDeHoras::updateOrCreate([
        //     'nu_mes' => $mes,
        //     'horas' => $resultadoFinal,
        //     'horastosegundos' =>$totalSegundosGlobal ,
        //     'cd_funcionario' => $id,
        //     'nu_ano' => $ano
        // ]);
}
}


    

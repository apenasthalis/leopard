<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

        // dd($saida);

        if (empty($diferencasPorDia)) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateKey = sprintf('%04d-%02d-%02d', $ano, $mes, $day);
                $diferencasPorDia[$dateKey][] = new DateInterval('PT0S'); // Adiciona um intervalo de 0 segundos
            }
        }


        $somasPorDiaEmSegundos = [];

        foreach ($diferencasPorDia as $data => $diferencas) {
            $totalSegundos = 0;

            foreach ($diferencas as $diferenca) {
                $totalSegundos += $diferenca->s + $diferenca->i * 60 + $diferenca->h * 3600;
            }

            $somasPorDiaEmSegundos[$data] = $totalSegundos;
        }

        function setPositive($value)
        {
            return ($value < 0 ? $value * -1 : $value);
        }

        function segundosParaHoras($totalSegundos)
        {

            $totalSegundos -= 28800;

            $horas = $totalSegundos / 3600;
            $minutos = setPositive(($totalSegundos % 3600) / 60);
            $segundos = setPositive($totalSegundos % 60);

            return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
        }

        $somasPorDiaEmHoras = [];

        foreach ($somasPorDiaEmSegundos as $data => $totalSegundos) {
            $somasPorDiaEmHoras[$data] = segundosParaHoras($totalSegundos);
        }

        dd($somasPorDiaEmHoras);

    }
}



    

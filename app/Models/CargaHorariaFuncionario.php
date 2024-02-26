<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BancoDeHoras;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\error;

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

        // $horarios = ['entradas' => [], 'saidas' => []];
        $alternarEntradaSaida = true;
        $horarios = [];

        foreach ($registros as $registro) {
            $data = $registro->dt_registro;
            $hora = $registro->ts_registro;

            if ($alternarEntradaSaida) {
                $horarios[$data][] = ['data' => $data, 'hora' => $hora, 'tipo' => 'entrada'];
            } else {
                $horarios[$data][] = ['data' => $data, 'hora' => $hora, 'tipo' => 'saida'];
            }

            $alternarEntradaSaida = !$alternarEntradaSaida;
        }


       

        foreach ($horarios as $data => $registrosDia){
            $numI = count($registrosDia);

            if ($numI == 1) {

                $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'saida'];
                $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
                $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'saida'];

            }

                if($numI == 2){

                $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'entrada'];
                $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'saida'];

                }

            if ($numI == 3) {

                $registrosDia[] = ['data' => $data, 'hora' => '00:00:00', 'tipo' => 'saida'];

            } 

           

            $horariosNovos[$data] = $registrosDia;

        }
    
        $diferencasPorDia = [];
        foreach ($horariosNovos as $data => $eventos) {
            $numEventos = count($eventos);
            // $numEventos = 30;

            for ($i = 0; $i < $numEventos; $i += 2) {
                if (isset($eventos[$i]) && isset($eventos[$i + 1])) {
                    $entrada = $eventos[$i];
                    $saida = $eventos[$i + 1];

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
            }
        }


        $somasPorDiaEmSegundos = [];

        foreach ($diferencasPorDia as $data => $diferencas) {
            $totalSegundos = 0;

            foreach ($diferencas as $diferenca) {
                $totalSegundos += $diferenca->s + ($diferenca->i * 60) + ($diferenca->h * 3600);
            }

            $somasPorDiaEmSegundos[$data] = $totalSegundos;
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

        $horas_por_dia = [];

        foreach ($somasPorDiaEmSegundos as $dia => $segundos1) {


                $horas = $segundos1 / 3600;
                $minutos = ($segundos1 % 3600) / 60;
                $segundosRestantes = $segundos1 % 60;

                $horas_por_dia[$dia] = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundosRestantes);
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



        BancoDeHoras::updateOrInsert(
            [
                'nu_mes' => $mes,
                'cd_funcionario' => $id,
                'nu_ano' => $ano
            ],
            [
                'horas' => $resultadoFinal,
                'horastosegundos' => $totalSegundosGlobal
            ]
        );


        $horarioString = json_encode($horariosNovos);
        return ['resultado' => $resultadoFinal, 'horarios' => $horarioString, 'segundos' => $somasPorDiaEmSegundos];
}
}


    

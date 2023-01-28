<?php

use Carbon\Carbon;

class CoordenadorFaltaAtrasoController extends ApiCoreController
{

    public function getAulasQuadroHorario()
    {
        $turmaId = $this->getRequest()->turmaId;
        $dataFaltaAtraso = $this->getRequest()->dataFaltaAtraso;
        $professorId = $this->getRequest()->professorId;

        if (is_numeric($turmaId) && is_numeric($professorId) && !empty($dataFaltaAtraso)) {
//            var_dump($dataFaltaAtraso);
//            var_dump(Carbon::createFromFormat('d/m/Y', $dataFaltaAtraso));
            $diaSemana =  Carbon::createFromFormat('d/m/Y', $dataFaltaAtraso)->dayOfWeek;
//            var_dump($diaSemana);
            $diaSemanaConvertido = $this->converterDiaSemanaQuadroHorario($diaSemana);

            $diaSemanaConvertido = 5;
            $quadroHorarioArray = Portabilis_Business_Professor::quadroHorarioAlocado($turmaId, $professorId, $diaSemanaConvertido);

//            echo '<pre>';
//            var_dump($quadroHorarioArray);
//            exit;
            $adapterQuadroHorario = [];

            foreach ($quadroHorarioArray as $quadroHorario) {
                $adapterQuadroHorario[] = [
                  'horario' =>  substr($quadroHorario['hora_inicial'], 0, 5) . ' - ' .  substr($quadroHorario['hora_final'], 0, 5),
                  'componenteCurricular' => $quadroHorario['componente_abreviatura'],
                  'qtdAulas' => (!empty($quadroHorario['qtd_aulas']) ? $quadroHorario['qtd_aulas'] : 1),
                ];
            }


            return ['registros' => $adapterQuadroHorario];

        }

        return [];
    }

    private function converterDiaSemanaQuadroHorario(int $diaSemana)
    {
        $arrDiasSemanaIeducar = [
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 7,
        ];

        return $arrDiasSemanaIeducar[$diaSemana];
    }

    public function Gerar()
    {
        if ($this->isRequestFor('get', 'getAulasQuadroHorario')) {
            $this->appendResponse($this->getAulasQuadroHorario());
        }
    }
}

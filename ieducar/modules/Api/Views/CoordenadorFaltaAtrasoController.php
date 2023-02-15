<?php

use Carbon\Carbon;

class CoordenadorFaltaAtrasoController extends ApiCoreController
{

    public function getAulasQuadroHorario()
    {
        $turmaId = $this->getRequest()->turmaId;
        $dataFaltaAtraso = $this->getRequest()->dataFaltaAtraso;
        $professorId = $this->getRequest()->professorId;
        $serieId = $this->getRequest()->serieId;
        $tipo = $this->getRequest()->tipo;

        if ($tipo == '2' && is_numeric($serieId) && is_numeric($turmaId) && is_numeric($professorId) && !empty($dataFaltaAtraso)) {
            $obj = new clsPmieducarSerie();
            $tipoPresenca = $obj->tipoPresencaRegraAvaliacao($serieId);
            $anosFinais = ($tipoPresenca == 2);

            $diaSemana =  Carbon::createFromFormat('d/m/Y', $dataFaltaAtraso)->dayOfWeek;
            $diaSemanaConvertido = $this->converterDiaSemanaQuadroHorario($diaSemana);

            $quadroHorarioArray = Portabilis_Business_Professor::quadroHorarioAlocado($turmaId, $professorId, $diaSemanaConvertido);

            $adapterQuadroHorario = [];
            $exibirAulas = false;
            foreach ($quadroHorarioArray as $quadroHorario) {
                if ((!$anosFinais && dbBool($quadroHorario['registra_diario_individual'])) || $anosFinais) {
                    $exibirAulas = true;
                    $adapterQuadroHorario[] = [
                        'ref_cod_quadro_horario_horarios' => $quadroHorario['ref_cod_quadro_horario_horarios'],
                        'horario' =>  substr($quadroHorario['hora_inicial'], 0, 5) . ' - ' .  substr($quadroHorario['hora_final'], 0, 5),
                        'componenteCurricular' => $quadroHorario['componente_abreviatura'],
                        'qtdAulas' => (!empty($quadroHorario['qtd_aulas']) ? $quadroHorario['qtd_aulas'] : 1),
                    ];
                }

            }

            return ['exibirAulas' => $exibirAulas,
                    'registros' => $adapterQuadroHorario];
        }

        return [];
    }

    public function verificaFaltasAtrasoByFrequencia()
    {
        $turmaId = $this->getRequest()->turmaId;
        $dataFaltaAtraso = $this->getRequest()->dataFaltaAtraso;
        $userId = \Illuminate\Support\Facades\Auth::id();

        if (is_numeric($turmaId) && is_numeric($userId) && !empty($dataFaltaAtraso)) {
            $clsInstituicao = new clsPmieducarInstituicao();
            $instituicao = $clsInstituicao->primeiraAtiva();

            $dataFalta = Portabilis_Date_Utils::brToPgSQL($dataFaltaAtraso);

            $objFaltaAtraso = new clsPmieducarFaltaAtraso(
                null,
                null,
                $instituicao['cod_instituicao'],
                null,
                null,
                $userId,
                2,
                $dataFalta,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $turmaId,
                null,
            );

            return $objFaltaAtraso->getFaltasAtrasoForFrequencia();
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
        }else if ($this->isRequestFor('get', 'verificaFaltasAtrasoByFrequencia')) {
            $this->appendResponse($this->verificaFaltasAtrasoByFrequencia());
        }
    }
}

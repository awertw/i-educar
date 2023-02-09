<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

return new class extends clsCadastro {
    public $pessoa_logada;

    public $cod_falta_atraso;
    public $ref_cod_escola;
    public $ref_cod_instituicao;
    public $ref_usuario_exc;
    public $ref_usuario_cad;
    public $ref_cod_servidor;
    public $ref_cod_professor_componente;
    public $tipo;
    public $tipo_edit;
    public $data_falta_atraso;
    public $qtd_horas;
    public $qtd_min;
    public $justificada;
    public $data_cadastro;
    public $data_exclusao;
    public $ativo;
    public $ref_cod_servidor_funcao;
    public $ref_cod_curso;
    public $ref_cod_serie;
    public $ref_cod_turma;
    public $ref_cod_componente_curricular;
    public $aulas;
    public $observacao;
    public $ano;

    public function Inicializar()
    {
        $retorno = 'Novo';

        $this->cod_falta_atraso    = $_GET['cod_falta_atraso'];
        $this->ref_cod_professor_componente    = $_GET['ref_cod_professor_componente'];
        $this->ref_cod_escola      = $_GET['ref_cod_escola'];
        $this->ref_cod_instituicao = 1; //Padrão, só existe 1 instituição por base

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(
            635,
            $this->pessoa_logada,
            7,
            'educar_coordenacao_falta_atraso_professor_lst.php'
        );

        if (is_numeric($this->cod_falta_atraso)) {
            $obj = new clsPmieducarFaltaAtraso($this->cod_falta_atraso);
            $registro  = $obj->detalhe();

            if ($registro) {
                // passa todos os valores obtidos no registro para atributos do objeto
                foreach ($registro as $campo => $val) {
                    $this->$campo = $val;
                }

                $this->data_falta_atraso = dataFromPgToBr($this->data_falta_atraso);

                $diaSemana =  Carbon::createFromFormat('d/m/Y', $this->data_falta_atraso)->dayOfWeek;
                $diaSemanaConvertido = $this->converterDiaSemanaQuadroHorario($diaSemana);

                $quadroHorarioArray = Portabilis_Business_Professor::quadroHorarioAlocado($registro['ref_cod_turma'], $registro['ref_cod_servidor'], $diaSemanaConvertido);
                $this->aulas = $obj->verificarFaltaAtrasoQuadroHorario($quadroHorarioArray);

                $obj_permissoes = new clsPermissoes();

                if ($obj_permissoes->permissao_excluir(635, $this->pessoa_logada, 7)) {
                    $this->fexcluir = true;
                }

                $retorno = 'Editar';
            }
        }

        $this->url_cancelar = 'educar_coordenacao_falta_atraso_professor_lst.php';

        $this->nome_url_cancelar = 'Cancelar';

        $nomeMenu = $retorno == 'Editar' ? $retorno : 'Cadastrar';

        $this->breadcrumb($nomeMenu . ' Falta Atraso', [
            url('intranet/educar_coordenacao_falta_atraso_professor_lst.php') => 'Coordenação',
        ]);

        return $retorno;
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
        // Primary keys
        $this->campoOculto('cod_falta_atraso', $this->cod_falta_atraso);

        if (empty($this->ano)) {
//            $this->ano = date('Y');
            $this->ano = '2022';
        }

        $disabled = false;
        if (isset($_GET['cod_falta_atraso']) && !empty($_GET['cod_falta_atraso'])) {
            $this->id = $_GET['cod_falta_atraso'];
            $disabled = true;
        }

        $this->campoOculto('id', $this->id);
        $this->campoOculto('ano', $this->ano);

        if (!empty($this->id)) {
            $this->campoOculto('tipo_edit', $this->tipo);
        }
        $this->inputsHelper()->dynamic('instituicao', ['value' => $this->ref_cod_instituicao, 'disabled' => $disabled]);
        $this->inputsHelper()->dynamic('escola', ['value' => $this->ref_cod_escola, 'disabled' => $disabled]);
        $this->inputsHelper()->dynamic('curso', ['value' => $this->ref_cod_curso, 'disabled' => $disabled]);
        $this->inputsHelper()->dynamic('serie', ['value' => $this->ref_cod_serie, 'disabled' => $disabled]);
        $this->inputsHelper()->dynamic('turma', ['required' => true, 'ano' => $this->ano, 'disabled' => $disabled]);
        $this->inputsHelper()->dynamic('professorComponente', ['required' => true, 'value' => $this->ref_cod_servidor, 'disabled' => $disabled]);

        // Text
        // @todo CoreExt_Enum
        $opcoes = [
            '' => 'Selecione',
            1  => 'Atraso',
            2  => 'Falta'
        ];

        $this->campoLista('tipo', 'Tipo', $opcoes, $this->tipo, '', false,'', '', $disabled);

        // Data
        $this->campoData('data_falta_atraso', 'Dia', $this->data_falta_atraso, true, '', false, '', $disabled);

        $this->campoNumero('qtd_horas', 'Quantidade de Horas', $this->qtd_horas, 30, 255, false, '', '', false, false, false, $disabled);
        $this->campoNumero('qtd_min', 'Quantidade de Minutos', $this->qtd_min, 30, 255, false, '', '', false, false, false, $disabled);

        $opcoes = [
            '' => 'Selecione',
            0  => 'Sim',
            1  => 'Não'
        ];

        $this->campoLista('justificada', 'Justificada', $opcoes, $this->justificada, '', false,'', '', false, $disabled);

        $this->campoMemo('observacao', 'Observação', $this->observacao, 52, 5, false);

        $quadroHorarioAulas = '';

        if (!empty($this->aulas)) {
            foreach ($this->aulas as $aula) {
                $quadroHorarioAulas .= '<table cellspacing="0" cellpadding="0" border="0">';
                $quadroHorarioAulas .= '<tr align="left"><td><p><td class="tableDetalheLinhaSeparador" colspan="3"></td><tr><td><div class="scroll"><table class="tableDetalhe tableDetalheMobile" width="100%"><tr class="tableHeader">';
                $quadroHorarioAulas .= '  <th><span style="display: block; float: left; width: auto; font-weight: bold">' . "Horário" . '</span></th>';
                $quadroHorarioAulas .= '  <th><span style="display: block; float: left; width: auto; font-weight: bold">' . "Componente Curricular" . '</span></th>';

                for ($qtd = 1; $qtd <= $aula['qtdAulas']; $qtd++) {
                    $quadroHorarioAulas .= '  <th><span style="display: block; float: left; width: auto; font-weight: bold"> Aula' . $qtd . '</span></th>';
                }

                $quadroHorarioAulas .= '</tr>';
                $quadroHorarioAulas .= '<tr><td class="tableDetalheLinhaSeparador" colspan="3"></td></tr>';

                $quadroHorarioAulas .= ' <td class="sizeFont colorFont"><p>' . $aula['horario'] . '</p></td>';
                $quadroHorarioAulas .= ' <td class="sizeFont colorFont"><p>' . $aula['componenteCurricular'] . '</p></td>';

                for ($qtd = 1; $qtd <= $aula['qtdAulas']; $qtd++) {
                    $checked = (in_array($qtd, $aula['aulasFaltou']) ? 'checked' : '');

                    $quadroHorarioAulas .= '<td class="sizeFont colorFont" >';
                    $quadroHorarioAulas .= "<input type='checkbox' name='aulas[{$aula['ref_cod_quadro_horario_horarios']}][]' $checked value='{$qtd}''>";
                    $quadroHorarioAulas .= '</td>';
                }

                $quadroHorarioAulas .= ' </tr></p></td></tr>';
                $quadroHorarioAulas .= ' </table>';
            }
        }


        $this->campoRotulo('aulas_lista_', 'Aulas', "<div id='aulas'>$quadroHorarioAulas</div>");
    }

    public function Novo()
    {
        $this->data_falta_atraso = Portabilis_Date_Utils::brToPgSQL($this->data_falta_atraso);

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(
            635,
            $this->pessoa_logada,
            7,
            sprintf(
                'educar_falta_atraso_lst.php?ref_cod_servidor=%d&ref_cod_instituicao=%d',
                $this->ref_cod_professor_componente,
                $this->ref_cod_instituicao
            )
        );

        if ($this->tipo == 1) {
            $obj = new clsPmieducarFaltaAtraso(
                null,
                $this->ref_cod_escola,
                $this->ref_cod_instituicao,
                null,
                $this->pessoa_logada,
                $this->ref_cod_professor_componente,
                $this->tipo,
                $this->data_falta_atraso,
                $this->qtd_horas,
                $this->qtd_min,
                $this->justificada,
                null,
                null,
                1,
                $this->ref_cod_servidor_funcao
            );
        } elseif ($this->tipo == 2) {
            $db = new clsBanco();
            $dia_semana = $db->CampoUnico(sprintf('(SELECT EXTRACT (DOW FROM date \'%s\') + 1 )', $this->data_falta_atraso));

            $obj_ser = new clsPmieducarServidor();
            $horas   = $obj_ser->qtdhoras($this->ref_cod_professor_componente, $this->ref_cod_escola, $this->ref_cod_instituicao, $dia_semana);

            if ($horas) {
                $funcoes = $this->getFuncoesServidor($this->ref_cod_componente_curricular);
                $this->ref_cod_servidor_funcao = $funcoes['cod_servidor_funcao'];

                $obj = new clsPmieducarFaltaAtraso(
                    null,
                    $this->ref_cod_escola,
                    $this->ref_cod_instituicao,
                    null,
                    $this->pessoa_logada,
                    $this->ref_cod_professor_componente,
                    $this->tipo,
                    $this->data_falta_atraso,
                    $horas['hora'],
                    $horas['min'],
                    $this->justificada,
                    null,
                    null,
                    1,
                    $this->ref_cod_servidor_funcao,
                    $this->ref_cod_curso,
                    $this->ref_cod_serie,
                    $this->ref_cod_turma,
                    null,
                    $this->observacao,
                    $this->ano
                );
            }
        }

        $cadastrou = $obj->cadastra($this->aulas);

        if ($cadastrou) {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br />';
            $this->simpleRedirect('educar_coordenacao_falta_atraso_professor_lst.php');
        }

        $this->mensagem = 'Cadastro não realizado.<br />';

        return false;
    }

    public function Editar()
    {
        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(
            635,
            $this->pessoa_logada,
            7,
            sprintf(
                'educar_falta_atraso_lst.php?ref_cod_servidor=%d&ref_cod_instituicao=%d',
                $this->ref_cod_professor_componente,
                $this->ref_cod_instituicao
            )
        );

        if (!empty($this->tipo_edit)) {
            $this->tipo = $this->tipo_edit;
        }

        $this->data_falta_atraso = Portabilis_Date_Utils::brToPgSQL($this->data_falta_atraso);
        if ($this->tipo == 1) {
            $obj = new clsPmieducarFaltaAtraso(
                $this->cod_falta_atraso,
                $this->ref_cod_escola,
                $this->ref_cod_instituicao,
                $this->pessoa_logada,
                null,
                $this->ref_cod_professor_componente,
                $this->tipo,
                $this->data_falta_atraso,
                $this->qtd_horas,
                $this->qtd_min,
                $this->justificada,
                null,
                null,
                1,
                $this->ref_cod_servidor_funcao
            );
        } elseif ($this->tipo == 2) {
            $obj_ser = new clsPmieducarServidor(
                $this->ref_cod_servidor,
                null,
                null,
                null,
                null,
                null,
                1,
                $this->ref_cod_instituicao
            );

            $det_ser = $obj_ser->detalhe();
            $horas   = floor($det_ser['carga_horaria']);
            $minutos = ($det_ser['carga_horaria'] - $horas) * 60;
            $obj = new clsPmieducarFaltaAtraso(
                $this->cod_falta_atraso,
                $this->ref_cod_escola,
                $this->ref_cod_instituicao,
                $this->pessoa_logada,
                null,
                $this->ref_cod_professor_componente,
                $this->tipo,
                $this->data_falta_atraso,
                $horas,
                $minutos,
                $this->justificada,
                null,
                null,
                1,
                $this->ref_cod_servidor_funcao,
                null,
                null,
                null,
                null,
                $this->observacao
            );
        }

        $editou = $obj->edita($this->aulas);
        if ($editou) {
            $this->mensagem .= 'Edição efetuada com sucesso.<br />';
            $this->simpleRedirect('educar_coordenacao_falta_atraso_professor_lst.php');
        }

        $this->mensagem = 'Edição não realizada.<br />';

        return false;
    }

    public function Excluir()
    {
        $this->data_falta_atraso = Portabilis_Date_Utils::brToPgSQL($this->data_falta_atraso);
        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_excluir(
            635,
            $this->pessoa_logada,
            7,
            sprintf(
                'educar_professores_coordenacao_falta_atraso_professor_lst.php?ref_cod_servidor=%d&ref_cod_instituicao=%d',
                $this->ref_cod_professor_componente,
                $this->ref_cod_instituicao
            )
        );

        $obj = new clsPmieducarFaltaAtraso(
            $this->cod_falta_atraso,
            $this->ref_cod_escola,
            $this->ref_ref_cod_instituicao,
            $this->pessoa_logada,
            $this->pessoa_logada,
            $this->ref_cod_professor_componente,
            $this->tipo,
            $this->data_falta_atraso,
            $this->qtd_horas,
            $this->qtd_min,
            $this->justificada,
            $this->data_cadastro,
            $this->data_exclusao,
            0
        );
        $excluiu = $obj->excluir();
        if ($excluiu) {
            $this->mensagem .= 'Exclusão efetuada com sucesso.<br />';
            $this->simpleRedirect('educar_coordenacao_falta_atraso_professor_lst.php');
        }
        $this->mensagem = 'Exclusão não realizada.<br>';

        return false;
    }

    private function getFuncoesServidor($codServidor)
    {
        return DB::table('pmieducar.servidor_funcao')
            ->select(DB::raw('cod_servidor_funcao, nm_funcao || coalesce( \' - \' || matricula, \'\') as funcao_matricula'))
            ->join('pmieducar.funcao', 'funcao.cod_funcao', 'servidor_funcao.ref_cod_funcao')
            ->where([['servidor_funcao.ref_cod_servidor', $codServidor]])
            ->orderBy('matricula', 'asc')
            ->get()
            ->pluck('funcao_matricula', 'cod_servidor_funcao')
            ->toArray();
    }

    public function makeExtra()
    {
        return file_get_contents(__DIR__ . '/scripts/extra/educar-coordenador-falta-atraso-cad.js');
    }

    public function Formular()
    {
        $this->title = 'Coordenação - Falta Atraso';
        $this->processoAp = 635;
    }
};

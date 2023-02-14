<?php

use iEducar\Legacy\Model;

class clsPmieducarFaltaAtraso extends Model
{
    public $cod_falta_atraso;
    public $ref_cod_escola;
    public $ref_ref_cod_instituicao;
    public $ref_usuario_exc;
    public $ref_usuario_cad;
    public $ref_cod_servidor;
    public $tipo;
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
    public $observacao;
    public $qtd_aulas;
    public $exibe_aulas;

    public function __construct(
        $cod_falta_atraso = null,
        $ref_cod_escola = null,
        $ref_ref_cod_instituicao = null,
        $ref_usuario_exc = null,
        $ref_usuario_cad = null,
        $ref_cod_servidor = null,
        $tipo = null,
        $data_falta_atraso = null,
        $qtd_horas = null,
        $qtd_min = null,
        $justificada = null,
        $data_cadastro = null,
        $data_exclusao = null,
        $ativo = null,
        $ref_cod_servidor_funcao = null,
        $ref_cod_curso = null,
        $ref_cod_serie = null,
        $ref_cod_turma = null,
        $ref_cod_componente_curricular = null,
        $observacao = null,
        $ano = null,
        $exibe_aulas = null,
    ) {
        $db = new clsBanco();
        $this->_schema = 'pmieducar.';
        $this->_tabela = $this->_schema . 'falta_atraso';

        $this->_campos_lista = $this->_todos_campos = 'cod_falta_atraso, ref_cod_escola, ref_cod_curso, ref_cod_serie, ref_cod_turma, ref_cod_componente_curricular, observacao, ano, falta_atraso.ref_ref_cod_instituicao, ref_usuario_exc, ref_usuario_cad, falta_atraso.ref_cod_servidor, tipo, data_falta_atraso, qtd_horas, qtd_min, justificada, data_cadastro, data_exclusao, ativo, ref_cod_servidor_funcao, qtd_aulas, exibe_aulas';

        if (is_numeric($ref_cod_escola)) {
            $this->ref_cod_escola = $ref_cod_escola;
        }

        if (is_numeric($ref_usuario_cad)) {
            $this->ref_usuario_cad = $ref_usuario_cad;
        }

        if (is_numeric($ref_usuario_exc)) {
            $this->ref_usuario_exc = $ref_usuario_exc;
        }

        if (is_numeric($ref_cod_servidor) && is_numeric($ref_ref_cod_instituicao)) {
            $this->ref_cod_servidor = $ref_cod_servidor;
            $this->ref_ref_cod_instituicao = $ref_ref_cod_instituicao;
        }

        if (is_numeric($cod_falta_atraso)) {
            $this->cod_falta_atraso = $cod_falta_atraso;
        }

        if (is_numeric($tipo)) {
            $this->tipo = $tipo;
        }

        if (is_string($data_falta_atraso)) {
            $this->data_falta_atraso = $data_falta_atraso;
        }

        if (is_numeric($qtd_horas)) {
            $this->qtd_horas = $qtd_horas;
        }

        if (is_numeric($qtd_min)) {
            $this->qtd_min = $qtd_min;
        }

        if (is_numeric($justificada)) {
            $this->justificada = $justificada;
        }

        if (is_string($data_cadastro)) {
            $this->data_cadastro = $data_cadastro;
        }

        if (is_string($data_exclusao)) {
            $this->data_exclusao = $data_exclusao;
        }

        if (is_numeric($ativo)) {
            $this->ativo = $ativo;
        }

        if (is_numeric($ref_cod_servidor_funcao)) {
            $this->ref_cod_servidor_funcao = $ref_cod_servidor_funcao;
        }

        if (is_numeric($ref_cod_curso)) {
            $this->ref_cod_curso = $ref_cod_curso;
        }

        if (is_numeric($ref_cod_serie)) {
            $this->ref_cod_serie = $ref_cod_serie;
        }

        if (is_numeric($ref_cod_turma)) {
            $this->ref_cod_turma = $ref_cod_turma;
        }

        if (is_numeric($ref_cod_componente_curricular)) {
            $this->ref_cod_componente_curricular = $ref_cod_componente_curricular;
        }

        if (is_string($observacao)) {
            $this->observacao = $observacao;
        }

        if (is_numeric($ano)) {
            $this->ano = $ano;
        }

        if (is_bool($exibe_aulas)) {
            $this->exibe_aulas = $exibe_aulas;
        }
    }

    /**
     * Cria um novo registro.
     *
     * @return bool
     */
    public function cadastra($quadro_horario_aulas = null)
    {
        if (is_numeric($this->ref_cod_escola) &&
            is_numeric($this->ref_ref_cod_instituicao) && is_numeric($this->ref_usuario_cad) &&
            is_numeric($this->ref_cod_servidor) && is_numeric($this->tipo) &&
            is_string($this->data_falta_atraso) && is_numeric($this->justificada)
        ) {
            $db = new clsBanco();

            $campos = '';
            $valores = '';
            $gruda = '';

            if (is_numeric($this->ref_cod_escola)) {
                $campos .= "{$gruda}ref_cod_escola";
                $valores .= "{$gruda}'{$this->ref_cod_escola}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_cod_curso)) {
                $campos .= "{$gruda}ref_cod_curso";
                $valores .= "{$gruda}'{$this->ref_cod_curso}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_cod_serie)) {
                $campos .= "{$gruda}ref_cod_serie";
                $valores .= "{$gruda}'{$this->ref_cod_serie}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_cod_turma)) {
                $campos .= "{$gruda}ref_cod_turma";
                $valores .= "{$gruda}'{$this->ref_cod_turma}'";
                $gruda = ', ';
            }

            if(is_numeric($this->ref_cod_componente_curricular)) {
                $campos .= "{$gruda}ref_cod_componente_curricular";
                $valores .= "{$gruda}'{$this->ref_cod_componente_curricular}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_ref_cod_instituicao)) {
                $campos .= "{$gruda}ref_ref_cod_instituicao";
                $valores .= "{$gruda}'{$this->ref_ref_cod_instituicao}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_usuario_cad)) {
                $campos .= "{$gruda}ref_usuario_cad";
                $valores .= "{$gruda}'{$this->ref_usuario_cad}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_cod_servidor)) {
                $campos .= "{$gruda}ref_cod_servidor";
                $valores .= "{$gruda}'{$this->ref_cod_servidor}'";
                $gruda = ', ';
            }

            if (is_numeric($this->tipo)) {
                $campos .= "{$gruda}tipo";
                $valores .= "{$gruda}'{$this->tipo}'";
                $gruda = ', ';
            }

            if (is_numeric($this->qtd_horas)) {
                $campos .= "{$gruda}qtd_horas";
                $valores .= "{$gruda}'{$this->qtd_horas}'";
                $gruda = ', ';
            }

            if (is_numeric($this->qtd_min)) {
                $campos .= "{$gruda}qtd_min";
                $valores .= "{$gruda}'{$this->qtd_min}'";
                $gruda = ', ';
            }

            if (is_numeric($this->justificada)) {
                $campos .= "{$gruda}justificada";
                $valores .= "{$gruda}'{$this->justificada}'";
                $gruda = ', ';
            }

            if (is_numeric($this->qtd_aulas)) {
                $campos .= "{$gruda}qtd_aulas";
                $valores .= "{$gruda}'{$this->qtd_aulas}'";
                $gruda = ', ';
            }

            if (is_string($this->data_falta_atraso)) {
                $campos .= "{$gruda}data_falta_atraso";
                $valores .= "{$gruda}'{$this->data_falta_atraso}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ano)) {
                $campos .= "{$gruda}ano";
                $valores .= "{$gruda}'{$this->ano}'";
                $gruda = ', ';
            }

            if (dbBool($this->exibe_aulas)) {
                $campos .= "{$gruda}exibe_aulas";
                $valores .= "{$gruda} true ";
                $gruda = ', ';
            } else {
                $campos .= "{$gruda}exibe_aulas";
                $valores .= "{$gruda} false ";
                $gruda = ', ';
            }

            if (is_string($this->observacao)) {
                $campos .= "{$gruda}observacao";
                $valores .= "{$gruda}'{$this->observacao}'";
                $gruda = ', ';
            }

            $campos .= "{$gruda}data_cadastro";
            $valores .= "{$gruda}NOW()";
            $gruda = ', ';

            $campos .= "{$gruda}ativo";
            $valores .= "{$gruda}'1'";

            $db->Consulta("INSERT INTO {$this->_tabela} ($campos) VALUES($valores)");

            $insertId = $db->InsertId("{$this->_tabela}_cod_falta_atraso_seq");

            $qtdAulas = 1; //FALTA GERAL

            if (!empty($quadro_horario_aulas) && is_array($quadro_horario_aulas)) {
                $qtdAulas = 0; //VERIFICA POR HORÁRIO

                foreach ($quadro_horario_aulas as $ref_cod_horario => $aulas) {
                    $qtdAulas += count($aulas);
                    $aulas = implode(',', $aulas);
                    $db->Consulta("INSERT INTO pmieducar.falta_atraso_horarios ( ref_cod_falta_atraso, ref_cod_quadro_horario_horarios, aulas ) VALUES ( '{$insertId}', '{$ref_cod_horario}', '{$aulas}' )");
                }
            }

            $sqlUpdateQtdAulas =  "
                UPDATE {$this->_tabela}
                SET qtd_aulas = '{$qtdAulas}'
                WHERE cod_falta_atraso = '{$insertId}'";

            $db->Consulta($sqlUpdateQtdAulas);

            return $insertId;
        }

        return false;
    }

    /**
     * Edita os dados de um registro.
     *
     * @return bool
     */
    public function edita($quadro_horario_aulas = null)
    {
        if (is_numeric($this->cod_falta_atraso) && is_numeric($this->ref_usuario_exc)) {
            $db = new clsBanco();
            $gruda = '';
            $set = '';

            if (is_numeric($this->ref_cod_escola)) {
                $set .= "{$gruda}ref_cod_escola = '{$this->ref_cod_escola}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_ref_cod_instituicao)) {
                $set .= "{$gruda}ref_ref_cod_instituicao = '{$this->ref_ref_cod_instituicao}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_usuario_exc)) {
                $set .= "{$gruda}ref_usuario_exc = '{$this->ref_usuario_exc}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_usuario_cad)) {
                $set .= "{$gruda}ref_usuario_cad = '{$this->ref_usuario_cad}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_cod_servidor)) {
                $set .= "{$gruda}ref_cod_servidor = '{$this->ref_cod_servidor}'";
                $gruda = ', ';
            }

            if (is_numeric($this->tipo)) {
                $set .= "{$gruda}tipo = '{$this->tipo}'";
                $gruda = ', ';
            }

            if (is_string($this->data_falta_atraso)) {
                $set .= "{$gruda}data_falta_atraso = '{$this->data_falta_atraso}'";
                $gruda = ', ';
            }

            if (is_numeric($this->qtd_horas)) {
                $set .= "{$gruda}qtd_horas = '{$this->qtd_horas}'";
                $gruda = ', ';
            }

            if (is_numeric($this->qtd_min)) {
                $set .= "{$gruda}qtd_min = '{$this->qtd_min}'";
                $gruda = ', ';
            }

            if (is_numeric($this->justificada)) {
                $set .= "{$gruda}justificada = '{$this->justificada}'";
                $gruda = ', ';
            }

            if (is_numeric($this->qtd_aulas)) {
                $set .= "{$gruda}qtd_aulas = '{$this->qtd_aulas}'";
                $gruda = ', ';
            }

            if (is_string($this->data_cadastro)) {
                $set .= "{$gruda}data_cadastro = '{$this->data_cadastro}'";
                $gruda = ', ';
            }

            if (is_string($this->observacao)) {
                $set .= "{$gruda}observacao = '{$this->observacao}'";
                $gruda = ', ';
            }

            if (is_numeric($this->ref_cod_servidor_funcao)) {
                $set .= "{$gruda}ref_cod_servidor_funcao = '{$this->ref_cod_servidor_funcao}'";
                $gruda = ', ';
            }

            if (dbBool($this->exibe_aulas)) {
                $set .= "{$gruda}exibe_aulas = true ";
                $gruda = ', ';
            } else {
                $set .= "{$gruda}exibe_aulas = false ";
                $gruda = ', ';
            }

            if (is_numeric($this->ano)) {
                $set .= "{$gruda}ano = '{$this->ano}'";
                $gruda = ', ';
            }

            $set .= "{$gruda}data_exclusao = NOW()";
            $gruda = ', ';

            if (is_numeric($this->ativo)) {
                $set .= "{$gruda}ativo = '{$this->ativo}'";
            }

            if ($set) {
                if (!empty($quadro_horario_aulas) && is_array($quadro_horario_aulas)) {
                    $qtdAulas = 0;

                    $idsRefsQuadroHorario = '';
                    foreach ($quadro_horario_aulas as $ref_cod_horario => $aulas) {
                        $qtdAulas += count($aulas);
                        $aulas = implode(',', $aulas);
                        $idsRefsQuadroHorario .= $ref_cod_horario.',';

                        $sqlSelect = "
                            SELECT
                                fah.*
                            FROM
                                pmieducar.falta_atraso_horarios fah
                            WHERE
                                ref_cod_falta_atraso = '{$this->cod_falta_atraso}' AND fah.ref_cod_quadro_horario_horarios = '{$ref_cod_horario}'";

                        $db->Consulta($sqlSelect);
                        $db->ProximoRegistro();
                        $registroFaltaAtraso = $db->Tupla();

                        if ($registroFaltaAtraso) {
                            $sqlUpdate = "
                            UPDATE
                                pmieducar.falta_atraso_horarios
                            SET
                               aulas = '{$aulas}'
                            WHERE
                                ref_cod_falta_atraso = '{$this->cod_falta_atraso}' AND ref_cod_quadro_horario_horarios = '{$ref_cod_horario}'";

                            $db->Consulta($sqlUpdate);

                            continue;
                        }

                        $db->Consulta("INSERT INTO pmieducar.falta_atraso_horarios ( ref_cod_falta_atraso, ref_cod_quadro_horario_horarios, aulas ) VALUES ( '{$this->cod_falta_atraso}', '{$ref_cod_horario}', '{$aulas}' )");

                    }

                    if (!empty($idsRefsQuadroHorario)) {
                        $inIdsRefsQuadroHorario = rtrim($idsRefsQuadroHorario, ',');

                        $sqlDelete = "
                        DELETE FROM
                            pmieducar.falta_atraso_horarios
                        WHERE
                            ref_cod_falta_atraso = '{$this->cod_falta_atraso}' AND ref_cod_quadro_horario_horarios NOT IN ({$inIdsRefsQuadroHorario})
                        ";

                        $db->Consulta($sqlDelete);
                    }

                    if (is_numeric($qtdAulas)) {
                        $set .= "{$gruda}qtd_aulas = '{$qtdAulas}'";
                    }
                }

                $db->Consulta("UPDATE {$this->_tabela} SET $set WHERE cod_falta_atraso = '{$this->cod_falta_atraso}'");

                return true;
            }
        }

        return false;
    }

    /**
     * Retorna uma lista de registros filtrados de acordo com os parâmetros.
     *
     * @return array
     */
    public function lista(
        $int_cod_falta_atraso = null,
        $int_ref_cod_escola = null,
        $int_ref_ref_cod_instituicao = null,
        $int_ref_usuario_exc = null,
        $int_ref_usuario_cad = null,
        $int_ref_cod_servidor = null,
        $int_tipo = null,
        $date_data_falta_atraso_ini = null,
        $date_data_falta_atraso_fim = null,
        $int_qtd_horas = null,
        $int_qtd_min = null,
        $int_justificada = null,
        $date_data_cadastro_ini = null,
        $date_data_cadastro_fim = null,
        $date_data_exclusao_ini = null,
        $date_data_exclusao_fim = null,
        $int_ativo = null,
        $int_ref_cod_curso = null,
        $int_ref_cod_serie = null,
        $int_ref_cod_turma = null,
        $int_ref_cod_componente_curricular = null,
        $int_ano = null
    ) {
        $sql = "
            SELECT {$this->_campos_lista}, matricula
            FROM {$this->_tabela}
            LEFT JOIN pmieducar.servidor_funcao ON servidor_funcao.cod_servidor_funcao = falta_atraso.ref_cod_servidor_funcao
        ";
        $filtros = '';

        $whereAnd = ' WHERE ';

        if (is_numeric($int_ano)) {
            $filtros .= "{$whereAnd} EXTRACT(YEAR FROM f.data) = '{$int_ano}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_cod_falta_atraso)) {
            $filtros .= "{$whereAnd} cod_falta_atraso = '{$int_cod_falta_atraso}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_cod_escola)) {
            $filtros .= "{$whereAnd} ref_cod_escola = '{$int_ref_cod_escola}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_cod_curso)) {
            $filtros .= "{$whereAnd} c.cod_curso = '{$int_ref_cod_curso}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_cod_serie)) {
            $filtros .= "{$whereAnd} s.cod_serie = '{$int_ref_cod_serie}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_cod_turma)) {
            $filtros .= "{$whereAnd} t.cod_turma = '{$int_ref_cod_turma}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_cod_componente_curricular)) {
            $filtros .= "{$whereAnd} k.id = '{$int_ref_cod_componente_curricular}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_ref_cod_instituicao)) {
            $filtros .= "{$whereAnd} falta_atraso.ref_ref_cod_instituicao = '{$int_ref_ref_cod_instituicao}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_usuario_exc)) {
            $filtros .= "{$whereAnd} ref_usuario_exc = '{$int_ref_usuario_exc}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_usuario_cad)) {
            $filtros .= "{$whereAnd} ref_usuario_cad = '{$int_ref_usuario_cad}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_ref_cod_servidor)) {
            $filtros .= "{$whereAnd} falta_atraso.ref_cod_servidor = '{$int_ref_cod_servidor}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_tipo)) {
            $filtros .= "{$whereAnd} tipo = '{$int_tipo}'";
            $whereAnd = ' AND ';
        }

        if (is_string($date_data_falta_atraso_ini)) {
            $filtros .= "{$whereAnd} data_falta_atraso >= '{$date_data_falta_atraso_ini}'";
            $whereAnd = ' AND ';
        }

        if (is_string($date_data_falta_atraso_fim)) {
            $filtros .= "{$whereAnd} data_falta_atraso <= '{$date_data_falta_atraso_fim}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_qtd_horas)) {
            $filtros .= "{$whereAnd} qtd_horas = '{$int_qtd_horas}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_qtd_min)) {
            $filtros .= "{$whereAnd} qtd_min = '{$int_qtd_min}'";
            $whereAnd = ' AND ';
        }

        if (is_numeric($int_justificada)) {
            $filtros .= "{$whereAnd} justificada = '{$int_justificada}'";
            $whereAnd = ' AND ';
        }

        if (is_string($date_data_cadastro_ini)) {
            $filtros .= "{$whereAnd} data_cadastro >= '{$date_data_cadastro_ini}'";
            $whereAnd = ' AND ';
        }

        if (is_string($date_data_cadastro_fim)) {
            $filtros .= "{$whereAnd} data_cadastro <= '{$date_data_cadastro_fim}'";
            $whereAnd = ' AND ';
        }

        if (is_string($date_data_exclusao_ini)) {
            $filtros .= "{$whereAnd} data_exclusao >= '{$date_data_exclusao_ini}'";
            $whereAnd = ' AND ';
        }

        if (is_string($date_data_exclusao_fim)) {
            $filtros .= "{$whereAnd} data_exclusao <= '{$date_data_exclusao_fim}'";
            $whereAnd = ' AND ';
        }

        if (is_null($int_ativo) || $int_ativo) {
            $filtros .= "{$whereAnd} ativo = '1'";
            $whereAnd = ' AND ';
        } else {
            $filtros .= "{$whereAnd} ativo = '0'";
            $whereAnd = ' AND ';
        }

        $db = new clsBanco();
        $countCampos = count(explode(',', $this->_campos_lista));
        $resultado = [];

        $sql .= $filtros . $this->getOrderby() . $this->getLimite();

        $this->_total = $db->CampoUnico("SELECT COUNT(0) FROM {$this->_tabela} {$filtros}");

        $db->Consulta($sql);

        if ($countCampos > 1) {
            while ($db->ProximoRegistro()) {
                $tupla = $db->Tupla();

                $tupla['_total'] = $this->_total;
                $resultado[] = $tupla;
            }
        } else {
            while ($db->ProximoRegistro()) {
                $tupla = $db->Tupla();
                $resultado[] = $tupla[$this->_campos_lista];
            }
        }

        if (count($resultado)) {
            return $resultado;
        }

        return false;
    }

    /**
     * Retorna um array com os dados de um registro.
     *
     * @return array
     */
    public function detalhe()
    {
        if (is_numeric($this->cod_falta_atraso)) {
            $db = new clsBanco();
            $db->Consulta("SELECT {$this->_todos_campos} FROM {$this->_tabela} WHERE cod_falta_atraso = '{$this->cod_falta_atraso}'");
            $db->ProximoRegistro();

            return $db->Tupla();
        }

        return false;
    }

    public function verificarFaltaAtrasoQuadroHorario($quadroHorarioArray)
    {
        if (is_numeric($this->cod_falta_atraso)) {
            $adapterQuadroHorario = [];

            foreach ($quadroHorarioArray as $quadroHorario) {
                $sql = "
                SELECT
                    fah.*
                FROM
                    pmieducar.falta_atraso_horarios fah
                WHERE
                    ref_cod_falta_atraso = '{$this->cod_falta_atraso}' AND fah.ref_cod_quadro_horario_horarios = '{$quadroHorario['ref_cod_quadro_horario_horarios']}'";

                $db = new clsBanco();
                $db->Consulta($sql);
                $db->ProximoRegistro();
                $faltaAtraso = $db->Tupla();

                $adapterQuadroHorario[] = [
                    'ref_cod_quadro_horario_horarios' => $quadroHorario['ref_cod_quadro_horario_horarios'],
                    'horario' =>  substr($quadroHorario['hora_inicial'], 0, 5) . ' - ' .  substr($quadroHorario['hora_final'], 0, 5),
                    'componenteCurricular' => $quadroHorario['componente_abreviatura'],
                    'qtdAulas' => (!empty($quadroHorario['qtd_aulas']) ? $quadroHorario['qtd_aulas'] : 1),
                    'aulasFaltou' => explode(',', $faltaAtraso['aulas']),
                ];
            }

            return $adapterQuadroHorario;
        }

        return false;
    }

    /**
     * Retorna um array com os dados de um registro.
     *
     * @return array
     */
    public function existe()
    {
        if (is_numeric($this->cod_falta_atraso)) {
            $db = new clsBanco();
            $db->Consulta("SELECT 1 FROM {$this->_tabela} WHERE cod_falta_atraso = '{$this->cod_falta_atraso}'");
            $db->ProximoRegistro();

            return $db->Tupla();
        }

        return false;
    }

    /**
     * Exclui um registro.
     *
     * @return bool
     */
    public function excluir()
    {
        if (is_numeric($this->cod_falta_atraso) && is_numeric($this->ref_usuario_exc)) {
            $this->ativo = 0;


            $sqlDeleteHorarios = "
                        DELETE FROM
                            pmieducar.falta_atraso_horarios
                        WHERE
                            ref_cod_falta_atraso = '{$this->cod_falta_atraso}'
                        ";

            $db = new clsBanco();
            $db->Consulta($sqlDeleteHorarios);

            return $this->edita();
        }

        return false;
    }

    /**
     * Retorna uma lista de registros filtrados de acordo com os parâmetros.
     *
     * @return array
     */
    public function listaHorasEscola(
        $int_ref_cod_servidor = null,
        $int_ref_ref_cod_instituicao = null,
        $int_ref_cod_escola = null
    ) {
        $sql = '
          SELECT
            SUM(qtd_horas) AS horas,
            SUM(qtd_min) AS minutos,
            ref_cod_escola,
            ref_ref_cod_instituicao
          FROM
        ' . $this->_tabela;

        $filtros = '';

        $whereAnd = ' WHERE ';

        if (is_numeric($int_ref_cod_servidor)) {
            $filtros .= "{$whereAnd} ref_cod_servidor = '{$int_ref_cod_servidor}'";
            $whereAnd = ' AND ';
        }
        if (is_numeric($int_ref_cod_escola)) {
            $filtros .= "{$whereAnd} ref_cod_escola = '{$int_ref_cod_escola}'";
            $whereAnd = ' AND ';
        }
        if (is_numeric($int_ref_ref_cod_instituicao)) {
            $filtros .= "{$whereAnd} ref_ref_cod_instituicao = '{$int_ref_ref_cod_instituicao}'";
            $whereAnd = ' AND ';
        }

        $filtros .= "{$whereAnd} justificada <> '0'";
        $whereAnd = ' AND ';

        $filtros .= "{$whereAnd} ativo <> '0'";
        $whereAnd = ' AND ';

        $groupBy = ' GROUP BY ref_cod_escola, ref_ref_cod_instituicao';

        $db = new clsBanco();
        $countCampos = count(explode(',', $this->_campos_lista));
        $resultado = [];

        $this->_total = $db->CampoUnico("SELECT COUNT(0) FROM ({$sql}{$filtros}{$groupBy}) AS countsubquery");

        $sql .= $filtros . $groupBy . $this->getLimite();

        $db->Consulta($sql);

        if ($countCampos > 1) {
            while ($db->ProximoRegistro()) {
                $tupla = $db->Tupla();

                $tupla['_total'] = $this->_total;
                $resultado[] = $tupla;
            }
        } else {
            while ($db->ProximoRegistro()) {
                $tupla = $db->Tupla();
                $resultado[] = $tupla[$this->_campos_lista];
            }
        }

        if (count($resultado)) {
            return $resultado;
        }

        return false;
    }

    public function excluiTodosPorServidor($codServidor): void
    {
        $db = new clsBanco();
        $db->Consulta("DELETE FROM {$this->_tabela} WHERE ref_cod_servidor = '{$codServidor}'");
    }

    public function getFaltasAtrasoForFrequencia()
    {
        $faltaAtraso = $this->detalheParaFrequencia();

        $possuiFaltas = false;
        $faltaGeral = false;
        $qtdFaltas = 0;

        if (!empty($faltaAtraso)) {
            $possuiFaltas = true;
            $faltaGeral = !dbBool($faltaAtraso['exibe_aulas']);
            $qtdFaltas = $faltaAtraso['qtd_aulas'];
        }

        return [
            'possuiFaltas' => $possuiFaltas,
            'faltaGeral' => $faltaGeral,
            'qtdFaltas' => $qtdFaltas
        ];
    }

    public function detalheParaFrequencia()
    {
        if (is_numeric($this->ref_cod_servidor) && is_string($this->data_falta_atraso)) {
            $db = new clsBanco();

            $sql = "
                SELECT
                    {$this->_todos_campos}
                FROM
                    {$this->_tabela}
                WHERE
                    ref_cod_servidor = '{$this->ref_cod_servidor}'
                  AND ref_cod_turma = '{$this->ref_cod_turma}'
                  AND tipo = '2'
                  AND data_falta_atraso = '{$this->data_falta_atraso}'";

            if (is_numeric($this->ref_cod_componente_curricular)) {
                $sql .= " AND ref_cod_componente_curricular = '{$this->ref_cod_componente_curricular}' ";
            }

            $db->Consulta($sql);

            $db->ProximoRegistro();

            return $db->Tupla();
        }

        return false;
    }
}

<?php

return new class extends clsDetalhe {
    public $titulo;
    public $id;
    public $ref_usuario_exc;
    public $ref_usuario_cad;
    public $ref_ref_cod_serie;
    public $ref_ref_cod_escola;
    public $ref_cod_infra_predio_comodo;
    public $nm_turma;
    public $sgl_turma;
    public $max_aluno;
    public $multiseriada;
    public $data_cadastro;
    public $data_exclusao;
    public $ativo;
    public $ref_cod_turma_tipo;
    public $hora_inicial;
    public $hora_final;
    public $hora_inicio_intervalo;
    public $hora_fim_intervalo;
    public $ref_cod_instituicao;
    public $ref_cod_curso;
    public $ref_cod_instituicao_regente;
    public $ref_cod_regente;

    public function Gerar()
    {
        $this->titulo = 'Atendimento AEE - Detalhe';
        $this->id = $_GET['id'];

        $obj_permissoes = new clsPermissoes();

        $tmp_obj = new clsModulesComponenteMinistradoAee($this->id); 
        $registro = $tmp_obj->detalhe();

        if (!$registro) {
            $this->simpleRedirect('educar_professores_conteudo_ministrado_aee_lst.php');
        }
        

        if ($registro['detalhes']['id']) {
            $this->addDetalhe(
                [
                    'ID',
                    $registro['detalhes']['id']
                ]
            );
        }

        if ($registro['detalhes']['data_cadastro']) {
            $this->addDetalhe(
                [
                    'Data',
                    dataToBrasil($registro['detalhes']['data_cadastro'])
                ]
            );
        }

        if ($registro['detalhes']['escola']) {
            $this->addDetalhe(
                [
                    'Escola',
                    $registro['detalhes']['escola']
                ]
            );
        }

        if ($registro['detalhes']['professor']) {
            $this->addDetalhe(
                [
                    'Professor',
                    $registro['detalhes']['professor']
                ]
            );
        }

        if ($registro['detalhes']['ref_cod_turma']) {
            $this->addDetalhe(
                [
                    'Turma',
                    $registro['detalhes']['turma']
                ]
            );
        }

        if ($registro['detalhes']['ref_cod_matricula']) {
            $this->addDetalhe(
                [
                    'Aluno',
                    $registro['detalhes']['aluno']
                ]
            );
        }

        if ($registro['detalhes']['etapa'] && $registro['detalhes']['fase_etapa']) {
            $this->addDetalhe(
                [
                    'Etapa',
                    $registro['detalhes']['fase_etapa'] . "º " . $registro['detalhes']['etapa']
                ]
            );
        }

        if ($registro['detalhes']['atividades']) {
            $this->addDetalhe(
                [
                    'Registro diário de aula',
                    $registro['detalhes']['atividades']
                ]
            );
        }

        if (is_array($registro['conteudos']) && $registro['conteudos'] != null) {
            $this->montaListaConteudos($registro['conteudos']);
        }
        
        if ($registro['detalhes']['observacao']) {
            $this->addDetalhe(
                [
                    'Observação',
                    $registro['detalhes']['observacao']
                ]
            );
        }

        if ($obj_permissoes->permissao_cadastra(58, $this->pessoa_logada, 7)) {
            $this->url_novo = 'educar_professores_conteudo_ministrado_aee_cad.php';

            // if (is_numeric($registro['detalhes']['cod_turma']) && is_numeric($registro['detalhes']['fase_etapa'])) {
            //     $data_agora = new DateTime('now');
            //     $data_agora = new \DateTime($data_agora->format('Y-m-d'));

            //     $turma = $registro['detalhes']['cod_turma'];
            //     $sequencia = $registro['detalhes']['fase_etapa'];
            //     $obj = new clsPmieducarTurmaModulo();

            //     $data = $obj->pegaPeriodoLancamentoNotasFaltasAee($turma, $sequencia);
            //     if ($data['inicio'] != null && $data['fim'] != null) {
            //         $data['inicio'] = explode(',', $data['inicio']);
            //         $data['fim'] = explode(',', $data['fim']);

            //         array_walk($data['inicio'], function(&$data_inicio, $key) {
            //             $data_inicio = new \DateTime($data_inicio);
            //         });

            //         array_walk($data['fim'], function(&$data_fim, $key) {
            //             $data_fim = new \DateTime($data_fim);
            //         });
            //     } else {
            //         $data['inicio'] = new \DateTime($obj->pegaEtapaSequenciaDataInicio($turma, $sequencia));
            //         $data['fim'] = new \DateTime($obj->pegaEtapaSequenciaDataFim($turma, $sequencia));
            //     }

            //     $podeEditar = false;
            //     if (is_array($data['inicio']) && is_array($data['fim'])) {
            //         for ($i=0; $i < count($data['inicio']); $i++) {
            //             $data_inicio = $data['inicio'][$i];
            //             $data_fim = $data['fim'][$i];

            //             $podeEditar = $data_agora >= $data_inicio && $data_agora <= $data_fim;

            //             if ($podeEditar) break;
            //         }     
            //     } else {
            //         $podeEditar = $data_agora >= $data['inicio'] && $data_agora <= $data['fim'];
            //     }

                // if ($podeEditar)
                    $this->url_editar = 'educar_professores_conteudo_ministrado_aee_cad.php?id=' . $registro['detalhes']['id'];
            //}
        }

        $this->url_cancelar = 'educar_professores_conteudo_ministrado_aee_lst.php';
        $this->largura = '100%';

        $this->breadcrumb('Detalhe do Atendimento - AEE', [
            url('intranet/educar_professores_index.php') => 'Professores',
        ]);
    }

    function montaListaConteudos ($conteudos) {
        for ($i=0; $i < count($conteudos); $i++) {
            $this->tabela2 .= '  <div style="margin-bottom: 10px; float: left" class="linha-disciplina" >';

            $this->tabela2 .= "  <span style='display: block; float: left'>{$conteudos[$i]['planejamento_aula_conteudo_aee']['conteudo']}</span>";

            $this->tabela2 .= '  </div>';
            $this->tabela2 .= '  <br style="clear: left" />';
        }

        $conteudo  = '<table cellspacing="0" cellpadding="0" border="0">';
        $conteudo .= sprintf('<tr align="left"><td class="formlttd">%s</td></tr>', $this->tabela2);
        $conteudo .= '</table>';

        $this->addDetalhe(
            [
                'Conteúdos',
                $conteudo
            ]
        );
    }


    public function Formular()
    {
        $this->title = 'Atendimento AEE - Detalhe';
        $this->processoAp = 58;
    }
};
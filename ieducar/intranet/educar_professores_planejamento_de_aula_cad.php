<?php

use App\Models\LegacyDiscipline;
use App\Models\LegacyGrade;
use App\Process;
use App\Services\CheckPostedDataService;
use App\Services\iDiarioService;
use App\Services\SchoolLevelsService;
use Illuminate\Support\Arr;

return new class extends clsCadastro {
    public $id;
    public $ref_cod_turma;
<<<<<<< Updated upstream
    public $ref_cod_componente_curricular;
=======
    public $ref_cod_componente_curricular_array;
>>>>>>> Stashed changes
    public $fase_etapa;
    public $data_inicial;
    public $data_final;
    public $ddp;
    public $atividades;
    public $referencias;
<<<<<<< Updated upstream
    public $bnccs;
    public $conteudo_id;
=======
    public $bncc;
    public $conteudo_id;
    public $bncc_especificacoes;
    public $recursos_didaticos;
    public $registro_adaptacao;
>>>>>>> Stashed changes

    public function Inicializar () {
        $this->titulo = 'Plano de aula - Cadastro';

        $retorno = 'Novo';

        $this->id = $_GET['id'];
<<<<<<< Updated upstream
=======
        $this->copy = $_GET['copy'];
>>>>>>> Stashed changes

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(58, $this->pessoa_logada, 7, 'educar_professores_planejamento_de_aula_lst.php');

        if (is_numeric($this->id)) {
            $tmp_obj = new clsModulesPlanejamentoAula($this->id);
            $registro = $tmp_obj->detalhe();

<<<<<<< Updated upstream
            if ($registro) {
=======
            if ($registro['detalhes'] != null) {
>>>>>>> Stashed changes
                // passa todos os valores obtidos no registro para atributos do objeto
                foreach ($registro['detalhes'] as $campo => $val) {
                    $this->$campo = $val;
                }
                $this->bncc = array_column($registro['bnccs'], 'id');

<<<<<<< Updated upstream
                $this->fexcluir = $obj_permissoes->permissao_excluir(58, $this->pessoa_logada, 7);
                $retorno = 'Editar';

                $this->titulo = 'Plano de aula - Edição';
=======
                if (!$this->copy) {
                    $this->fexcluir = $obj_permissoes->permissao_excluir(58, $this->pessoa_logada, 7);
                    $retorno = 'Editar';

                    $this->titulo = 'Plano de aula - Edição';
                }
            } else {
                $this->simpleRedirect('educar_professores_planejamento_de_aula_lst.php');
>>>>>>> Stashed changes
            }
        }

        $this->url_cancelar = ($retorno == 'Editar')
            ? sprintf('educar_professores_planejamento_de_aula_det.php?id=%d', $this->id)
            : 'educar_professores_planejamento_de_aula_lst.php';

        $nomeMenu = $retorno == 'Editar' ? $retorno : 'Cadastrar';

        $this->breadcrumb($nomeMenu . ' plano de aula', [
            url('intranet/educar_professores_index.php') => 'Professores',
        ]);

        $this->nome_url_cancelar = 'Cancelar';

        return $retorno;
    }

    public function Gerar () {
        if ($_POST) {
            foreach ($_POST as $campo => $val) {
                $this->$campo = ($this->$campo) ? $this->$campo : $val;
            }
        }
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        $this->data_inicial = dataToBrasil($this->data_inicial);
        $this->data_final = dataToBrasil($this->data_final);

        $this->ano = explode('/', $this->data_inicial)[2];

        if ($tipoacao == 'Edita' || !$_POST
            && $this->data_inicial != ''
            && $this->data_final != ''
            && is_numeric($this->ref_cod_turma)
<<<<<<< Updated upstream
            && is_numeric($this->ref_cod_componente_curricular)
=======
            && is_numeric($this->ref_cod_componente_curricular_array)
>>>>>>> Stashed changes
            && is_numeric($this->fase_etapa)
        ) {
            $desabilitado = true;
        }

        $obrigatorio = true;

        $this->campoOculto('id', $this->id);
        $this->inputsHelper()->dynamic('dataInicial', ['required' => $obrigatorio]);    // Disabled não funciona; ação colocada no javascript.
        $this->inputsHelper()->dynamic('dataFinal', ['required' => $obrigatorio]);      // Disabled não funciona; ação colocada no javascript.
<<<<<<< Updated upstream
        $this->inputsHelper()->dynamic('todasTurmas', ['required' => $obrigatorio, 'ano' => $this->ano, 'disabled' => $desabilitado]);
        $this->inputsHelper()->dynamic('componenteCurricular', ['required' => $obrigatorio, 'disabled' => $desabilitado]);
        $this->inputsHelper()->dynamic('faseEtapa', ['required' => $obrigatorio, 'label' => 'Etapa', 'disabled' => $desabilitado]);
    
        $this->adicionarBNCCMultiplaEscolha();
        $this->adicionarConteudosTabela();

        $this->campoMemo('ddp','Metodologia', $this->ddp, 100, 5, !$obrigatorio);
        $this->campoMemo('atividades','Atividades/Avaliações', $this->atividades, 100, 5, !$obrigatorio);
        $this->campoMemo('referencias','Referências', $this->referencias, 100, 5, !$obrigatorio);

=======
        $this->inputsHelper()->dynamic('todasTurmas', ['required' => $obrigatorio, 'ano' => $this->ano, 'disabled' => $desabilitado && !$this->copy]);
        $this->inputsHelper()->dynamic('faseEtapa', ['required' => $obrigatorio, 'label' => 'Etapa', 'disabled' => $desabilitado && !$this->copy]);

        $this->adicionarBNCCMultiplaEscolha();
        $this->adicionarConteudosTabela();

        $this->campoMemo('ddp','Metodologia', $this->ddp, 100, 5, $obrigatorio);
        $this->campoMemo('atividades','Atividades/Avaliações', $this->atividades, 100, 5, !$obrigatorio);
        $this->campoMemo('recursos_didaticos','Recursos didáticos', $this->recursos_didaticos, 100, 5, !$obrigatorio);
        $this->campoMemo('registro_adaptacao','Registro de adaptação', $this->registro_adaptacao, 100, 5, !$obrigatorio);
        $this->campoMemo('referencias','Referências', $this->referencias, 100, 5, !$obrigatorio);

        $this->campoOculto('id', $this->id);
        $this->campoOculto('copy', $this->copy);

>>>>>>> Stashed changes
        $this->campoOculto('ano', explode('/', dataToBrasil(NOW()))[2]);
    }

    public function Novo() {
<<<<<<< Updated upstream
        $data_agora = new DateTime('now');
        $data_agora = new \DateTime($data_agora->format('Y-m-d'));

        $turma = $this->ref_cod_turma;
        $sequencia = $this->fase_etapa;
        $obj = new clsPmieducarTurmaModulo();

        $data = $obj->pegaPeriodoLancamentoNotasFaltas($turma, $sequencia);
        if ($data['inicio'] != null && $data['fim'] != null) {
            $data['inicio'] = explode(',', $data['inicio']);
            $data['fim'] = explode(',', $data['fim']);

            array_walk($data['inicio'], function(&$data_inicio, $key) {
                $data_inicio = new \DateTime($data_inicio);
            });

            array_walk($data['fim'], function(&$data_fim, $key) {
                $data_fim = new \DateTime($data_fim);
            });
        } else {
            $data['inicio'] = new \DateTime($obj->pegaEtapaSequenciaDataInicio($turma, $sequencia));
            $data['fim'] = new \DateTime($obj->pegaEtapaSequenciaDataFim($turma, $sequencia));
        }

        $podeRegistrar = false;
        if (is_array($data['inicio']) && is_array($data['fim'])) {
            for ($i=0; $i < count($data['inicio']); $i++) {
                $data_inicio = $data['inicio'][$i];
                $data_fim = $data['fim'][$i];

                $podeRegistrar = $data_agora >= $data_inicio && $data_agora <= $data_fim;

                if ($podeRegistrar) break;
            }     
        } else {
            $podeRegistrar = $data_agora >= $data['inicio'] && $data_agora <= $data['fim'];
        }

        if (!$podeRegistrar) {
            $this->mensagem = 'Cadastro não realizado, pois não é mais possível submeter plano para esta etapa.<br>';
            $this->simpleRedirect('educar_professores_planejamento_de_aula_cad.php');
        }

        $obj = new clsModulesPlanejamentoAula(
           null,
           $this->ref_cod_turma,
           $this->ref_cod_componente_curricular,
           $this->fase_etapa,
           dataToBanco($this->data_inicial),
           dataToBanco($this->data_final),
           $this->ddp, 
           $this->atividades,
           $this->bncc,
           $this->conteudos,
           $this->referencias
        );

        $existe = $obj->existe();
        if ($existe){
            $this->mensagem = 'Cadastro não realizado, pois este plano de aula já existe.<br>';
            $this->simpleRedirect('educar_professores_planejamento_de_aula_cad.php');
        }

        $cadastrou = $obj->cadastra();

        if (!$cadastrou) {   
            $this->mensagem = 'Cadastro não realizado.<br>';
            $this->simpleRedirect('educar_professores_planejamento_de_aula_cad.php');
        } else {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br>';
            $this->simpleRedirect('educar_professores_planejamento_de_aula_lst.php');
        }

        $this->mensagem = 'Cadastro não realizado.<br>';

        return false;
=======
        // educar-professores-planejamento-de-aula-cad.js
>>>>>>> Stashed changes
    }

    public function Editar() {
        $obj = new clsModulesPlanejamentoAula(
            $this->id,
            null,
            null,
            null,
            null,
            null,
            $this->ddp,
            $this->atividades,
            $this->bncc,
            $this->conteudos,
            $this->referencias
        );

        $editou = $obj->edita();

        if ($editou) {
            $this->mensagem .= 'Edi&ccedil;&atilde;o efetuada com sucesso.<br>';
            $this->simpleRedirect('educar_professores_planejamento_de_aula_lst.php');
        }

        $this->mensagem = 'Edi&ccedil;&atilde;o n&atilde;o realizada.<br>';

        return false;
    }

    public function Excluir () {
        $obj = new clsModulesPlanejamentoAula($this->id);

        $excluiu = $obj->excluir();

        if ($excluiu) {
            $this->mensagem .= 'Exclus&atilde;o efetuada com sucesso.<br>';
            $this->simpleRedirect('educar_professores_planejamento_de_aula_lst.php');
        }

        $this->mensagem = 'Exclus&atilde;o n&atilde;o realizada.<br>';

        return false;
    }
 
<<<<<<< Updated upstream
    private function getBNCCTurma($turma = null, $ref_cod_componente_curricular = null)
=======
    private function getBNCCTurma($turma = null, $ref_cod_componente_curricular_array = null)
>>>>>>> Stashed changes
    {
        if (is_numeric($turma)) {
            $obj = new clsPmieducarTurma($turma);
            $resultado = $obj->getGrau();

            $bncc = [];
            $bncc_temp = [];
            $obj = new clsModulesBNCC();

<<<<<<< Updated upstream
            if ($bncc_temp = $obj->listaTurma($resultado, $turma, $ref_cod_componente_curricular)) {
=======
            if ($bncc_temp = $obj->listaTurma($resultado, $turma, $ref_cod_componente_curricular_array)) {
>>>>>>> Stashed changes
                foreach ($bncc_temp as $bncc_item) {
                    $id = $bncc_item['id'];
                    $codigo = $bncc_item['codigo'];
                    $habilidade = $bncc_item['habilidade'];

                    $bncc[$id] = $codigo . ' - ' . $habilidade;
                }
            }

            return ['bncc' => $bncc];
        }

        return [];
    }
    public function __construct () {
        parent::__construct();
        $this->loadAssets();
    }

    public function loadAssets () {
        $scripts = [
            '/modules/DynamicInput/Assets/Javascripts/TodasTurmas.js',
<<<<<<< Updated upstream
            '/modules/Cadastro/Assets/Javascripts/BNCC.js',
            '/modules/Cadastro/Assets/Javascripts/PlanejamentoAula.js',
=======
            '/modules/Cadastro/Assets/Javascripts/PlanejamentoAula.js',
            '/modules/Cadastro/Assets/Javascripts/PlanoAulaExclusao.js',
            '/modules/Cadastro/Assets/Javascripts/PlanoAulaEdicao.js',
            '/modules/Cadastro/Assets/Javascripts/PlanoAulaDuplicacao.js',
>>>>>>> Stashed changes
        ];

        Portabilis_View_Helper_Application::loadJavascript($this, $scripts);
    }

<<<<<<< Updated upstream
    private function adicionarBNCCMultiplaEscolha($obrigatorio = true) {
        $helperOptions = [
            'objectName' => 'bncc',
        ];

        $todos_bncc = $this->getBNCCTurma($this->ref_cod_turma, $this->ref_cod_componente_curricular)['bncc'];

        $options = [
            'label' => 'Objetivos de aprendizagem/habilidades (BNCC)',
            'required' => $obrigatorio,
            'size' => 50,
=======
    public function makeExtra()
    {
        return file_get_contents(__DIR__ . '/scripts/extra/educar-professores-planejamento-de-aula-cad.js');
    }

    private function adicionarBNCCMultiplaEscolha() {
        $this->campoTabelaInicio(
            'objetivos_aprendizagem',
            'Objetivo(s) de aprendizagem',
            ['Componente curricular', "Habilidade(s)", "Especificação(ões)"],
            // $arr_valores,
            // '',
            // $lst_opcoes
        );

        // Componente curricular
        $this->campoLista(
            'ref_cod_componente_curricular_array',
            'Componente curricular',
            ['' => 'Componente curricular'],
            $this->ref_cod_componente_curricular_array,
        );

        // BNCCs
        $todos_bncc = [];
        
        $options = [
            'label' => 'Objetivos de aprendizagem/habilidades (BNCC)',
            'required' => true,
>>>>>>> Stashed changes
            'options' => [
                'values' => $this->bncc,
                'all_values' => $todos_bncc
            ]
        ];
<<<<<<< Updated upstream

        $this->inputsHelper()->multipleSearchCustom('', $options, $helperOptions);
=======
        $this->inputsHelper()->multipleSearchCustom('bncc', $options);

        // BNCCs Especificações
        $todos_bncc_especificacoes = [];
        
        $options = [
            'label' => 'Especificações',
            'required' =>true,
            'options' => [
                'values' => $this->bncc_especificacoes,
                'all_values' => $todos_bncc_especificacoes
            ]
        ];
        $this->inputsHelper()->multipleSearchCustom('bncc_especificacoes', $options);

        $this->campoTabelaFim();
>>>>>>> Stashed changes
    }

    protected function adicionarConteudosTabela()
    {
        $obj = new clsModulesPlanejamentoAulaConteudo();
        $conteudos = $obj->lista($this->id);

<<<<<<< Updated upstream
        for ($i=0; $i < count($conteudos); $i++) { 
            $rows[$i][] = $conteudos[$i]['conteudo'];
=======
        for ($i=0; $i < count($conteudos); $i++) {
            $conteudo = $conteudos[$i];
            $rows[$conteudo['id']][] = $conteudo['conteudo'];
>>>>>>> Stashed changes
        }

        $this->campoTabelaInicio(
            'conteudos',
            'Objetivo(s) do conhecimento/conteúdo',
            [
<<<<<<< Updated upstream
                'Objetivo(s)',
=======
                'Conteúdo(s)',
>>>>>>> Stashed changes
            ],
            $rows
        );

<<<<<<< Updated upstream
        $this->campoTexto('conteudos','Conteúdos', $this->conteudo_id, 100, 2048, true);   
=======
        $this->campoTexto('conteudos', 'Conteúdos', $this->conteudo_id, 100, 2048, true);
>>>>>>> Stashed changes

        $this->campoTabelaFim();
    }

    public function Formular () {
        $this->title = 'Plano de aula - Cadastro';
        $this->processoAp = '58';
    }
};

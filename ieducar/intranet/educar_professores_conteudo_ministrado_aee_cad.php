<?php

use App\Models\LegacyDiscipline;
use App\Models\LegacyGrade;
use App\Process;
use App\Services\CheckPostedDataService;
use App\Services\iDiarioService;
use App\Services\SchoolLevelsService;
use Illuminate\Support\Arr;
use iEducar\Modules\ValueObjects\EmployeeGraduationValueObject;
use iEducar\Support\View\SelectOptions;

return new class extends clsCadastro {
    public $id;
    public $atividades;
    public $observacao;
    public $frequencia;
    public $planejamento_aula_id;
    public $conteudos;
    public $especificacoes;

    public function Inicializar () {
        $this->titulo = 'Registro de aula AEE - Cadastro';

        $retorno = 'Novo';

        $this->id = $_GET['id'];

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(58, $this->pessoa_logada, 7, 'educar_professores_conteudo_ministrado_aee_lst.php');

        if (is_numeric($this->id)) {
            $tmp_obj = new clsModulesComponenteMinistradoAee(
                $this->id
            );
            $registro = $tmp_obj->detalhe();
            
            if ($registro) {
                // passa todos os valores obtidos no registro para atributos do objeto
                foreach ($registro['detalhes'] as $campo => $val) {
                    $this->$campo = $val;
                }
                $this->conteudos = array_column($registro['conteudos'], 'planejamento_aula_conteudo_id');

                $this->fexcluir = $obj_permissoes->permissao_excluir(58, $this->pessoa_logada, 7);
                $retorno = 'Editar';

                $this->titulo = 'Frequência - Edição';
            }
            
        }
       
        $this->nome_url_cancelar = 'Cancelar';
        $this->url_cancelar = ($retorno == 'Editar')
            ? sprintf('educar_professores_conteudo_ministrado_aee_det.php?id=%d', $this->id)
            : 'educar_professores_conteudo_ministrado_aee_lst.php';

        $nomeMenu = $retorno == 'Editar' ? $retorno : 'Cadastrar';

        $this->breadcrumb($nomeMenu . ' Registro de aula - AEE', [
            url('intranet/educar_conteudo_ministrado_index.php') => 'Professores',
        ]);

        return $retorno;
    }

    public function Gerar () {
        if ($_POST) {
            foreach ($_POST as $campo => $val) {
                $this->$campo = ($this->$campo) ? $this->$campo : $val;
            }
        }

        $this->ano = date('Y');
        $this->servidor_id = $this->pessoa_logada;
        $this->campoOculto('cod_serie', 9);
        $this->campoOculto('cod_componente_curricular', 5);

       
        if (is_numeric($this->frequencia)) {
            $desabilitado = true;

            $obj = new clsModulesFrequenciaAee($this->frequencia);
            $freq = $obj->detalhe()['detalhes'];
            

            $obj = new clsModulesPlanejamentoAulaAee();
            $id = $obj->lista(
                null,
                null,
                null,
                null,
                null,
                $freq['ref_cod_turma'],
                $freq['ref_cod_componente_curricular'],
                null,
                null,
                null,
                $freq['fase_etapa'],
                $this->servidor_id
            )[0]['id'];
            
            $this->planejamento_aula_id = $id;
          
            
        }
       
        $this->campoOculto('id', $this->id);
        $this->campoMemo('conteudo', 'Registro diário de aula', $this->conteudo, 100, 5, false);
        //$this->inputsHelper()->dynamic(['frequencia'], ['frequencia' => $this->frequencia, 'disabled' => $desabilitado]);     
        $this->campoMemo('atividades', 'Registro diário de aula', $this->atividades, 100, 5, false);

        //$this->adicionarConteudosMultiplaEscolha();
        
        $this->campoMemo('observacao', 'Observação', $this->observacao, 100, 5, false);
    }

    public function Novo() {
        $obj = new clsModulesComponenteMinistradoAee(
            null,
            $this->frequencia,
            $this->atividades,
            $this->observacao,
            $this->conteudos,
            //$this->especificacoes
        );

        $cadastrou = $obj->cadastra();

        if (!$cadastrou) {
            $this->mensagem = 'Cadastro não realizado.<br>';
            $this->simpleRedirect('educar_professores_conteudo_ministrado_aee_cad.php');
        } else {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br>';
            $this->simpleRedirect('educar_professores_conteudo_ministrado_aee_lst.php');
        }

        $this->mensagem = 'Cadastro não realizado.<br>';

        return false;
    }

    public function Editar() {
        $obj = new clsModulesComponenteMinistradoAee(
            $this->id,
            null,
            $this->atividades,
            $this->observacao,
            $this->conteudos
        );

        $editou = $obj->edita();

        if ($editou) {
            $this->mensagem .= 'Edi&ccedil;&atilde;o efetuada com sucesso.<br>';
            $this->simpleRedirect('educar_professores_conteudo_ministrado_aee_lst.php');
        }

        $this->mensagem = 'Edi&ccedil;&atilde;o n&atilde;o realizada.<br>';

        return false;
    }

    public function Excluir () {
        $obj = new clsModulesComponenteMinistradoAee(
            $this->id,
        );

        $excluiu = $obj->excluir($this->id);

        if ($excluiu) {
            $this->mensagem .= 'Exclus&atilde;o efetuada com sucesso.<br>';
            $this->simpleRedirect('educar_professores_conteudo_ministrado_aee_lst.php');
        }

        $this->mensagem = 'Exclus&atilde;o n&atilde;o realizada.<br>';
        
        return false;
    }

    private function getConteudos($planejamento_aula_id = null)
    {
        if (is_numeric($planejamento_aula_id)) {
            $rows = [];

            $obj = new clsModulesPlanejamentoAulaConteudoAee();
            $conteudos = $obj->lista2($planejamento_aula_id);
           
            foreach ($conteudos as $key => $conteudo) {
                $rows[$conteudo['id']] = $conteudo['conteudo'];
            }

            return $rows;
        }
        

        return [];
    }

    public function loadAssets () {
        $scripts = [
            '/modules/Cadastro/Assets/Javascripts/PlanoAulaConteudo.js'
        ];

        Portabilis_View_Helper_Application::loadJavascript($this, $scripts);
    }

    public function __construct () {
        parent::__construct();
        $this->loadAssets();
    }

    protected function adicionarConteudosMultiplaEscolha() {
        // ESPECIFICAÇÕES
        /*$helperOptions = [
            'objectName' => 'especificacoes',
        ];

        //$todas_especificacoes = $this->getEspecificacoes($this->planejamento_aula_id);

        $options = [
            'label' => 'Especificações',
            'required' => false,
            'options' => [
                'values' => $this->especificacoes,
                'all_values' => /*$todas_especificacoes*//*[]
            ]
        ];
        $this->inputsHelper()->multipleSearchCustom('', $options, $helperOptions);*/

        // CONTEUDOS
        $helperOptions = [
            'objectName' => 'conteudos',
        ];

        $todos_conteudos = $this->getConteudos($this->planejamento_aula_id);

        $options = [
            'label' => 'Objetivo(s) do conhecimento/conteúdo',
            'required' => true,
            'options' => [
                'values' => $this->conteudos,
                'all_values' => $todos_conteudos
            ]
        ];
        $this->inputsHelper()->multipleSearchCustom('', $options, $helperOptions);
    }

    public function Formular () {
        $this->title = 'Registro de aula AEE - Cadastro';
        $this->processoAp = '58';
    }
};
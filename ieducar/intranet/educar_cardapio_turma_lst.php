<?php

use App\Models\LegacyIndividual;
use App\Models\Turma;
return new class extends clsListagem {
    /**
     * Referencia pega da session para o idpes do usuario atual
     *
     * @var int
     */
    public $pessoa_logada;
    public $data_aplicacao;
    /**
     * Titulo no topo da pagina
     *
     * @var int
     */
    public $titulo;

    /**
     * Quantidade de registros a ser apresentada em cada pagina
     *
     * @var int
     */
    public $limite;

    /**
     * Inicio dos registros a serem exibidos (limit)
     *
     * @var int
     */
    public $offset;

    public $nm_servidor;

    public function Gerar()
    {
        $this->titulo = 'Cardápio das turmas - Listagem';

        foreach ($_GET as $var => $val) {
            $this->$var = ($val === '') ? null : $val;
        }

        $this->campoOculto("pessoaLogada", $this->pessoa_logada);

        $this->inputsHelper()->dynamic(['instituicao', 'escola', 'anoLetivo', 'curso', 'cardapioCurso'], ['required' => false]);
          // data nascimento

     
          $options = [
            'required' => true,
            'label' => 'Data aplicação',
            'placeholder' => '',
            'value' => $this->data_aplicacao,
            'size' => 19
        ];

        $this->inputsHelper()->date('data_aplicacao', $options);

        // Paginador
       
        $this->addCabecalhos([
            "<input type='checkbox' id='cod_turma_checkbox[]' style='margin-left: 0px;'></input>",
            'Nome da turma ',
            'Ação',
        ]);

        $limite = 20;
        $this->limite = 20;
        $this->offset = ($_GET["pagina_{$this->nome}"]) ? $_GET["pagina_{$this->nome}"]*$this->limite-$this->limite: 0;

        $iniciolimit = ($this->getQueryString("pagina_{$this->nome}")) ? $this->getQueryString("pagina_{$this->nome}")*$limite-$limite: 0;
  
        $obj_turma = new clsModulesTurmaCardapio();
        $obj_turma->setOrderby('cod_turma ASC');
        $obj_turma->setLimite($limite, $this->offset);


        $lista = $obj_turma->lista_turmas(
         $_GET['ref_cod_curso']
        );

        if (is_countable($lista) && count($lista) > 0) {

         
        }else{
         
        }
    $total = 0;
    if(!empty($_GET['ref_cod_curso'])){
        $turma = Turma::where('ref_cod_curso', $_GET['ref_cod_curso'])->where('ref_ref_cod_escola', $_GET['ref_cod_escola'])->get();
        foreach($turma as $turma_total){
            $total ++;
        }

    }else{
        $total = 0;
        $turma =  Turma::where('ref_ref_cod_escola', $_GET['ref_cod_escola'])->get();
        foreach($turma as $turma_total){
            $total ++;
        }
    }
        // monta a lista
        if (is_array($lista) && count($lista)) {
            foreach ($lista as $registro) {
                
               
                $lista_busca = [];

                $lista_busca[] = "<input type='checkbox' id='cod_turma_checkbox[{$registro['cod_turma']}]' name='servidor_usuario_checkbox[]'></input>";

                $lista_busca[] = "<span>{$registro['nm_turma']}</span>";

               

                
                        $lista_busca[] = 
                        "
                            <button
                                id='servidor_usuario_btn[{$registro['cod_turma']}]'
                                name='servidor_usuario_btn[]'
                                style='width: 120px;'
                                class='btn btn-danger'
                                onclick='(function(e){iniciaAtivacaoUsuarioServidor(e, {$registro['cod_turma']})})(event)'
                            >
                                Remover Cardápio
                            </button>
                        ";
                  
                

                $this->addLinhas($lista_busca);
            }
        }

        $this->addPaginador2('educar_cardapio_turma_lst.php', $total, $_GET, $this->nome, $limite);
        $obj_permissoes = new clsPermissoes();

        $this->largura = '100%';

        $this->breadcrumb('Cardápios das turmas', [
            url('intranet/educar_merenda_escolar_index.php') => 'Merenda Escolar',
        ]);

        // CASO ALTERE O NOME DOS BOTÕES, DEVE CORRIGIR A LÓGICA EM SERVIDORUSUARIO.JS
        $this->array_botao[] = ['name' => 'Aplicar cardápio', 'css-extra' => 'botoes-selecao-usuarios-servidores'];
        $this->array_botao[] = ['name' => 'Aplicar para todas as turmas', 'css-extra' => 'botoes-selecao-usuarios-servidores'];
    }

    public function __construct () {
        parent::__construct();
        $this->loadAssets();
    }

    public function loadAssets () {
        $scripts = [
            '/modules/Cadastro/Assets/Javascripts/ServidorUsuario.js',
        ];

        Portabilis_View_Helper_Application::loadJavascript($this, $scripts);
    }

    public function Formular()
    {
        $this->title = 'Cardápios das turmas - Listagem';
        $this->processoAp = '9204';
    }
};

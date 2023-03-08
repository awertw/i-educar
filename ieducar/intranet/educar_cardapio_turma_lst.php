<?php

use App\Models\LegacyIndividual;
use App\Models\Turma;
use App\Models\CardapioTurma;
use App\Models\MerendaCardapio;
use App\Models\TurmaTurno;


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

        $this->inputsHelper()->input('ano', 'ano');

        $this->inputsHelper()->dynamic(['instituicao', 'escola',  'curso', 'cardapioCurso'], ['required' => true]);
          // data nascimento

     
          $options = [
            'required' => true,
            'label' => 'Data',
            'placeholder' => '',
            'value' => $this->data_aplicacao,
            'size' => 19
        ];

        $this->inputsHelper()->date('data_aplicacao', $options);

        // Paginador

        


        $cardapio = MerendaCardapio::find($_GET['ref_cod_cardapio_curso']);
        $diasemana = array("Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado");

        $dia_sem = str_replace("/", "-", $_GET['data_aplicacao']);

        $dia_sem= date('Y-m-d',  strtotime( $dia_sem));               
  
        $diasemana_numero = date('w', strtotime($dia_sem));

    if($diasemana[$diasemana_numero]!=$cardapio['dia_semana']){
        $acao = "Ação <br> <br>
        <b style='color:red'>Não é possivel aplicar o cardápio na data selecionada <br> dia disponível: {$cardapio['dia_semana']}<br>dia especificado: {$diasemana[$diasemana_numero]} </b>";
    }else{
        $acao =   "Ação";  
    }
       
        $this->addCabecalhos([
           
            'Nome da turma ',
            'Cardápio ',
            'Status',
            $acao,
        ]);
        

        $limite = 20;
        $this->limite = 20;
        $this->offset = ($_GET["pagina_{$this->nome}"]) ? $_GET["pagina_{$this->nome}"]*$this->limite-$this->limite: 0;

        $iniciolimit = ($this->getQueryString("pagina_{$this->nome}")) ? $this->getQueryString("pagina_{$this->nome}")*$limite-$limite: 0;
  
        $obj_turma = new clsModulesTurmaCardapio();
        $obj_turma->setOrderby('cod_turma ASC');
        $obj_turma->setLimite($limite, $this->offset);
        $id_turno = "";

        if(!empty($_GET['ref_cod_cardapio_curso']) and !empty($_GET['ref_cod_curso']) and !empty($_GET['data_aplicacao'])){
        
            $cardapio = MerendaCardapio::find($_GET['ref_cod_cardapio_curso']);
            $id_turno =  $cardapio->cod_turno;
        
        }
        $lista = $obj_turma->lista_turmas(
         $_GET['ref_cod_curso'],  $_GET['ano'], $id_turno, $_GET['ref_cod_escola']
        );

       
        $total = 0;
        if(!empty($_GET['ref_cod_cardapio_curso']) and !empty($_GET['ref_cod_curso']) and !empty($_GET['data_aplicacao'])){
            $cardapio = MerendaCardapio::find($_GET['ref_cod_cardapio_curso']);
            $turma =  Turma::where('ref_ref_cod_escola', $_GET['ref_cod_escola'])->where('ano', $_GET['ano'])->where('ref_cod_curso', $_GET['ref_cod_curso'])->where('turma_turno_id', $cardapio->cod_turno)->get();    
            foreach($turma as $turma_total){
            $total ++;
           
        }

        }else{
            $total = 0;
           if(!empty($_GET['ref_cod_escola'])){

                $turma =  Turma::where('ref_ref_cod_escola', $_GET['ref_cod_escola'])->where('ano', $_GET['ano'])->get();    
            }else{
                $turma =  Turma::where('ano', $_GET['ano'])->get();
            }
        
            foreach($turma as $turma_total){
                $total ++;
            }
        }
        // monta a lista
        if (is_array($lista) && count($lista)) {
            foreach ($lista as $registro) {
                
               
                $lista_busca = [];


                $lista_busca[] = "<span>{$registro['nm_turma']}</span>";

                            
              

                if(!empty($_GET['ref_cod_cardapio_curso']) and !empty($_GET['ref_cod_curso']) and !empty($_GET['data_aplicacao'])){

                    $cardapio = MerendaCardapio::find($_GET['ref_cod_cardapio_curso']);
                    $turnos = TurmaTurno::find($cardapio->cod_turno);
                    $lista_busca[] = "<span>{$cardapio['descricao']} ({$turnos['nome']})</span>";

                }else{
                    $lista_busca[] = "";
                }
                
    
       

               
               
                if(!empty($_GET['ref_cod_cardapio_curso']) and !empty($_GET['ref_cod_curso']) and !empty($_GET['data_aplicacao'])){
                    $dia_sem = str_replace("/", "-", $_GET['data_aplicacao']);
                    $dia_sem= date('Y-m-d',  strtotime( $dia_sem));   

                   $cardapioTurmas = CardapioTurma::where('cod_turma', $registro['cod_turma'])->where('cod_cardapio', $_GET['ref_cod_cardapio_curso'])->where('data', $dia_sem)->get();
                }
                $contador = 0;
                $id_cardapio = 0;
                foreach( $cardapioTurmas as  $cardapioTurma){
                    $contador++;
                    $id_cardapio = $cardapioTurma['id'];
                }
                if(!empty($_GET['ref_cod_cardapio_curso']) and !empty($_GET['ref_cod_curso']) and !empty($_GET['data_aplicacao']) ){

                    $diasemana = array("Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado");

                    $dia_sem= date('d/m/Y',  strtotime($_GET['data_aplicacao']));               
              
                    $diasemana_numero = date('w', strtotime($dia_sem));
                    
    
                if($contador>0){
                    $lista_busca[] = "<span>Aplicado</span>";
                    $lista_busca[] = 
                    "
                        <a
                            id='turma_cardapio[{$registro['cod_turma']}]'
                            
                            style='width: 120px;'
                            class='btn btn-danger'
                            href='educar_desfazer_cardapio.php?cod_cardapio_turma=".$id_cardapio."'


                        >
                         <b>x</b> ".$_GET['data_aplicacao']."  Desfazer 
                        </a>
                         ";
                }else{
                    $lista_busca[] = "<span>Não Aplicado</span>";
                    $cardapio = MerendaCardapio::find($_GET['ref_cod_cardapio_curso']);

                    $dia_sem = str_replace("/", "-", $_GET['data_aplicacao']);

                    $dia_sem= date('Y-m-d',  strtotime( $dia_sem));               
            
                    $diasemana_numero = date('w', strtotime($dia_sem));

                    if($diasemana[$diasemana_numero]!=$cardapio['dia_semana']){
                        $lista_busca[] = 
                        "";
                    }else{
                        $lista_busca[] = 
                        "
                        <a
                                id='turma_cardapio[{$registro['cod_turma']}]'
                                style='width: 120px;'
                                class='btn btn-success'
                                href='educar_aplicar_cardapio.php?cod_turma=".$registro['cod_turma']."&cod_escola=".$_GET['ref_cod_escola']."&ano=".$_GET['ano']."&data_aplicacao=".$_GET['data_aplicacao']."&cod_cardapio=".$_GET['ref_cod_cardapio_curso']."&cod_turno=".$cardapio->cod_turno."'
    
                            >
                                Aplicar cardápio
                            </a>
                        ";
                    }
                  

                }
            }else{ $lista_busca[] = ""; $lista_busca[] = "";}

                      
                  
                

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
        if(!empty($_GET['ref_cod_cardapio_curso']) and !empty($_GET['ref_cod_curso']) and !empty($_GET['data_aplicacao'])){
            $cardapio = MerendaCardapio::find($_GET['ref_cod_cardapio_curso']);
          

        $this->array_botao_url[] ="educar_aplicar_todos_cardapio.php?cod_curso=".$_GET['ref_cod_curso']."&cod_escola=".$_GET['ref_cod_escola']."&ano=".$_GET['ano']."&data_aplicacao=".$_GET['data_aplicacao']."&cod_cardapio=".$_GET['ref_cod_cardapio_curso']."&cod_turno=".$cardapio->cod_turno;

        $this->array_botao[] = ['name' => 'Aplicar para todas as turmas', 'css-extra' => 'btn-green'];
        }
      
    }

    public function __construct () {
        parent::__construct();
        $this->loadAssets();
    }

    public function loadAssets () {
        $scripts = [
            '/modules/Cadastro/Assets/Javascripts/CardapioTurma.js',
        ];

        Portabilis_View_Helper_Application::loadJavascript($this, $scripts);
    }

    public function Formular()
    {
        $this->title = 'Cardápios das turmas - Listagem';
        $this->processoAp = '9204';
    }
};

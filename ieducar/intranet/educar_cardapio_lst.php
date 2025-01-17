<?php
use iEducar\Legacy\Model;
use App\Models\MerendaCardapio;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\Curso;
use App\Models\CardapioCurso;
 
return new class extends clsListagem {
  
   public $limite;
   public $offset;
   public $inativo;
   public $pessoa_logada;
   public $id;
   public $produto;
   public $descricao;
   public $retorno;
 
 
 
   public function Gerar()
   {
   
       $this->titulo = 'Cardápio - Listagem';
 
       foreach ($_GET as $var => $val) { // passa todos os valores obtidos no GET para atributos do objeto
           $this->$var = ($val === '') ? null: $val;
       }

       if($_GET['inativo']=="on"){
        $inativo = 1;
       }else{
        $inativo = null;

       }
       $options = ['label' => 'Inativo', 'required' => false, 'value' => dbBool($inativo)];

       $this->inputsHelper()->checkbox('inativo', $options);

       $this->campoTexto('descricao', 'Descrição', $_GET['descricao'], '50', '255', false);
     
      
       $selectOptionsdiaSemana = [];

       
       
   
       $selectOptionsdiaSemana[1] = "Segunda-Feira";
       $selectOptionsdiaSemana[2] = "Terça-Feira";
       $selectOptionsdiaSemana[3] = "Quarta-Feira";
       $selectOptionsdiaSemana[4] = "Quinta-Feira";
       $selectOptionsdiaSemana[5] = "Sexta-Feira";
       $selectOptionsdiaSemana[6] = "Sábado";
       $selectOptionsdiaSemana[7] = "Domingo";

  
  


   $selectOptionsdiaSemana = array_replace([null => 'Selecione'], $selectOptionsdiaSemana);

 
   $this->campoLista('dia_semana', 'Dia da Semana', $selectOptionsdiaSemana, $_GET['dia_semana'], '', true, '', '', '', '');


   

 
      
 
  
 
 
       $this->largura = '100%';
      
 

       $lista_busca = [
           'Código do Cardápio',
           'Dia da Semana',
           'Descrição',
           'Cursos',
           'Preparo',
          
       ];
 
       $obj_permissoes = new clsPermissoes();
       $nivel_usuario = $obj_permissoes->nivel_acesso($this->pessoa_logada);
      
       $this->addCabecalhos($lista_busca);
 
       // Filtros de Foreign Keys
  
 
       // primary keys
  
 
 
      
       // Paginador
       $limite = 20;
       $iniciolimit = ($this->getQueryString("pagina_{$this->nome}")) ? $this->getQueryString("pagina_{$this->nome}")*$limite-$limite: 0;
 
       $obj_MerendaCardapio = new clsModulesMerendaCardapio();
       $obj_MerendaCardapio->setOrderby('merenda_cardapio.id ASC');
       $obj_MerendaCardapio->setLimite($limite, $iniciolimit);
 
       $lista = $obj_MerendaCardapio->lista_cardapios();
     
 
     
 
        if(!empty($_GET['descricao']) and empty($_GET['dia_semana'])){
               $cardapios = MerendaCardapio::where('descricao', $_GET['descricao'])->where('inativo', $inativo)->get();
              
       }elseif(!empty($_GET['dia_semana']) and empty($_GET['descricao'])  ){
        $dia = "";
        if($_GET['dia_semana']==1){
            $dia = "Segunda-Feira";
        }elseif($_GET['dia_semana']==2){
            $dia = "Terça-Feira";
        }elseif($_GET['dia_semana']==3){
            $dia = "Quarta-Feira";
        }elseif($_GET['dia_semana']==4){
            $dia = "Quinta-Feira";
        }elseif($_GET['dia_semana']==5){
            $dia = "Sexta-Feira";
        }elseif($_GET['dia_semana']==6){
            $dia = "Sábado";
        }elseif($_GET['dia_semana']==7){
            $dia = "Domingo";
        } 
        $cardapios = MerendaCardapio::where('dia_semana', $dia)->where('inativo', $inativo)->get();
       
        }elseif(!empty($_GET['dia_semana']) and !empty($_GET['descricao'])  ){
            $dia = "";
            if($_GET['dia_semana']==1){
                $dia = "Segunda-Feira";
            }elseif($_GET['dia_semana']==2){
                $dia = "Terça-Feira";
            }elseif($_GET['dia_semana']==3){
                $dia = "Quarta-Feira";
            }elseif($_GET['dia_semana']==4){
                $dia = "Quinta-Feira";
            }elseif($_GET['dia_semana']==5){
                $dia = "Sexta-Feira";
            }elseif($_GET['dia_semana']==6){
                $dia = "Sábado";
            }elseif($_GET['dia_semana']==7){
                $dia = "Domingo";
            } 
            $cardapios = MerendaCardapio::where('dia_semana', $dia)->where('descricao', $_GET['descricao'])->where('inativo', $inativo)->get();
           
            }
       else{
           $total = 0;
           $cardapios_total =  MerendaCardapio::where('inativo', $inativo)->get();
           foreach($cardapios_total as $cardapio_total){
               $total ++;
           }
            $cardapios =  $obj_MerendaCardapio->lista_cardapios();
  
    
 
 
 }
 
    
     
       foreach($cardapios as $cardapio){

        $lista_produtos = "<ul style='list-style-type: none;'>";
        $cardapioCursos = CardapioCurso::where('cod_cardapio', $cardapio['id'])->get();
        $contador_unidades= 0;

        foreach($cardapioCursos as $cardapioCurso){

            $produtos = Curso::where('cod_curso', $cardapioCurso['cod_curso'])->get();

            foreach($produtos as $produto){
                $lista_produtos .= "<li  style='border: 1px solid grey; padding: 5px; background:white;'><b>".$produto['nm_curso']."</b></li>";
            }
        
        
        }
        $lista_produtos .= "</ul>";
  

         
         
               $lista_busca = [
                   "<a href='educar_cardapio_det.php?id=".$cardapio['id']."' >".$cardapio['id']." </a>",
                   "<a href='educar_cardapio_det.php?id=".$cardapio['id']."' >".$cardapio['dia_semana']." </a>",
                   "<a href='educar_cardapio_det.php?id=".$cardapio['id']."' >".$cardapio['descricao']."</a>",
                   "<div >".$lista_produtos."</div>",  
                   "<a style='max-width:350px' href='educar_cardapio_det.php?id=".$cardapio['id']."' >".$cardapio['preparo']."</a>",
                  
                 
               ];
 
             
               $this->addLinhas($lista_busca);
           }
      
         
         
  
       $obj_permissoes = new clsPermissoes();
       if ($obj_permissoes->permissao_cadastra(9204, $this->pessoa_logada, 3)) {
           $this->acao = 'go("educar_cardapio_cad.php")';
           $this->nome_acao = 'Novo';
       }
 
     
       $this->largura = '100%';
       $this->addPaginador2('educar_cardapio_lst.php', $total, $_GET, $this->nome, $limite);
       $this->breadcrumb('Listagem de Cardápios', [
           url('intranet/educar_cardapio_lst.php') => 'Cardápio',
       ]);
      
   }
 
   
 
 
   public function Formular()
   {
       $this->title = 'Cardápio';
       $this->processoAp = '9204';
   }
};
 


<?php
use iEducar\Legacy\Model;
use App\Models\Unidade;
use App\Models\Serie;
use App\Models\UnidadeCurricular;
use App\Models\unidadeSeries;
 
return new class extends clsListagem {
  
   public $limite;
   public $offset;
   public $inativo;
   public $pessoa_logada;
   public $id;
   public $unidade;
   public $descricao;
   public $retorno;
 
 
 
   public function Gerar()
   {
   
       $this->titulo = 'Unidade - Listagem';
 
       foreach ($_GET as $var => $val) { // passa todos os valores obtidos no GET para atributos do objeto
           $this->$var = ($val === '') ? null: $val;
       }
 
     
   
 
       $this->campoTexto('descricao', 'Descrição', $this->descricao, '50', '255', false);
 
  
 
 
       $this->largura = '100%';
      
 

       $lista_busca = [
           'Codigo da Unidade',
           'Descrição',
           'Unidade'
          
       ];
 
       $obj_permissoes = new clsPermissoes();
       $nivel_usuario = $obj_permissoes->nivel_acesso($this->pessoa_logada);
      
       $this->addCabecalhos($lista_busca);
 
       // Filtros de Foreign Keys
  
 
       // primary keys
  
 
 
      
       // Paginador
       $limite = 20;
       $iniciolimit = ($this->getQueryString("pagina_{$this->nome}")) ? $this->getQueryString("pagina_{$this->nome}")*$limite-$limite: 0;
 
       $obj_Unidade = new clsModulesUnidade();
       $obj_Unidade->setOrderby('unidade.id ASC');
       $obj_Unidade->setLimite($limite, $iniciolimit);
 
       $lista = $obj_Unidade->lista_unidades();
     
 
     
 
       if(!empty($_GET['unidade'])){
           $unidades = Unidade::where('unidade', $_GET['unidade'])->get();
          
       }elseif(!empty($_GET['descricao'])  ){
               $unidades = Unidade::where('descricao', $_GET['descricao'])->get();
              
       }elseif(!empty($_GET['unidade']) and empty($_GET['descricao'])  ){
           $unidades = Unidade::where('unidade', $_GET['unidade'])->where('descricao', $_GET['descricao'])->get();
          
       }else{
           $total = 0;
           $unidades_total =  Unidade::all();
           foreach($unidades_total as $unidade_total){
               $total ++;
           }
            $unidades =  $obj_Unidade->lista_unidades();
  
    
 
 
 }
 
    
     
       foreach($unidades as $unidade){

         
         
               $lista_busca = [
                   "<a href='educar_unidade_det.php?id=".$unidade['id']."' >".$unidade['id']." </a>",
                   "<a href='educar_unidade_det.php?id=".$unidade['id']."' >".$unidade['descricao']."</a>",
                   "<a href='educar_unidade_det.php?id=".$unidade['id']."' >".$unidade['unidade']."</a>"
                  
                 
               ];
 
             
               $this->addLinhas($lista_busca);
           }
      
         
         
  
       $obj_permissoes = new clsPermissoes();
       if ($obj_permissoes->permissao_cadastra(9204, $this->pessoa_logada, 3)) {
           $this->acao = 'go("educar_unidade_cad.php")';
           $this->nome_acao = 'Novo';
       }
 
     
       $this->largura = '100%';
       $this->addPaginador2('educar_unidade_lst.php', $total, $_GET, $this->nome, $limite);
       $this->breadcrumb('Listagem de Unidade', [
           url('intranet/educar_unidade_lst.php') => 'Unidade',
       ]);
      
   }
 
   
 
 
   public function Formular()
   {
       $this->title = 'Unidade';
       $this->processoAp = '9204';
   }
};
 


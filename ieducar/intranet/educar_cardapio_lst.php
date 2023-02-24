<?php
use iEducar\Legacy\Model;
use App\Models\Produto;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\produtoSeries;
use App\Models\Unidade;
use App\Models\UnidadeProduto;
 
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
   
       $this->titulo = 'Produto - Listagem';
 
       foreach ($_GET as $var => $val) { // passa todos os valores obtidos no GET para atributos do objeto
           $this->$var = ($val === '') ? null: $val;
       }
       $this->campoTexto('descricao', 'Descrição', $this->descricao, '50', '255', false);
     
      
  

 
      
 
  
 
 
       $this->largura = '100%';
      
 

       $lista_busca = [
           'Codigo do Produto',
           'Descrição',
           'Unidades'
          
       ];
 
       $obj_permissoes = new clsPermissoes();
       $nivel_usuario = $obj_permissoes->nivel_acesso($this->pessoa_logada);
      
       $this->addCabecalhos($lista_busca);
 
       // Filtros de Foreign Keys
  
 
       // primary keys
  
 
 
      
       // Paginador
       $limite = 20;
       $iniciolimit = ($this->getQueryString("pagina_{$this->nome}")) ? $this->getQueryString("pagina_{$this->nome}")*$limite-$limite: 0;
 
       $obj_Produto = new clsModulesMerendaProduto();
       $obj_Produto->setOrderby('merenda_produto.id ASC');
       $obj_Produto->setLimite($limite, $iniciolimit);
 
       $lista = $obj_Produto->lista_produtos();
     
 
     
 
       if(!empty($_GET['unidade'])){
           $produtos = Produto::where('unidade', $_GET['unidade'])->get();
          
       }elseif(!empty($_GET['descricao'])  ){
               $produtos = Produto::where('descricao', $_GET['descricao'])->get();
              
       }elseif(!empty($_GET['unidade']) and empty($_GET['descricao'])  ){
           $produtos = Produto::where('unidade', $_GET['unidade'])->where('descricao', $_GET['descricao'])->get();
          
       }else{
           $total = 0;
           $produtos_total =  Produto::all();
           foreach($produtos_total as $produto_total){
               $total ++;
           }
            $produtos =  $obj_Produto->lista_produtos();
  
    
 
 
 }
 
    
     
       foreach($produtos as $produto){

        $lista_unidades = "<ul>";
        $unidadesProdutos = UnidadeProduto::where('cod_produto', $produto['id'])->get();
        $contador_unidades= 0;

        foreach($unidadesProdutos as $unidade_prod){

            $unidades = Unidade::where('id', $unidade_prod['cod_unidade'])->get();

            foreach($unidades as $unidade){
                $lista_unidades .= "<li>".$unidade['unidade']."</li>";
            }
        
        
        }
        $lista_unidades .= "</ul>";
  

         
         
               $lista_busca = [
                   "<a href='educar_produto_det.php?id=".$produto['id']."' >".$produto['id']." </a>",
                   "<a href='educar_produto_det.php?id=".$produto['id']."' >".$produto['descricao']."</a>",
                   "<a href='educar_produto_det.php?id=".$produto['id']."' >".$lista_unidades."</a>"
                  
                 
               ];
 
             
               $this->addLinhas($lista_busca);
           }
      
         
         
  
       $obj_permissoes = new clsPermissoes();
       if ($obj_permissoes->permissao_cadastra(9204, $this->pessoa_logada, 3)) {
           $this->acao = 'go("educar_produto_cad.php")';
           $this->nome_acao = 'Novo';
       }
 
     
       $this->largura = '100%';
       $this->addPaginador2('educar_produto_lst.php', $total, $_GET, $this->nome, $limite);
       $this->breadcrumb('Listagem de Produto', [
           url('intranet/educar_produto_lst.php') => 'Produto',
       ]);
      
   }
 
   
 
 
   public function Formular()
   {
       $this->title = 'Produtos da Merenda';
       $this->processoAp = '9204';
   }
};
 


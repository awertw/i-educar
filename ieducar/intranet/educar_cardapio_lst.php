<?php
use iEducar\Legacy\Model;
use App\Models\MerendaCardapio;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\Produto;
use App\Models\CardapioProduto;
 
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
       $this->campoTexto('descricao', 'Descrição', $this->descricao, '50', '255', false);
     
      
  

 
      
 
  
 
 
       $this->largura = '100%';
      
 

       $lista_busca = [
           'Codigo do Cardápio',
           'Descrição',
           'Produtos'
          
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
     
 
     
 
        if(!empty($_GET['descricao'])  ){
               $cardapios = MerendaCardapio::where('descricao', $_GET['descricao'])->get();
              
       }else{
           $total = 0;
           $cardapios_total =  MerendaCardapio::all();
           foreach($cardapios_total as $cardapio_total){
               $total ++;
           }
            $cardapios =  $obj_MerendaCardapio->lista_cardapios();
  
    
 
 
 }
 
    
     
       foreach($cardapios as $cardapio){

        $lista_produtos = "<ul style='list-style-type: none;'>";
        $cardapioProdutos = CardapioProduto::where('cod_cardapio', $cardapio['id'])->get();
        $contador_unidades= 0;

        foreach($cardapioProdutos as $cardapioProduto){

            $produtos = Produto::where('id', $cardapioProduto['cod_produto'])->get();

            foreach($produtos as $produto){
                $lista_produtos .= "<li  style='border: 1px solid grey; padding: 5px; background:white;'><b>".$produto['descricao']."</b></li>";
            }
        
        
        }
        $lista_produtos .= "</ul>";
  

         
         
               $lista_busca = [
                   "<a href='educar_cardapio_det.php?id=".$cardapio['id']."' >".$cardapio['id']." </a>",
                   "<a href='educar_cardapio_det.php?id=".$cardapio['id']."' >".$cardapio['descricao']."</a>",
                   "<div >".$lista_produtos."</div>"
                  
                 
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
 


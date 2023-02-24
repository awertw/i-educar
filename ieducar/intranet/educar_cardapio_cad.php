<?php
 
use iEducar\Legacy\Model;
use App\Models\MerendaCardapio;
use App\Models\CardapioProduto;
use App\Models\Produto;

return new class extends clsCadastro {

    public $pessoa_logada;
    public $instituicao_id;
    public $id;
    public $produto;
    public $descricao;
    public $produto_ids;

   
    public function Inicializar(){
        $retorno = 'Novo';

        $this->id=$_GET['id'];

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(
            9206,
            $this->pessoa_logada,
            3,
            'educar_cardapio_lst.php'
        );

        if (is_numeric($this->id)) {
            $retorno = 'Editar';

            $cardapio = MerendaCardapio::find($this->id);

            if ($cardapio) {
                    $this->descricao = $cardapio->descricao;
                    $this->unidade = $cardapio->unidade;
                   
           }
         
              
                $this->fexcluir = $obj_permissoes->permissao_excluir(
                    9204,
                    $this->pessoa_logada,
                    3
                );
            }
        

        $this->url_cancelar = 'educar_cardapio_lst.php';

        $this->breadcrumb('Cardápio', [
        url('intranet/educar_index.php') => 'Cardápio',
    ]);

        $this->nome_url_cancelar = 'Cancelar';


        $this->retorno = $retorno;

        return $retorno;
    }

    public function Gerar()
    {
       
      
        $this->campoTexto('descricao', 'Descrição', $this->descricao, '50', '255', true);
       
        $selectOptionsProduto = [];
 
        $produtos = Produto::all();
        $a = array();
        $b = array();

        foreach($produtos as $produto){
            array_push($a, $produto['id']);
            array_push($b, $produto['id']." - ".$produto['descricao']);
          
         }
       
           
                
        
        $c = array_combine($a, $b);
        $options = [
            'label' => 'Produtos',
            'required' => true,
            'size' => 50,
            'value' => $this->$produto_ids,
            'options' => [
                'all_values' =>$c
            ]
        ];
        $this->inputsHelper()->multipleSearchCustom('', $options, $helperOptions);
      
  
       
   
       
     
 
    }

    public function Novo(){
        $data = MerendaCardapio::latest('id')->first();
        $id_cardapio = $data->id + 1;


   
            $cadastrou =   MerendaCardapio::create( [
                'id' => $id_cardapio,
                'descricao' => $this->descricao
               
              ]);
       
              $this->produto_ids  = $_POST['custom'];
              
              foreach ($this->produto_ids as $produto_id ) {
          
                CardapioProduto::create([
                     
                      'cod_cardapio' => $id_cardapio,
                      'cod_produto' => $produto_id
                     
                    ]);
                
              }

       
        

     
    
            

        

       
       
        if ($cadastrou) {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br />';
            $this->simpleRedirect('educar_cardapio_det.php?id='.$id_cardapio);
        }

        
    
    }

    public function Editar()
    {
     
       
        MerendaCardapio::where('id', $_GET['id'])->update([
            'descricao' => $this->descricao
          
          
        ]);

        CardapioProduto::where('cod_cardapio', $_GET['id'])->delete(); 
        
        $this->unidade_ids  = $_POST['custom'];
              
        foreach ($this->unidade_ids as $produto_id ) {
    
            CardapioProduto::create([
               
                'cod_cardapio' => $_GET['id'],
                'cod_produto' => $produto_id
               
              ]);
          
        }
        

      
        $this->simpleRedirect('educar_cardapio_det.php?id='.$_GET['id']);
    }

    public function Excluir()
    {
       
        Produto::where('id', $_GET['id'])->delete(); 
        $this->mensagem .= 'Exclusão efetuada com sucesso.<br>';
        $this->simpleRedirect('educar_cardapio_lst.php');
    }

    public function Formular()
    {
        $this->title = 'Cardápio';
        $this->processoAp = '9204';
    }
};

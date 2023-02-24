<?php
 
use iEducar\Legacy\Model;
use App\Models\Produto;
use App\Models\Unidade;
use App\Models\UnidadeProduto;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\produtoSeries;
use App\Models\EspecificacaoBncc;

return new class extends clsCadastro {

    public $pessoa_logada;
    public $instituicao_id;
    public $id;
    public $unidade;
    public $descricao;
    public $unidade_ids;

   
    public function Inicializar(){
        $retorno = 'Novo';

        $this->id=$_GET['id'];

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(
            9206,
            $this->pessoa_logada,
            3,
            'educar_produto_lst.php'
        );

        if (is_numeric($this->id)) {
            $retorno = 'Editar';

            $produto = Produto::find($this->id);

            if ($produto) {
                    $this->descricao = $produto->descricao;
                    $this->unidade = $produto->unidade;
                   
           }
         
              
                $this->fexcluir = $obj_permissoes->permissao_excluir(
                    9204,
                    $this->pessoa_logada,
                    3
                );
            }
        

        $this->url_cancelar = 'educar_produto_lst.php';

        $this->breadcrumb('produto', [
        url('intranet/educar_index.php') => 'Merenda Escolar',
    ]);

        $this->nome_url_cancelar = 'Cancelar';


        $this->retorno = $retorno;

        return $retorno;
    }

    public function Gerar()
    {
       
      
        $this->campoTexto('descricao', 'Descrição', $this->descricao, '50', '255', true);
       
        $selectOptionsUnidade = [];
 
        $unidades = Unidade::all();
        $a = array();
        $b = array();

        foreach($unidades as $unidade){
            array_push($a, $unidade['id']);
            array_push($b, $unidade['descricao']." - ".$unidade['unidade']);
          
         }
       
           
                
        
        $c = array_combine($a, $b);
        $options = [
            'label' => 'Unidades',
            'required' => true,
            'size' => 50,
            'value' => $this->$unidade_ids,
            'options' => [
                'all_values' =>$c
            ]
        ];
        $this->inputsHelper()->multipleSearchCustom('', $options, $helperOptions);
      
  
       
   
       
     
 
    }

    public function Novo(){
        $data = Produto::latest('id')->first();
        $id_produto = $data->id + 1;


   
            $cadastrou =   Produto::create( [
                'id' => $id_produto,
                'descricao' => $this->descricao
               
              ]);
       
              $this->unidade_ids  = $_POST['custom'];
              
              foreach ($this->unidade_ids as $unidade_id ) {
          
                  UnidadeProduto::create([
                     
                      'cod_produto' => $id_produto,
                      'cod_unidade' => $unidade_id
                     
                    ]);
                
              }

       
        

     
    
            

        

       
       
        if ($cadastrou) {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br />';
            $this->simpleRedirect('educar_produto_det.php?id='.$id_produto);
        }

        
    
    }

    public function Editar()
    {
     
       
        Produto::where('id', $_GET['id'])->update([
            'descricao' => $this->descricao
          
          
        ]);

        UnidadeProduto::where('cod_produto', $_GET['id'])->delete(); 
        
        $this->unidade_ids  = $_POST['custom'];
              
        foreach ($this->unidade_ids as $unidade_id ) {
    
            UnidadeProduto::create([
               
                'cod_produto' => $_GET['id'],
                'cod_unidade' => $unidade_id
               
              ]);
          
        }
        

      
        $this->simpleRedirect('educar_produto_det.php?id='.$_GET['id']);
    }

    public function Excluir()
    {
       
        Produto::where('id', $_GET['id'])->delete(); 
        $this->mensagem .= 'Exclusão efetuada com sucesso.<br>';
        $this->simpleRedirect('educar_produto_lst.php');
    }

    public function Formular()
    {
        $this->title = 'Produto';
        $this->processoAp = '9204';
    }
};

<?php
 
use iEducar\Legacy\Model;
use App\Models\Produto;
use App\Models\Unidade;
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
        foreach($unidades as $unidade){
      
            $selectOptionsUnidade[$unidade['unidade']] = $unidade['descricao']." - ".$unidade['unidade'];
           
         }
      
  
        $selectOptionsUnidade = Portabilis_Array_Utils::sortByValue($selectOptionsUnidade);
        $selectOptionsUnidade = array_replace([null => 'Selecione'], $selectOptionsUnidade);
  
  
     
  
        $this->campoLista('unidade', 'Unidade', $selectOptionsUnidade, $this->unidade, '', true, '', '', '', '');
   
       
     
 
    }

    public function Novo(){
        $data = Produto::latest('id')->first();
        $id_produto = $data->id + 1;


   
            $cadastrou =   Produto::create( [
                'id' => $id_produto,
                'descricao' => $this->descricao,
                'unidade' => $this->unidade
               
              ]);
       
        
       
        

     
    
            

        

       
       
        if ($cadastrou) {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br />';
            $this->simpleRedirect('educar_produto_lst.php' . $this->ref_cod_matricula);
        }

        
    
    }

    public function Editar()
    {
     
       
        Produto::where('id', $_GET['id'])->update([
            'descricao' => $this->descricao,
            'unidade' => $this->unidade
          
        ]);
       
        

      
        $this->simpleRedirect('educar_produto_lst.php');
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

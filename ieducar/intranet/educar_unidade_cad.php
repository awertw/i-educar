<?php
 
use iEducar\Legacy\Model;
use App\Models\Unidade;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\unidadeSeries;
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
            'educar_unidade_lst.php'
        );

        if (is_numeric($this->id)) {
            $retorno = 'Editar';

            $unidade = Unidade::find($this->id);

            if ($unidade) {
                    $this->descricao = $unidade->descricao;
                    $this->unidade = $unidade->unidade;
                   
           }
         
              
                $this->fexcluir = $obj_permissoes->permissao_excluir(
                    9204,
                    $this->pessoa_logada,
                    3
                );
            }
        

        $this->url_cancelar = 'educar_unidade_lst.php';

        $this->breadcrumb('unidade', [
        url('intranet/educar_index.php') => 'Merenda Escolar',
    ]);

        $this->nome_url_cancelar = 'Cancelar';


        $this->retorno = $retorno;

        return $retorno;
    }

    public function Gerar()
    {
       
        $this->campoTexto('unidade', 'Unidade', $this->unidade, '50', '255', true); 
        $this->campoTexto('descricao', 'Descrição', $this->descricao, '50', '255', true);
       
       
       
     
 
    }

    public function Novo(){
        $data = Unidade::latest('id')->first();
        $id_unidade = $data->id + 1;


   
            $cadastrou =   Unidade::create( [
                'id' => $id_unidade,
                'descricao' => $this->descricao,
                'unidade' => $this->unidade
               
              ]);
       
        
       
        

     
    
            

        

       
       
        if ($cadastrou) {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br />';
            $this->simpleRedirect('educar_unidade_lst.php' . $this->ref_cod_matricula);
        }

        
    
    }

    public function Editar()
    {
     
       
        Unidade::where('id', $_GET['id'])->update([
            'descricao' => $this->descricao,
            'unidade' => $this->unidade
          
        ]);
       
        

      
        $this->simpleRedirect('educar_unidade_lst.php');
    }

    public function Excluir()
    {
       
        Unidade::where('id', $_GET['id'])->delete(); 
        $this->mensagem .= 'Exclusão efetuada com sucesso.<br>';
        $this->simpleRedirect('educar_unidade_lst.php');
    }

    public function Formular()
    {
        $this->title = 'Unidade';
        $this->processoAp = '9204';
    }
};

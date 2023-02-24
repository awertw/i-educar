<?php
use iEducar\Legacy\Model;
use App\Models\Produto;
use App\Models\Unidade;
use App\Models\UnidadeProduto;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\produtoSeries;
use App\Models\EspecificacaoBncc;

return new class extends clsDetalhe {
    /**
     * Titulo no topo da pagina
     *
     * @var int
     */
    public $titulo;
    public $id;
    public $unidade;
    public $descricao;

    public $idpes_exc;
    public $idpes_cad;
    public $nm_raca;
    public $data_cadastro;
    public $data_exclusao;
    public $ativo;
    public $pessoa_logada;

    public function Gerar()
    {
        $this->titulo = 'Produto - Detalhes';

        $this->id=$_GET['id'];
        $produto = Produto::find($this->id);
        if (! $produto) {
            $this->simpleRedirect('educar_produto_lst.php');
        }

        $lista_unidades = "<ul>";
        $unidadesProdutos = UnidadeProduto::where('cod_produto', $produto->id)->get();
        $contador_unidades= 0;

        foreach($unidadesProdutos as $unidade_prod){

            $unidades = Unidade::where('id', $unidade_prod['cod_unidade'])->get();

            foreach($unidades as $unidade){
                $lista_unidades .= "<li>".$unidade['unidade']."</li>";
            }
        
        
        }
        $lista_unidades .= "</ul>";
  

    


           $this->addDetalhe([ 'Código', $produto->id]);
           $this->addDetalhe([ 'Unidades', $lista_unidades]);
           $this->addDetalhe([ 'Descrição', $produto->descricao]);
           
       

        $obj_permissao = new clsPermissoes();
        if ($obj_permissao->permissao_cadastra(9206, $this->pessoa_logada, 7)) {
            $this->url_novo = 'educar_produto_cad.php';
            $this->url_editar = "educar_produto_cad.php?id={$this->id}";
        }

        $this->url_cancelar = 'educar_produto_lst.php';
        $this->largura = '100%';

        $this->breadcrumb('Detalhe do Produto', [
            url('intranet/educar_produto_lst.php') => 'Merenda Escolar',
        ]);
    }

    public function Formular()
    {
        $this->title = 'Detalhes Produto';
        $this->processoAp = '9204';
    }
};

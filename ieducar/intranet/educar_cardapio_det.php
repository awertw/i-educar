<?php
use iEducar\Legacy\Model;
use App\Models\MerendaCardapio;
use App\Models\CardapioProduto;
use App\Models\Produto;

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
    public $ativo;
    public $pessoa_logada;

    public function Gerar()
    {
        $this->titulo = 'Cardápio - Detalhes';

        $this->id=$_GET['id'];
        $cardapio = MerendaCardapio::find($this->id);
        if (! $cardapio) {
            $this->simpleRedirect('educar_cardapio_lst.php');
        }

        $lista_produtos = "<ul  style='list-style-type: none; '>";
        $cardapioProdutos = CardapioProduto::where('cod_cardapio', $this->id)->get();
        $contador_unidades= 0;

        foreach($cardapioProdutos as $cardapioProduto){

            $produtos = Produto::where('id', $cardapioProduto['cod_produto'])->get();

            foreach($produtos as $produto){
                $lista_produtos .= "<li   style='border: 1px solid grey; padding: 5px;background:white;'><b> ".$produto['descricao']." </b></li>";
            }
        
        
        }
        
        $lista_produtos .= "</ul>";
  
  

    


           $this->addDetalhe([ 'Código', $cardapio->id]);
           $this->addDetalhe([ 'Dia da Semana', $cardapio->dia_semana]);
           $this->addDetalhe([ 'Descrição', $cardapio->descricao]);
           $this->addDetalhe([ 'Produtos', $lista_produtos]);
           $this->addDetalhe([ 'Preparo', $cardapio->preparo]);
           
       

        $obj_permissao = new clsPermissoes();
        if ($obj_permissao->permissao_cadastra(9212, $this->pessoa_logada, 7)) {
            $this->url_novo = 'educar_cardapio_cad.php';
            $this->url_editar = "educar_cardapio_cad.php?id={$this->id}";
        }

        $this->url_cancelar = 'educar_cardapio_lst.php';
        $this->largura = '100%';

        $this->breadcrumb('Detalhes do Cardápio', [
            url('intranet/educar_cardapio_lst.php') => 'Cardápio',
        ]);
    }

    public function Formular()
    {
        $this->title = 'Detalhes Cardápio';
        $this->processoAp = '9204';
    }
};

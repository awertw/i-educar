<?php
use iEducar\Legacy\Model;
use App\Models\Unidade;
use App\Models\Serie;
use App\Models\ComponenteCurricular;
use App\Models\unidadeSeries;
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
        $this->titulo = 'Unidade - Detalhes';

        $this->id=$_GET['id'];
        $unidade = Unidade::find($this->id);
        if (! $unidade) {
            $this->simpleRedirect('educar_unidade_lst.php');
        }

    


           $this->addDetalhe([ 'Código', $unidade->id]);
           $this->addDetalhe([ 'Unidade', $unidade->unidade]);
           $this->addDetalhe([ 'Descrição', $unidade->descricao]);
           
       

        $obj_permissao = new clsPermissoes();
        if ($obj_permissao->permissao_cadastra(9206, $this->pessoa_logada, 7)) {
            $this->url_novo = 'educar_unidade_cad.php';
            $this->url_editar = "educar_unidade_cad.php?id={$this->id}";
        }

        $this->url_cancelar = 'educar_unidade_lst.php';
        $this->largura = '100%';

        $this->breadcrumb('Detalhe do Unidade', [
            url('intranet/educar_unidade_lst.php') => 'Merenda Escolar',
        ]);
    }

    public function Formular()
    {
        $this->title = 'Detalhes Unidade';
        $this->processoAp = '9204';
    }
};

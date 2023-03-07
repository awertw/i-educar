<?php
use iEducar\Legacy\Model;
use App\Models\MerendaCardapio;
use App\Models\CardapioCurso;
use App\Models\Curso;
use App\Models\TurmaTurno;

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
    public $cod_turno;
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

        $lista_cursos = "<ul  style='list-style-type: none; '>";
        $cardapioCursos = CardapioCurso::where('cod_cardapio', $this->id)->get();
        $contador_unidades= 0;

        foreach($cardapioCursos as $cardapioCurso){

            $cursos = Curso::where('cod_curso', $cardapioCurso['cod_curso'])->get();

            foreach($cursos as $curso){
                $lista_cursos .= "<li   style='border: 1px solid grey; padding: 5px;background:white;'><b> ".$curso['nm_curso']." </b></li>";
            }
        
        
        }
        
        $lista_cursos .= "</ul>";
  
  

        $turnos = TurmaTurno::where('id', $cardapio->cod_turno)->get();
    
        $det_turno = "";
        foreach($turnos as $turno){
          $det_turno = $turno['nome'];  
        }


           $this->addDetalhe([ 'Código', $cardapio->id]);
           $this->addDetalhe([ 'Dia da Semana', $cardapio->dia_semana]);
           $this->addDetalhe([ 'Descrição', $cardapio->descricao]);
           $this->addDetalhe([ 'Cursos', $lista_cursos]);
           $this->addDetalhe([ 'Preparo', $cardapio->preparo]);
           $this->addDetalhe([ 'Turno', $det_turno]);
           
       

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

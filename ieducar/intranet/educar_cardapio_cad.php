<?php
 
use iEducar\Legacy\Model;
use App\Models\MerendaCardapio;
use App\Models\CardapioCurso;
use App\Models\Curso;

return new class extends clsCadastro {

    public $pessoa_logada;
    public $instituicao_id;
    public $id;
    public $curso;
    public $descricao;
    public $curso_ids;
    public $dia_semana;
    public $preparo;
    

   
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
                    $this->preparo = $cardapio->preparo;
                    $this->dia_semana = $cardapio->dia_semana;
                 
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
           

       
        $selectOptionsCurso = [];
 
        $cursos = Curso::all();
        $a = array();
        $b = array();

        foreach($cursos as $curso){
            array_push($a, $curso['cod_curso']);
            array_push($b, $curso['cod_curso']." - ".$curso['nm_curso']);
          
         }
       
           
                
        
        $c = array_combine($a, $b);
        $options = [
            'label' => 'Cursos',
            'required' => true,
            'size' => 50,
            'value' => $this->$curso_ids,
            'options' => [
                'all_values' =>$c
            ]
        ];
        $this->inputsHelper()->multipleSearchCustom('', $options, $helperOptions);
      
        
     
       
        $obs_options = [
            'required' => false,
            'label' => 'Preparo',
            'value' => $this->preparo
        ];
        $this->inputsHelper()->textArea('preparo', $obs_options);

       
        $selectOptionsdiaSemana = [];

       
       
   
        $selectOptionsdiaSemana[1] = "Segunda-Feira";
        $selectOptionsdiaSemana[2] = "Terça-Feira";
        $selectOptionsdiaSemana[3] = "Quarta-Feira";
        $selectOptionsdiaSemana[4] = "Quinta-Feira";
        $selectOptionsdiaSemana[5] = "Sexta-Feira";
        $selectOptionsdiaSemana[6] = "Sábado";
        $selectOptionsdiaSemana[7] = "Domingo";
 
   
   


    $selectOptionsdiaSemana = array_replace([null => 'Selecione'], $selectOptionsdiaSemana);

  
    $this->campoLista('dia_semana', 'Dia da Semana', $selectOptionsdiaSemana, $this->dia_semana, '', true, '', '', '', true);
       
     
 
    }

    public function Novo(){
        $data = MerendaCardapio::latest('id')->first();
        $id_cardapio = $data->id + 1;

        $dia = "";
        if($this->dia_semana==1){
            $dia = "Segunda-Feira";
        }elseif($this->dia_semana==2){
            $dia = "Terça-Feira";
        }elseif($this->dia_semana==3){
            $dia = "Quarta-Feira";
        }elseif($this->dia_semana==4){
            $dia = "Quinta-Feira";
        }elseif($this->dia_semana==5){
            $dia = "Sexta-Feira";
        }elseif($this->dia_semana==6){
            $dia = "Sábado";
        }elseif($this->dia_semana==7){
            $dia = "Domingo";
        }
            $cadastrou =   MerendaCardapio::create( [
                'id' => $id_cardapio,
                'descricao' => $this->descricao,
                'dia_semana' => $dia,
                'preparo' => $this->preparo
               
              ]);
       
              $this->curso_ids  = $_POST['custom'];
              
              foreach ($this->curso_ids as $curso_id ) {
          
                CardapioCurso::create([
                     
                      'cod_cardapio' => $id_cardapio,
                      'cod_curso' => $curso_id
                     
                    ]);
                
              }

       
        

     
    
            

        

       
       
        if ($cadastrou) {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br />';
            $this->simpleRedirect('educar_cardapio_det.php?id='.$id_cardapio);
        }

        
    
    }

    public function Editar()
    {
     
        $dia = "";
        if($this->dia_semana==1){
            $dia = "Segunda-Feira";
        }elseif($this->dia_semana==2){
            $dia = "Terça-Feira";
        }elseif($this->dia_semana==3){
            $dia = "Quarta-Feira";
        }elseif($this->dia_semana==4){
            $dia = "Quinta-Feira";
        }elseif($this->dia_semana==5){
            $dia = "Sexta-Feira";
        }elseif($this->dia_semana==6){
            $dia = "Sábado";
        }elseif($this->dia_semana==7){
            $dia = "Domingo";
        }
        MerendaCardapio::where('id', $_GET['id'])->update([
            'descricao' => $this->descricao,
            'dia_semana' => $dia,
            'preparo' => $this->preparo
           
          
          
        ]);

        CardapioCurso::where('cod_cardapio', $_GET['id'])->delete(); 
        
        $this->unidade_ids  = $_POST['custom'];
              
        foreach ($this->unidade_ids as $curso_id ) {
    
            CardapioCurso::create([
               
                'cod_cardapio' => $_GET['id'],
                'cod_curso' => $curso_id
               
              ]);
          
        }
        

      
        $this->simpleRedirect('educar_cardapio_det.php?id='.$_GET['id']);
    }

    public function Excluir()
    {
       
        MerendaCardapio::where('id', $_GET['id'])->delete(); 
        CardapioCurso::where('cod_cardapio', $_GET['id'])->delete(); 
        $this->mensagem .= 'Exclusão efetuada com sucesso.<br>';
        $this->simpleRedirect('educar_cardapio_lst.php');
    }

    public function Formular()
    {
        $this->title = 'Cardápio';
        $this->processoAp = '9204';
    }
};

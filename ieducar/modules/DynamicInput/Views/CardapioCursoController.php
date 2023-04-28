<?php
use App\Models\MerendaCardapio;
use App\Models\CardapioCurso;
use App\Models\Curso;
use App\Models\TurmaTurno;



class CardapioCursoController extends ApiCoreController
{
    
    protected function getCardapioCurso()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $instituicaoId = $this->getRequest()->instituicao_id || 1;
        $cursoId = $this->getRequest()->curso;
        $ComponenteId = $this->getRequest()->componente_id;
        $ano = $this->getRequest()->ano;
        
        
            $options = [];
       
            $cardapio_id = 0;
            if(!empty($cursoId)){

            $cardapio_curso = CardapioCurso::where('cod_curso', $cursoId)->get(); 
            foreach($cardapio_curso as $cardapios_curso){

            
            $cardapio = MerendaCardapio::where('id', $cardapios_curso->cod_cardapio)->where('inativo', null)->get(); 
            foreach($cardapio as $cardapios){


                $turnos = TurmaTurno::where('id', $cardapios->cod_turno)->get();
    
                $det_turno = "";
                foreach($turnos as $turno){
                $det_turno = $turno['nome'];  
                }

                $options[
                    '__' . $cardapios->id
                ] = [
                    'value' => mb_strtoupper($cardapios->id." - ".$cardapios->descricao." - ".substr($cardapios->dia_semana, 0, 3)." - ".$det_turno, 'UTF-8'),
                    'checked' => "checked",
                    'group' => ''
                ];

            }
                
            }

        }

        return ['options' => $options];
        
    }


    public function Gerar()
    {
        if ($this->isRequestFor('get', 'cardapioCurso')) {

            $this->appendResponse($this->getCardapioCurso());

        } 
         else {
            
        }
    }
}

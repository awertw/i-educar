<?php

use App\Models\MerendaCardapio;
use App\Models\CardapioCurso;
use App\Models\TurmaTurno;

class Portabilis_View_Helper_DynamicInput_CardapioCurso extends Portabilis_View_Helper_DynamicInput_CoreSelect
{
    protected function inputName()
    {
        return 'ref_cod_cardapio_curso';
    }

    protected function inputOptions($options)
    {
        $resources = $options['resources'];
        $cursoId = $this->getCursoId($options['cursoId'] ?? null);
       

        if(!empty($cursoId)){
            $cardapio_curso = CardapioCurso::where('cod_curso', $cursoId)->get();
            foreach($cardapio_curso as $cardapio_cs){
              

            $cardapio = MerendaCardapio::where('id', $cardapio_cs->cod_cardapio)->where('inativo', null)->get();
                foreach($cardapio as $cardapios){

                    $turnos = TurmaTurno::where('id', $cardapios->cod_turno)->get();
    
                    $det_turno = "";
                    foreach($turnos as $turno){
                    $det_turno = $turno['nome'];  
                    }

                    $resources[$cardapios->id] = $cardapios->id.' - '.$cardapios->descricao." - ". $det_turno;

              
                }

            }

        }
            

        
       
        $ultimo_descricao = 'Selecione um cardápio';

        return $this->insertOption(null,  $ultimo_descricao, $resources);
    }

    protected function defaultOptions()
    {
        return [
            'id' => null,
            'cardapioId' => null,
            'options' => [],
            'resources' => []
        ];
    }

    public function cardapioCurso($options = [])
    {
        parent::select($options);
    }
}

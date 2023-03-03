<?php

use App\Models\MerendaCardapio;
use App\Models\CardapioCurso;
use App\Models\Curso;

class Portabilis_View_Helper_DynamicInput_CardapioCurso extends Portabilis_View_Helper_DynamicInput_CoreSelect
{
    protected function inputName()
    {
        return 'ref_cod_cardapio_curso';
    }

    protected function inputOptions($options)
    {
        $resources = $options['resources'];
        $cursoId = $this->getTurmaId($options['cursoId'] ?? null);
       

        if(!empty($cursoId)){
            $cardapio_curso = CardapioCurso::where('cod_curso', $cursoId)->get();
            foreach($cardapio_curso as $cardapio_cs){

            $cardapio = MerendaCardapio::where('id', $cardapio_cs->servidor_id)->get();
                foreach($cardapio as $cardapios){

                    $options[
                        '__' . $cardapios->id
                    ] = [
                        'value' => mb_strtoupper($cardapios->id." - ".$cardapios->descricao, 'UTF-8'),
                        'checked' => "checked",
                        'group' => ''
                    ];

                }

            }

        } else{

           

                    $cardapio = MerendaCardapio::get();
                    foreach($cardapio as $cardapios){

                        $resources[$cardapios->id] = $cardapios->id.' - '.$cardapios->descricao;


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

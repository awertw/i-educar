<?php

use App\Models\LegacyIndividual;
use App\Models\Turma;
use App\Models\CardapioTurma;

$data = CardapioTurma::latest('id')->first();
        $id_cardapio = $data->id + 1;

       
            $cadastrou =   CardapioTurma::create( [
                'id' => $id_cardapio,
                'cod_escola'=>$_GET['cod_escola'],
                'cod_turma'=>$_GET['cod_turma'],
                'data'=>$_GET['data_aplicacao'],
                'cod_cardapio'=>$_GET['cod_cardapio']
               
              ]);
       

echo"<script> window.location.replace('educar_cardapio_turma_lst.php');</script>";
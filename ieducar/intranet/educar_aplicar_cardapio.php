<?php

use App\Models\LegacyIndividual;
use App\Models\Turma;
use App\Models\CardapioTurma;


$dia_sem = str_replace("/", "-", $_GET['data_aplicacao']);
$dia_sem= date('Y-m-d',  strtotime( $dia_sem));        
    $cardapioTurmas = CardapioTurma::where('cod_turma', $_GET['cod_turma'])->where('cod_cardapio', $_GET['cod_cardapio'])->where('data', $dia_sem)->get();

    $contador = 0;
    $id_cardapio = 0;
    foreach( $cardapioTurmas as  $cardapioTurma){
        $contador++;
        $id_cardapio = $cardapioTurma['id'];
    }

    if($contador>0){

    }else{
        $data = CardapioTurma::latest('id')->first();
        $id_cardapio = $data->id + 1;

       
            $cadastrou =   CardapioTurma::create( [
                'id' => $id_cardapio,
                'cod_turma'=>$_GET['cod_turma'],
                'data'=>$dia_sem,
                'cod_cardapio'=>$_GET['cod_cardapio'],
                'turno'=>$_GET['cod_turno']
               
              ]);

    }

       
       

echo"<script> window.location.replace('educar_cardapio_turma_lst.php');</script>";
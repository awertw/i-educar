<?php

use App\Models\LegacyIndividual;
use App\Models\Turma;
use App\Models\CardapioTurma;




        $turma =  Turma::where('ref_ref_cod_escola', $_GET['cod_escola'])->where('ref_cod_curso', $_GET['cod_curso'])->where('ano', $_GET['ano'])->where('turma_turno_id', $_GET['cod_turno'])->get();
        foreach($turma as $turma_registro){
            
            $cardapioTurmas = CardapioTurma::where('cod_turma', $turma_registro['cod_turma'])->where('cod_cardapio', $_GET['cod_cardapio'])->where('data', $_GET['data_aplicacao'])->get();

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
                        'cod_escola'=> $_GET['cod_escola'],
                        'cod_turma'=> $turma_registro['cod_turma'],
                        'data'=> $_GET['data_aplicacao'],
                        'cod_cardapio'=> $_GET['cod_cardapio'],
                        'turno'=> $_GET['cod_turno']
                       
                      ]);

            }
          

        }
       
        

echo"<script> window.location.replace('educar_cardapio_turma_lst.php');</script>";
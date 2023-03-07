<?php

use App\Models\LegacyIndividual;
use App\Models\Turma;
use App\Models\CardapioTurma;


            CardapioTurma::where('id', $_GET['cod_cardapio_turma'])->delete(); 
            
       

echo"<script> window.location.replace('educar_cardapio_turma_lst.php');</script>";
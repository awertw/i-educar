<?php
use App\Models\Frequencia;
use App\Models\ComponenteCurricularTurma;
use App\Models\ComponenteCurricularAno;
use App\Models\SerieTurma;
use App\Models\Serie;
use App\Models\Turma;
use App\Services\SchoolGradeDisciplineService;

class ProfessorComponenteController extends ApiCoreController
{
   
    protected function getProfessorComponente()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $instituicaoId = $this->getRequest()->instituicao_id || 1;
        $turmaId = $this->getRequest()->turma_id;
        $ComponenteId = $this->getRequest()->componente_id;
        $ano = $this->getRequest()->ano;
        
        $data_freq = $this->getRequest()->data_frequencia;
      
       $data_freq = implode("-",array_reverse(explode("/",$data_freq)));
            $options = [];
       
          
           
           
           
        
            
         
           
                $options[
                    '__' . 1
                ] = [
                    'value' => mb_strtoupper("dias letivos: ".$total_dias_letivos_turma." | dias realizados: ".$total_dias_letivos_realizados." | dias a realizar: ".$restante, 'UTF-8'),
                    'checked' => "checked",
                    'group' => ''
                ];


            return ['options' => $options];
        
        
    }


    public function Gerar()
    {
        if ($this->isRequestFor('get', 'professoresComponente')) {

            $this->appendResponse($this->getProfessorComponente());

        } 
         else {
            
        }
    }
}

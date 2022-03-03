<?php

use App\Models\LegacySingleQueueCandidate;
use Illuminate\Support\Facades\Auth;

class OcorrenciaDisciplinarController extends ApiCoreController
{
    protected function postOcorrenciaDisciplinar()
    {
        $ano = $this->getRequest()->ano;
        $matricula = $this->getRequest()->matricula;
        $tipo = $this->getRequest()->tipo;
        $data = dataToBanco($this->getRequest()->data);
        $horas = $this->getRequest()->horas;
        $observacao = $this->getRequest()->observacao;
        $visivelPais = $this->getRequest()->visivelPais == false ? 0 : 1;

        $data_cadastro = $data . ' ' . $horas;

        $obj = new clsPmieducarMatriculaOcorrenciaDisciplinar(
            $matricula,
            $tipo,
            null,
            null,
            1,
            $observacao,
            $data_cadastro,
            null,
            null,
            $visivelPais,
            null
        );
        $cadastrou = $obj->cadastra();

        if (!$cadastrou) {   
            $this->mensagem = 'Cadastro não realizado.<br>';
            return false;
        } else {
            $this->mensagem .= 'Cadastro efetuado com sucesso.<br>';
            return true;
        }
    }

    public function Gerar()
    {
        if ($this->isRequestFor('post', 'post-ocorrencia-disciplinar')) {
            $this->appendResponse($this->postOcorrenciaDisciplinar());
        }
    }
}

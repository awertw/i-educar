<?php

return new class extends clsCadastro
{

    public function Inicializar()
    {
        $this->nome_url_sucesso  = 'Continuar';
        $this->url_cancelar      = 'educar_index.php';
        $this->nome_url_cancelar = 'Cancelar';

        $this->breadcrumb('Consulta de faltas', ['educar_index.php' => 'Escola']);

        return 'Novo';
    }

    public function Gerar()
    {      
        $this->inputsHelper()->dynamic(['ano', 'instituicao', 'escola', 'curso', 'serie', 'turma']);
        $this->inputsHelper()->dynamic(['componenteCurricular'], ['required' => false]);
        $this->inputsHelper()->dynamic(['dataInicial', 'dataFinal']);

    }

    public function Novo()
    {
        $campos = [
            'ano',
            'data_final',
            'data_inicial',
            'ref_cod_curso',
            'ref_cod_serie',
            'ref_cod_turma',
            'ref_cod_escola',
            'ref_cod_instituicao',
            'ref_cod_componente_curricular',
        ];

        $queryString = [];

        foreach ($campos as $campo) {
            $queryString[$campo] = $this->{$campo};
        }

        $queryString = http_build_query($queryString);
        $url = 'educar_consulta_faltas_lst.php?' . $queryString;

        $this->simpleRedirect($url);
    }

    public function Formular()
    {
        $this->title = 'Consulta de faltas';
        $this->processoAp = 9998911;
    }
};

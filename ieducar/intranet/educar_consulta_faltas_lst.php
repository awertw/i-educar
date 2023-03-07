<?php
return new class extends clsListagem
{
    public function Gerar()
    {
        $params = [];

        $params['ano']                   = $this->getQueryString('ano');
        $params['instituicao']           = $this->getQueryString('ref_cod_instituicao');
        $params['escola']                = $this->getQueryString('ref_cod_escola');
        $params['curso']                 = $this->getQueryString('ref_cod_curso');
        $params['serie']                 = $this->getQueryString('ref_cod_serie');
        $params['turma']                 = $this->getQueryString('ref_cod_turma');
        $params['componente_curricular'] = $this->getQueryString('ref_cod_componente_curricular');
        $params['data_inicial']          = $this->getQueryString('data_inicial');
        $params['data_final']            = $this->getQueryString('data_final');

        $this->breadcrumb('Consulta de faltas', ['educar_index.php' => 'Escola']);

        $required = ['ano', 'escola', 'data_inicial', 'data_final', 'instituicao',];

        foreach ($required as $req) {
            if (empty($params[$req])) {
                $this->simpleRedirect('/intranet/educar_index.php');
            }
        }

        $params['data_inicial'] = Portabilis_Date_Utils::brToPgSQL($params['data_inicial']);
        $params['data_final'] = Portabilis_Date_Utils::brToPgSQL($params['data_final']);

        $this->titulo    = 'Parâmetros';
        $this->acao      = 'go("/intranet/educar_consulta_faltas.php")';
        $this->nome_acao = 'Nova consulta';

        $escola = 'Todas';
        $curso  = 'Todos';
        $serie  = 'Todas';
        $turma  = 'Todas';
        $componente_curricular = 'Todos';

        if (!empty($params['escola'])) {
            $dados = (array)Portabilis_Utils_Database::fetchPreparedQuery("
                select
                    juridica.fantasia
                from
                    pmieducar.escola
                inner join
                    cadastro.juridica on juridica.idpes = escola.ref_idpes
                where true
                    and escola.cod_escola = {$params['escola']}
                limit 1;
            ");

            $escola = $dados[0]['fantasia'];
        }

        if (!empty($params['curso'])) {
            $dados = (array)Portabilis_Utils_Database::fetchPreparedQuery(
                "select nm_curso from pmieducar.curso where cod_curso = {$params['curso']};"
            );

            $curso = $dados[0]['nm_curso'];
        }

        if (!empty($params['serie'])) {
            $dados = (array)Portabilis_Utils_Database::fetchPreparedQuery(
                "select nm_serie from pmieducar.serie where cod_serie = {$params['serie']};"
            );

            $serie = $dados[0]['nm_serie'];
        }

        if (!empty($params['turma'])) {
            $dados = (array)Portabilis_Utils_Database::fetchPreparedQuery(
                "select nm_turma from pmieducar.turma where cod_turma = {$params['turma']};"
            );

            $turma = $dados[0]['nm_turma'];
        }

        if (!empty($params['componente_curricular'])) {
            $dados = (array)Portabilis_Utils_Database::fetchPreparedQuery(
                "select nome from modules.componente_curricular where id = {$params['componente_curricular']};"
            );

            $componente_curricular = $dados[0]['nome'];
        }

        $this->addCabecalhos([
            'Ano',
            'Escola',
            'Curso',
            'Série',
            'Turma',
            'Componente Curricular',
            'Data inicial',
            'Data final'
        ]);

        $this->addLinhas([
            filter_var($params['ano'], FILTER_SANITIZE_STRING),
            $escola,
            $curso,
            $serie,
            $turma,
            $componente_curricular,
            filter_var($this->getQueryString('data_inicial'), FILTER_SANITIZE_STRING),
            filter_var($this->getQueryString('data_final'), FILTER_SANITIZE_STRING)
        ]);

        $sql = "SELECT
                M.cod_matricula,
                pessoa.nome
            FROM
                pmieducar.matricula M
            INNER JOIN pmieducar.aluno
                ON aluno.cod_aluno = M.ref_cod_aluno
            INNER JOIN pmieducar.matricula_turma AS MT
                ON MT.ref_cod_matricula = M.cod_matricula
            INNER JOIN pmieducar.turma 
                ON turma.cod_turma = MT.ref_cod_turma
            INNER JOIN pmieducar.curso 
                ON curso.cod_curso = turma.ref_cod_curso
            INNER JOIN pmieducar.serie serie
                ON serie.cod_serie = turma.ref_ref_cod_serie
            INNER JOIN pmieducar.escola escola
                ON escola.cod_escola = M.ref_ref_cod_escola
            INNER JOIN modules.frequencia_aluno AS FA
		        ON FA.ref_cod_matricula = M.cod_matricula
	        INNER JOIN modules.frequencia AS FQ
		        ON FQ.id = FA.ref_frequencia
            INNER JOIN cadastro.pessoa
                ON pessoa.idpes = aluno.ref_idpes
            WHERE true
            AND escola.ref_cod_instituicao = {$params['instituicao']}
            AND M.ref_ref_cod_escola = {$params['escola']}
            AND M.ano = {$params['ano']}
            AND M.ativo = 1
            AND FQ.data >= '{$params['data_inicial']}'
            AND FQ.data <= '{$params['data_final']}'
            AND serie.ref_cod_curso = {$params['curso']}
            AND turma.cod_turma = {$params['turma']}
            AND serie.cod_serie = {$params['serie']}
            GROUP BY
                M.cod_matricula,
                pessoa.nome
            ORDER BY
                nome
        ";

        $db = new clsBanco();
        $db->Consulta($sql);

        while ($db->ProximoRegistro()) {
            $matriculas[] = $db->Tupla();
        }

        $objFrequencia = new clsModulesFrequencia();

        $alunosFaltas = [];

        foreach ($matriculas as $key => $matricula) {

            $matriculaKey = $key;
            $matriculaId = $matricula['cod_matricula'];
            $alunosFaltas[$matriculaKey] = $matricula;

            $qtdFaltas = $objFrequencia->getTotalFaltas($matriculaId, $params['componente_curricular']);

            $alunosFaltas[$matriculaKey]['qtd_faltas'] = $qtdFaltas;
        }

        $data = json_encode($alunosFaltas);

        $tableScript = <<<JS
        (function () {
            let data = {$data};
            let table = [];
            
            table.push('<table class="tablelistagem" style="width: 100%; margin-bottom: 100px;" cellspacing="1" cellpadding="4" border="0">');
                table.push('<tr>');
                    table.push('<td class="titulo-tabela-listagem" colspan="25">Resultado(s)</td>');
                table.push('</tr>');
                
                table.push('<tr>');
                    table.push('<td class="formdktd" style="font-weight: bold; text-align: center;" rowspan="1" >Matrícula</td>');
                    table.push('<td class="formdktd" style="font-weight: bold; text-align: center;" rowspan="1" colspan"3" >Nome do aluno(a)</td>');
                    table.push('<td class="formdktd" style="font-weight: bold; text-align: center;" rowspan="1" >Falta(s)</td>');
                table.push('</tr>');
               
                Object.keys(data).forEach((key) => {
                    table.push('<tr>');
                        table.push('<td class="formdktd" style="font-weight: bold; text-align: center;" >' + data[key]['cod_matricula'] + '</td>');
                        table.push('<td class="formdktd" style="font-weight: bold; text-align: center;" >' + data[key]['nome'] + '</td>');
                        table.push('<td class="formdktd" style="font-weight: bold; text-align: center;" >' + data[key]['qtd_faltas'] + '</td>');
                    table.push('</tr>');
                });

                if (data.length === 0) {
                        table.push('<tr>');
                            table.push('<td class="formdktd" style="text-align: center; color: #C6C1B9" colspan="4" ><em>Nenhum resultado encontrado</em></td>');                    
                        table.push('</tr>');
                    }                    
            table.push('</table>');

            let base          = document.querySelectorAll('#corpo')[0];
            let wrapper       = document.createElement('div');
            wrapper.innerHTML = table.join('');
            let tableObj      = wrapper.firstChild;
            base.appendChild(tableObj);
        })();
        JS;

        Portabilis_View_Helper_Application::embedJavascript($this, $tableScript, false);
    }

    public function Formular()
    {
        $this->title = 'Consulta de faltas';
        $this->processoAp = 9998911;
    }
};

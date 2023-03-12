<?php

use iEducar\Legacy\Model;

class clsModulesNotaAluno extends Model
{
    public $id;
    public $matricula_id;

    public function __construct(
        $id = null,
        $matricula_id = null
    ) {
        $db = new clsBanco();
        $this->_schema = 'modules.';
        $this->_tabela = "{$this->_schema}nota_aluno";

        $this->_campos_lista = $this->_todos_campos = '
        id, 
        matricula_id';

        if (is_numeric($id)) {
            $this->id = $id;
        }
        if (is_numeric($matricula_id)) {
            $this->matricula_id = $matricula_id;
        }        
    }

    public function selectNotaAlunoIdByMatricula($matricula_id)
    {
        if ($matricula_id) {
            $db = new clsBanco();

            $sql = "
                 SELECT id
                 FROM
                     modules.nota_aluno
                 WHERE matricula_id = $matricula_id
             ";

            $db->Consulta($sql);
            $db->ProximoRegistro();

            return $db->Tupla();
        }

        return false;
    }

    public function UpdateLettersSituationNoteAverage()
    {
        $this->updateLettersNoteAverage();
        $this->updateSituationNoteAverage();
    }

    private function updateLettersNoteAverage()
    {
        $sql = "SELECT
                    na.id as id_aluno
                FROM pmieducar.matricula m
                INNER JOIN modules.regra_avaliacao_serie_ano asa
                    ON asa.serie_id = m.ref_ref_cod_serie
                INNER JOIN modules.nota_aluno na
                    ON m.cod_matricula = na.matricula_id
                INNER JOIN modules.regra_avaliacao ra
					ON ra.id = asa.regra_avaliacao_id
                WHERE
                    ra.tipo_nota = 2
                GROUP BY
                    na.id                
                ";

        $db = new clsBanco();
        $db->Consulta($sql);

        $alunos = [];
        while ($db->ProximoRegistro()) {
            $alunos[] = $db->Tupla();
        }

        if (!empty($alunos)) {
            foreach ($alunos as $aluno) {
                $notaIdAluno = $aluno['id_aluno'];

                $sql = "UPDATE
                            modules.nota_componente_curricular_media ccm
                        SET
                            media_arredondada = 
                        CASE 
                            WHEN ccm.media BETWEEN 0 AND 1.9999 THEN 'E'
                            WHEN ccm.media BETWEEN 2 AND 4.9999 THEN 'R'
                            WHEN ccm.media BETWEEN 5 AND 6.9999 THEN 'C'
                            WHEN ccm.media BETWEEN 7 AND 8.9999 THEN 'B'
                            ELSE 'A'
                        END
                        WHERE
                            nota_aluno_id = {$notaIdAluno}
                        ";
                $db->Consulta($sql);
            }
        }
    }

    private function updateSituationNoteAverage()
    {
        $db = new clsBanco();
        $db->Consulta
        (
            "UPDATE
                modules.nota_componente_curricular_media
            SET
                situacao = 1
            WHERE TRUE
            AND media >= 5 
            AND etapa = '4' OR etapa = 'Rc'
            AND situacao is null
            "
        );
        $db->ProximoRegistro();
        return $db->Tupla();
        
    }
}

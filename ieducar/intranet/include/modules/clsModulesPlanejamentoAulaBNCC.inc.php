<?php

use iEducar\Legacy\Model;

class clsModulesPlanejamentoAulaBNCC extends Model {
    public $id;
    public $planejamento_aula_id;
    public $bncc_id;

    public function __construct(
        $id = null,
        $planejamento_aula_id = null,
        $bncc_id = null
    ) {
        $this->_schema = 'modules.';
        $this->_tabela = "{$this->_schema}planejamento_aula_bncc";

        $this->_from = "
            modules.planejamento_aula_bncc as pab
        ";

        $this->_campos_lista = $this->_todos_campos = '
            *
        ';

        if (is_numeric($id)) {
            $this->id = $id;
        }

        if (is_numeric($planejamento_aula_id)) {
            $this->planejamento_aula_id = $planejamento_aula_id;
        }

        if (is_numeric($bncc_id)) {
            $this->bncc_id = $bncc_id;
        }
    }

    /**
     * Cria um novo registro
     *
     * @return bool
     */
    public function cadastra() {
        if (is_numeric($this->planejamento_aula_id) && is_numeric($this->bncc_id)) {
            $db = new clsBanco();

            $db->Consulta("
                INSERT INTO {$this->_tabela}
                    (planejamento_aula_id, bncc_id)
                VALUES ({$this->planejamento_aula_id}, {$this->bncc_id})
            ");

            return true;
        }

        return false;
    }

    /**
     * Lista relacionamentos entre BNCC e o plano de aula
     *
     * @return array
     */
    public function lista($planejamento_aula_id) {
        $db = new clsBanco();

        $db->Consulta("
            SELECT
                STRING_AGG (lok.id::character varying, ',') as ids,
                STRING_AGG (pab.id::character varying, ',') as pab_ids,
                STRING_AGG (lok.code::character varying, ',') as codigos,
                STRING_AGG (lok.description::character varying, '$/') as descricoes
            FROM
                modules.planejamento_aula_bncc as pab
            JOIN public.learning_objectives_and_skills as lok
                ON (lok.id = pab.bncc_id)
            GROUP BY
                pab.planejamento_aula_id
            HAVING
                pab.planejamento_aula_id = '{$planejamento_aula_id}'
        ");

        $db->ProximoRegistro();

        $info_temp = $db->Tupla();

        $infos['ids'] = explode(',', $info_temp['ids']);
        $infos['pab_ids'] = explode(',', $info_temp['pab_ids']);
        $infos['codigos'] = count((array)$info_temp['codigos']) > 0 ? explode(',', $info_temp['codigos']) : null;
        $infos['descricoes'] = count((array)$info_temp['descricoes']) > 0 ? explode('$/', $info_temp['descricoes']) : null;

        $bnccs = [];

        for ($i=0; $i < count((array)$infos['ids']); $i++) {
            $bnccs[$i]['id'] = $infos['ids'][$i];
            $bnccs[$i]['planejamento_aula_bncc_id'] = $infos['pab_ids'][$i];
            $bnccs[$i]['codigo'] = $infos['codigos'][$i];
            $bnccs[$i]['descricao'] = $infos['descricoes'][$i];
        }

        return $bnccs;
    }

    /**
     * Retorna um array com os dados de um registro
     *
     * @return array
     */
    public function detalhe () {
        $data = [];

        if (is_numeric($this->planejamento_aula_id)) {
            $db = new clsBanco();
            $db->Consulta("
                SELECT
                    {$this->_todos_campos}
                FROM
                    {$this->_from}
                WHERE
                    pab.planejamento_aula_id = {$this->planejamento_aula_id}
            ");

            while ($db->ProximoRegistro()) {
                $ppd = $db->Tupla();

                $obj = new clsModulesBNCC($ppd['bncc_id']);
                $ppd['bncc'] = $obj->detalhe();

                $data[] = $ppd;
            }

            return $data;
        }

        return false;
    }

    /**
     * Retorna um array com os dados de um registro
     *
     * @return array
     */
    public function detalhe2 () {
        $data = [];

        if (is_numeric($this->planejamento_aula_id) && is_numeric($this->bncc_id)) {
            $db = new clsBanco();

            $db->Consulta("
                SELECT
                    {$this->_todos_campos}
                FROM
                    {$this->_from}
                WHERE
                    pab.planejamento_aula_id = {$this->planejamento_aula_id} AND pab.bncc_id = {$this->bncc_id}
            ");

            $db->ProximoRegistro();
            $data = $db->Tupla();

            return $data;
        }

        return false;
    }

    /**
     * Retorna um array com os dados de um registro
     *
     * @return array
     */
    public function existe () {
        return false;
    }

    /**
     * Exclui um registro
     *
     * @return bool
     */
    public function excluir () {
        if (is_numeric($this->planejamento_aula_id) && is_numeric($this->bncc_id)) {
            $db = new clsBanco();

            $db->Consulta("
                DELETE FROM
                    {$this->_tabela}
                WHERE
                    planejamento_aula_id = '{$this->planejamento_aula_id}' AND bncc_id = '{$this->bncc_id}'
            ");

            return true;
        }

        return false;
    }

    public function excluirByPlanejamentoAula () {
        if (is_numeric($this->planejamento_aula_id)) {
            $db = new clsBanco();

            $db->Consulta("
                DELETE FROM
                    {$this->_tabela}
                WHERE
                    planejamento_aula_id = '{$this->planejamento_aula_id}'
            ");

            return true;
        }

        return false;
    }
}

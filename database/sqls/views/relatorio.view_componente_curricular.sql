<<<<<<< HEAD
CREATE OR REPLACE VIEW relatorio.view_componente_curricular AS
(
    SELECT
        escola_serie_disciplina.ref_cod_disciplina AS id,
        turma.cod_turma,
        componente_curricular.nome,
        componente_curricular.abreviatura,
        componente_curricular.ordenamento,
        componente_curricular.area_conhecimento_id,
        componente_curricular.tipo_base,
        escola_serie_disciplina.etapas_especificas,
        escola_serie_disciplina.etapas_utilizadas,
        escola_serie_disciplina.carga_horaria
    FROM pmieducar.turma
    JOIN pmieducar.escola_serie_disciplina
    ON escola_serie_disciplina.ref_ref_cod_serie = turma.ref_ref_cod_serie
    AND escola_serie_disciplina.ref_ref_cod_escola = turma.ref_ref_cod_escola
    AND escola_serie_disciplina.ativo = 1
    AND turma.ano = ANY (escola_serie_disciplina.anos_letivos)
    JOIN modules.componente_curricular
    ON componente_curricular.id = escola_serie_disciplina.ref_cod_disciplina
    AND (
        SELECT count(cct.componente_curricular_id) AS count
        FROM modules.componente_curricular_turma cct
        WHERE cct.turma_id = turma.cod_turma
    ) = 0
    JOIN modules.area_conhecimento
    ON area_conhecimento.id = componente_curricular.area_conhecimento_id
    ORDER BY
        area_conhecimento.ordenamento_ac,
        area_conhecimento.nome,
        componente_curricular.ordenamento,
        componente_curricular.nome
)
UNION ALL
(
    SELECT
        componente_curricular_turma.componente_curricular_id AS id,
        componente_curricular_turma.turma_id AS cod_turma,
        componente_curricular.nome,
        componente_curricular.abreviatura,
        componente_curricular.ordenamento,
        componente_curricular.area_conhecimento_id,
        componente_curricular.tipo_base,
        componente_curricular_turma.etapas_especificas,
        componente_curricular_turma.etapas_utilizadas,
        componente_curricular_turma.carga_horaria
    FROM modules.componente_curricular_turma
    JOIN modules.componente_curricular
    ON componente_curricular.id = componente_curricular_turma.componente_curricular_id
    JOIN modules.area_conhecimento
    ON area_conhecimento.id = componente_curricular.area_conhecimento_id
    ORDER BY
        area_conhecimento.ordenamento_ac,
        area_conhecimento.nome,
        componente_curricular.ordenamento,
        componente_curricular.nome
);
=======
CREATE OR REPLACE VIEW relatorio.view_componente_curricular AS
(
    SELECT
        cc.id,
        t.cod_turma,
        coalesce(ts.serie_id, t.ref_ref_cod_serie) AS cod_serie,
        cc.nome,
        cc.abreviatura,
        cc.ordenamento,
        cc.area_conhecimento_id,
        cc.tipo_base,
        esd.etapas_especificas,
        esd.etapas_utilizadas,
        coalesce(cct.carga_horaria, esd.carga_horaria, ccae.carga_horaria) AS carga_horaria
    FROM pmieducar.turma t
    LEFT JOIN pmieducar.turma_serie ts ON ts.turma_id = t.cod_turma
    JOIN pmieducar.escola_serie es ON (
        es.ref_cod_escola = t.ref_ref_cod_escola
        AND es.ref_cod_serie = coalesce(ts.serie_id, t.ref_ref_cod_serie)
    )
    JOIN pmieducar.escola_serie_disciplina esd ON (
        esd.ref_ref_cod_escola = es.ref_cod_escola
        AND esd.ref_ref_cod_serie = es.ref_cod_serie
    )
    JOIN modules.componente_curricular_ano_escolar ccae ON (
        ccae.ano_escolar_id = es.ref_cod_serie
        AND ccae.componente_curricular_id = esd.ref_cod_disciplina
    )
    JOIN modules.componente_curricular cc ON cc.id = ccae.componente_curricular_id
    LEFT JOIN modules.componente_curricular_turma cct ON (
        cct.turma_id = t.cod_turma
        AND cct.componente_curricular_id = cc.id
    )
    WHERE CASE
        WHEN EXISTS (
            SELECT 1
            FROM modules.componente_curricular_turma
            WHERE componente_curricular_turma.turma_id = t.cod_turma
        ) THEN cct.turma_id IS NOT NULL
        ELSE true
    END
);
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837

CREATE OR REPLACE FUNCTION relatorio.get_pai_aluno(integer) RETURNS character varying
    LANGUAGE sql
AS $_$
SELECT coalesce(
           (SELECT nome
            FROM cadastro.pessoa
            WHERE idpes = fisica.idpes_pai), (aluno.nm_pai))
FROM pmieducar.aluno
         INNER JOIN cadastro.fisica ON fisica.idpes = aluno.ref_idpes
WHERE aluno.ativo = 1
  AND aluno.cod_aluno = $1; $_$;

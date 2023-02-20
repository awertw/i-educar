<?php

namespace App\Services\SagresExport;

use App\Queries\SagresExport\ExportQuery;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Database\Eloquent\Collection;

class ExportService
{

    private ExportQuery $exportQuery;
    private DataConverter $dataConverter;

    public function __construct(ExportQuery $exportQuery, DataConverter $dataConverter)
    {
        $this->exportQuery = $exportQuery;
        $this->dataConverter = $dataConverter;
    }

    public function export(array $filters)
    {
        $export = '';
        $adapterFilters = $this->adatperFilters($filters);

        //START
        $dom = new DOMDocument("1.0", "UTF-8");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $root = $dom->createElement("edu:educacao");

        //INSTITUIÇÃO - PRESTAÇÃO DE CONTAS
        $prestacaoContas = $dom->createElement("edu:PrestacaoContas");

        $institution = $this->exportQuery->getInstitution($adapterFilters['institutionId']);

        $codigoUnidGestora = $dom->createElement("edu:codigoUnidGestora", $institution['cod_unidade_gestora']);
        $nomeUnidGestora = $dom->createElement("edu:nomeUnidGestora", $institution['nm_instituicao']); //CONFIRMAR SE É O NOME DA INSITUIÇÃO
        $cpfResponsavel = $dom->createElement("edu:cpfResponsavel", "000.000.000-00"); //verificar com valdinei
        $cpfGestor = $dom->createElement("edu:cpfGestor", "000.000.000-00"); //verificar com valdinei
        $anoReferencia = $dom->createElement("edu:anoReferencia", $adapterFilters['year']);
        $mesReferencia = $dom->createElement("edu:mesReferencia", $adapterFilters['month']);
        $versaoXml = $dom->createElement("edu:versaoXml", 0); //CONFIRMAR
        $diaInicPresContas = $dom->createElement("edu:diaInicPresContas", $adapterFilters['startDay']);
        $diaFinaPresContas = $dom->createElement("edu:diaFinaPresContas", $adapterFilters['endDay']);

        $prestacaoContas->append(
            $codigoUnidGestora,
            $nomeUnidGestora,
            $cpfResponsavel,
            $cpfGestor,
            $anoReferencia,
            $mesReferencia,
            $versaoXml,
            $diaInicPresContas,
            $diaFinaPresContas
        );;

        //START ESCOLAS
        $schoolsDom = $dom->createElement("edu:escola");

        $schools = $institution->schools;

        foreach ($schools as $school) {
            $idEscola = $dom->createElement("edu:idEscola", $school['cod_escola']);

            //START TURMA
            $schoolClasses = $school->schoolClasses; //RETIRAR OS HORARIOS COM DATA DE EXCLUSÃO OU ATIVO 0

            foreach ($schoolClasses as $schoolClass) {
                $schoolClassesDom = $dom->createElement("edu:turma");

                $periodo = $dom->createElement("edu:periodo", 0); //VERIFICAR
                $descricao = $dom->createElement("edu:descricao", $schoolClass['nm_turma']);
                $turno = $dom->createElement("edu:turno", $schoolClass->turma_turno_id); //VERIFICAR - FAZER CONVERSÃO

                $schoolClassesDom->append($periodo, $descricao, $turno);

                //SERIES
                if (empty($schoolClass->multiseriado)) {
                    $schoolGrade = $schoolClass->schoolGrade;

                    $schoolGradeDom = $dom->createElement("edu:serie");

                    $descricaoSerie = $dom->createElement("edu:descricao", $schoolGrade->grade->name);
                    $modalidade = $dom->createElement("edu:modalidade", $schoolGrade->grade->course->modalidade_curso); //Verificar - CONVERTER

                    $schoolGradeDom->append($descricaoSerie, $modalidade);

                    $schoolClassesDom->appendChild($schoolGradeDom);
                }

                if ($schoolClass->multiseriado != 0) {
                    $schoolMultigrades = $schoolClass->multigrades;

                    foreach ($schoolMultigrades as $schoolMultigrade) {
                        $schoolGradeDom = $dom->createElement("edu:serie");

                        $descricaoSerie = $dom->createElement("edu:descricao", $schoolMultigrade->grade->name);
                        $modalidade = $dom->createElement("edu:modalidade", $schoolMultigrade->grade->course->modalidade_curso);

                        $schoolGradeDom->append($descricaoSerie, $modalidade);
                        $schoolClassesDom->appendChild($schoolGradeDom);
                    }
                }

                //START MATRICULA
                $schoolClassEnrollments = $schoolClass->enrollments;

                foreach ($schoolClassEnrollments as $schoolClassEnrollment) {
                    $schoolEnrollmentsDom = $dom->createElement("edu:matricula");

                    $matriculaNumero = $dom->createElement("edu:numero", $schoolClassEnrollment->ref_cod_matricula); //VERIFICAR
                    $matriculaData = $dom->createElement("edu:data_matricula", dataFromPgToBr($schoolClassEnrollment->registration->data_matricula, 'Y-m-d')); // VERIFICAR data matricula ou data enturmação
                    $matriculaFaltas = $dom->createElement("edu:numero_faltas", $this->exportQuery->getTotalEnrollmentAbsencesByFrequency($schoolClassEnrollment->ref_cod_matricula, $adapterFilters['startDate'], $adapterFilters['endDate']));
                    $matriculaAprovado = $dom->createElement("edu:aprovado", 'false'); //VERIFICAR SE É O DA MATRICULA E QUAL É A EQUIVALÊNCIA

                    //ALUNO
                    $schoolStudentsDom = $dom->createElement("edu:aluno");

                    $studentCpf  = $dom->createElement("edu:cpfAluno", $schoolClassEnrollment->registration->student->person->individual->cpf); //VERIFICAR quando o aluno não tem CPF oq fazer
                    $studenDateNascimento  = $dom->createElement("edu:data_nascimento", $schoolClassEnrollment->registration->student->person->individual->data_nasc);
                    $studentName  = $dom->createElement("edu:nome", $schoolClassEnrollment->registration->student->person->name);
                    $studentPcd  = $dom->createElement("edu:pcd", ($schoolClassEnrollment->registration->student->person->deficiencies->isEmpty() ? 0 : 1));
                    $studentSexo  = $dom->createElement("edu:sexo", $this->dataConverter->sexoConverter($schoolClassEnrollment->registration->student->person->individual->sexo));

                    $schoolStudentsDom->append($studentCpf, $studenDateNascimento, $studentName, $studentPcd, $studentSexo);
                    //END ALUNO

                    $schoolEnrollmentsDom->append($matriculaNumero, $matriculaData, $matriculaFaltas, $matriculaAprovado, $schoolStudentsDom);

                    $schoolClassesDom->appendChild($schoolEnrollmentsDom);
                }
                //END MATRICULA


                //HORARIOS
                $schoolTimeTable = $schoolClass->timeTable;

                if ($schoolTimeTable) {
                    $horarysTimeTable = $schoolTimeTable->horarys;

                    foreach ($horarysTimeTable as $horaryTimeTable) {
                        $schoolClassHoraryDom = $dom->createElement("edu:horario");

                        $horaryDayWeekend  = $dom->createElement("edu:dia_semana", $horaryTimeTable->dia_semana); //VERIFICAR converter
                        $horaryDuration  = $dom->createElement("edu:duracao", 4); //VERIFICAR quando turma por componente
                        $horaryInitialHour  = $dom->createElement("edu:hora_inicio", $horaryTimeTable->hora_inicial);
                        $horaryDiscipline  = $dom->createElement("edu:disciplina", $horaryTimeTable->ref_cod_disciplina);
                        $horaryServidor  = $dom->createElement("edu:cpfProfessor", $horaryTimeTable->ref_servidor); //VERIFICAR buscar da pessoa

                        $schoolClassHoraryDom->append($horaryDayWeekend, $horaryDuration, $horaryInitialHour, $horaryDiscipline, $horaryServidor);

                        if (!empty($horaryTimeTable->ref_cod_servidor_substituto_1)) {
                            $horaryServidorSubstituto  = $dom->createElement("edu:cpfProfessor", $horaryTimeTable->ref_cod_servidor_substituto_1);
                            $schoolClassHoraryDom->appendChild($horaryServidorSubstituto);
                        }

                        if (!empty($horaryTimeTable->ref_cod_servidor_substituto_2)) {
                            $horaryServidorSubstituto2  = $dom->createElement("edu:cpfProfessor", $horaryTimeTable->ref_cod_servidor_substituto_2);
                            $schoolClassHoraryDom->appendChild($horaryServidorSubstituto2);
                        }

                        $schoolClassesDom->appendChild($schoolClassHoraryDom);
                    }
                }

                //END TURMA
                $schoolsDom->append($idEscola, $schoolClassesDom);
             }

            //DIRETOR
            //CARDAPIO

            //END ESCOLAS

        }

        //PROFISSIONAL

        //END

        $root->appendChild($prestacaoContas);
        $root->appendChild($schoolsDom);
        $dom->appendChild($root);

//        foreach ($this->records($filters) as $record) {
//            $export .= $this->makeLine($record) . "\n";
//        }



        return $dom->saveXML();
    }

    private function makeLine($record): string
    {
        $line = "{$record->ano};";
        $line .= "{$record->inep_escola};";
        $line .= "{$record->cpf};";
        $line .= "{$record->nome_social};";
        $line .= "{$record->cod_matricula};";
        $line .= ($record->emancipado ? 1 : 0) . ';';

        $countResponsibles = 0;
        if ($record->cpf_mae) {
            $countResponsibles++;
            $line .= "{$record->cpf_mae};1;";
        }

        if ($record->cpf_pai) {
            $countResponsibles++;
            $line .= "{$record->cpf_pai};2;";
        }

        if ($record->cpf_responsavel) {
            $countResponsibles++;
            $line .= "{$record->cpf_responsavel};3;";
        }

        for ($i = $countResponsibles; $i < 3; $i++) {
            $line .= ';;';
        }

        return substr($line, 0, -1);
    }

    private function records(array $filters): Collection
    {
        return (new ExportQuery())->query($filters)->get();
    }

    private function adatperFilters(array $filters): array
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $filters['data_inicial']);
        $endDate = Carbon::createFromFormat('d/m/Y', $filters['data_final']);

        return [
          'startDay' => $startDate->day,
          'endDay' => $endDate->day,
          'month' => $startDate->month,
          'year' => $startDate->year,
          'startDate' => $startDate->format('Y-m-d'),
          'endDate' => $endDate->format('Y-m-d'),
          'institutionId' => $filters['ref_cod_instituicao']
        ];
    }
}

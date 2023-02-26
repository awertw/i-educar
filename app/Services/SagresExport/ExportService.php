<?php

namespace App\Services\SagresExport;

use App\Queries\SagresExport\ExportQuery;
use Carbon\Carbon;
use DOMDocument;

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
        $nomeUnidGestora = $dom->createElement("edu:nomeUnidGestora", $institution['nm_responsavel']);
        $cpfResponsavel = $dom->createElement("edu:cpfResponsavel", $this->dataConverter->cpfInstitutionConverter($institution->manager->individual->cpf));
        $cpfGestor = $dom->createElement("edu:cpfGestor", $this->dataConverter->cpfInstitutionConverter($institution->accountingOfficer->individual->cpf));
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

        $teachersTimeTable = [];
        foreach ($schools as $school) {
            $idEscola = $dom->createElement("edu:idEscola", $school['cod_escola']);

            //START TURMA
            $schoolClasses = $school->schoolClasses;

            foreach ($schoolClasses as $schoolClass) {
                $schoolClassesDom = $dom->createElement("edu:turma");

                $periodo = $dom->createElement("edu:periodo", 0); //VERIFICAR
                $descricao = $dom->createElement("edu:descricao", $schoolClass['nm_turma']);
                $turno = $dom->createElement("edu:turno", $this->dataConverter->schoolClassTurnConverter($schoolClass->turma_turno_id));

                $schoolClassesDom->append($periodo, $descricao, $turno);

                //SERIES
                $duration = 4;
                $finalYear = false;
                if (empty($schoolClass->multiseriado)) {
                    $schoolGrade = $schoolClass->schoolGrade;

                    $schoolGradeDom = $dom->createElement("edu:serie");

                    $descricaoSerie = $dom->createElement("edu:descricao", $schoolGrade->grade->name);
                    $modalidade = $dom->createElement("edu:modalidade", 0);

                    $schoolGradeDom->append($descricaoSerie, $modalidade);

                    $schoolClassesDom->appendChild($schoolGradeDom);

                    $schoolGradeRule = $schoolGrade->grade->evaluationRules()->first();

                    $finalYear = $schoolGradeRule->tipo_presenca == 2;
                }

                if ($schoolClass->multiseriado != 0) {
                    $schoolMultigrades = $schoolClass->multigrades;

                    foreach ($schoolMultigrades as $schoolMultigrade) {
                        $schoolGradeDom = $dom->createElement("edu:serie");

                        $descricaoSerie = $dom->createElement("edu:descricao", $schoolMultigrade->grade->name);
                        $modalidade = $dom->createElement("edu:modalidade", 0);

                        $schoolGradeDom->append($descricaoSerie, $modalidade);
                        $schoolClassesDom->appendChild($schoolGradeDom);
                    }
                }

                //START MATRICULA
                $schoolClassEnrollments = $schoolClass->enrollments;

                foreach ($schoolClassEnrollments as $schoolClassEnrollment) {
                    $schoolEnrollmentsDom = $dom->createElement("edu:matricula");

                    $matriculaNumero = $dom->createElement("edu:numero", $schoolClassEnrollment->ref_cod_matricula);
                    $matriculaData = $dom->createElement("edu:data_matricula", dataFromPgToBr($schoolClassEnrollment->registration->data_matricula, 'Y-m-d'));
                    $matriculaFaltas = $dom->createElement("edu:numero_faltas", $this->exportQuery->getTotalEnrollmentAbsencesByFrequency($schoolClassEnrollment->ref_cod_matricula, $adapterFilters['startDate'], $adapterFilters['endDate']));
                    $matriculaAprovado = $dom->createElement("edu:aprovado", 0);

                    //ALUNO
                    $schoolStudentsDom = $dom->createElement("edu:aluno");

                    $studentCpf  = $dom->createElement("edu:cpfAluno", (!empty($schoolClassEnrollment->registration->student->person->individual->cpf) ? $schoolClassEnrollment->registration->student->person->individual->cpf : '000.000.000-00'));
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
                $schoolTimeTable = $schoolClass->timeTable()->whereNull('data_exclusao')->where('ativo', 1)->first();

                if ($schoolTimeTable) {

                    $horarysTimeTable = $schoolTimeTable->horarys()->whereNull('data_exclusao')->where('ativo', 1)->get();

                    foreach ($horarysTimeTable as $horaryTimeTable) {

                        if (!in_array($horaryTimeTable->ref_servidor, $teachersTimeTable)) {
                            $teachersTimeTable[] = $horaryTimeTable->ref_servidor;
                        }

                        $schoolClassHoraryDom = $dom->createElement("edu:horario");

                        $horaryDayWeekend  = $dom->createElement("edu:dia_semana", $horaryTimeTable->dia_semana);
                        $horaryDuration  = $dom->createElement("edu:duracao", ($finalYear ? $horaryTimeTable->qtd_atulas : 4));
                        $horaryInitialHour  = $dom->createElement("edu:hora_inicio", $horaryTimeTable->hora_inicial);
                        $horaryDiscipline  = $dom->createElement("edu:disciplina", $horaryTimeTable->ref_cod_disciplina);
                        $horaryServidor  = $dom->createElement("edu:cpfProfessor", $horaryTimeTable->employee->person->individual->cpf);

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

                //DIRETOR
                $directorSchool = $school->schoolManagers()->where('role_id', 1)->first();
                $directorSchoolDom = $dom->createElement("edu:diretor");

                $cpfDirector  = $dom->createElement("edu:cpfDiretor", $directorSchool->employee->person->individual->cpf);
                $nrAtoDirector  = $dom->createElement("edu:nrAto", $directorSchool->employee->person->ato);

                $directorSchoolDom->append($cpfDirector, $nrAtoDirector);

                $schoolsDom->append($idEscola, $schoolClassesDom, $directorSchoolDom);
             }

            //CARDAPIO

            //END ESCOLAS
        }

        $root->appendChild($prestacaoContas);
        $root->appendChild($schoolsDom);

        //PROFISSIONAL

        $employees = $institution->employees()->active()->notInTimeTable($teachersTimeTable)->get();

        foreach ($employees as $employee) {
            $employeesDom = $dom->createElement("edu:profissional");

            $cpfEmployee  = $dom->createElement("edu:cpfProfissional", $employee->person->individual->cpf);
            $specialtyEmployee  = $dom->createElement("edu:especialidade", $employee->employeeRoles()->first()->role->nm_funcao);

            $employeesDom->append($cpfEmployee, $specialtyEmployee);

            $schoolsEmployee = $employee->schools;

            $schoolIdExist = [];
            foreach ($schoolsEmployee as $schoolEmployee) {
                if (!in_array($schoolEmployee->cod_escola, $schoolIdExist)) {
                    $schoolIdExist[] = $schoolEmployee->cod_escola;
                    $schoolEmployee  = $dom->createElement("edu:idEscola", $schoolEmployee->cod_escola);
                    $employeesDom->appendChild($schoolEmployee);
                }
            }

            $fundebEmployee  = $dom->createElement("edu:fundeb", ($employee->recurso_fundeb ? 'true' : $employee->recurso_fundeb));

            $employeesDom->appendChild($fundebEmployee);

            $serviceEmployee  = $dom->createElement("edu:atendimento");
            $serviceDataEmployee  = $dom->createElement("edu:data", '0000-00-00');
            $serviceLocalEmployee  = $dom->createElement("edu:local", '-');

            $serviceEmployee->append($serviceDataEmployee, $serviceLocalEmployee);

            $employeesDom->appendChild($serviceEmployee);

            $root->appendChild($employeesDom);
        }
        //END
        $dom->appendChild($root);


        return $dom->saveXML();
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

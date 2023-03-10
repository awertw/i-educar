<?php

namespace App\Queries\SagresExport;

use App\Models\FrequenciaAluno;
use App\Models\LegacyInstitution;

class ExportQuery
{
    public function getInstitution(int $institutionId): LegacyInstitution
    {
        $teste = LegacyInstitution::where('cod_instituicao', $institutionId)->with(['schools' => function($query) {
            $query->where('cod_escola', 8);
        }])->get();

//        return LegacyInstitution::find($institutionId);
        return $teste[0];
    }

    public function getTotalEnrollmentAbsencesByFrequency(int $enrollmentId, string $startDate, string $endDate): int
    {
        $studentAbsencesFrequencys = FrequenciaAluno::where('ref_cod_matricula', $enrollmentId)->with(['frequency' => function($query) use($startDate, $endDate) {
            $query->whereDate('frequencia.data', '<=', $endDate);
            $query->whereDate('frequencia.data', '>=', $startDate);
        }])->get();

        $qtdAbsences = 0;
        foreach ($studentAbsencesFrequencys as $studentAbsencesFrequency) {
            $absencesClass = $studentAbsencesFrequency['aulas_faltou'];

            if ($absencesClass == 'undefined' || empty($absencesClass)) {
                $qtdAbsences++;
                continue;
            }

            $absencesClassExplode = explode(',', $absencesClass);
            $qtdAbsences = count($absencesClassExplode);

        }

        return $qtdAbsences;
    }

    public function getSchoolClassSnackMenu(int $enrollmentId, string $startDate, string $endDate): int
    {
        $studentAbsencesFrequencys = FrequenciaAluno::where('ref_cod_matricula', $enrollmentId)->with(['frequency' => function($query) use($startDate, $endDate) {
            $query->whereDate('frequencia.data', '<=', $endDate);
            $query->whereDate('frequencia.data', '>=', $startDate);
        }])->get();

        $qtdAbsences = 0;
        foreach ($studentAbsencesFrequencys as $studentAbsencesFrequency) {
            $absencesClass = $studentAbsencesFrequency['aulas_faltou'];

            if ($absencesClass == 'undefined' || empty($absencesClass)) {
                $qtdAbsences++;
                continue;
            }

            $absencesClassExplode = explode(',', $absencesClass);
            $qtdAbsences = count($absencesClassExplode);

        }

        return $qtdAbsences;
    }
}

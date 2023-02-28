<?php

namespace App\Services\SagresExport;

class DataConverter
{
    public function sexoConverter(?string $sexo): int
    {
        $sexoSagres = [
            'M' => 1,
            'F' => 2
        ];

        return (!empty($sexo) ? $sexoSagres[$sexo] : 3);
    }

    public function schoolClassTurnConverter(int $turno_id): string
    {
        $turnSagres = [
            1 => 'Matutino',
            2 => 'Vespertino',
            3 => 'Noturno',
            4 => 'Integral',
        ];

        return $turnSagres[$turno_id];
    }

    public function modalityCourseConverter(int $modalidade_id): string
    {
        $modalitySagres = [
            1 => 'Educação Infantil',
            2 => 'Ensino Fundamental',
            3 => 'Ensino Médio',
            4 => 'Educação de Jovens e Adultos',
        ];

        return $modalitySagres[$modalidade_id];
    }

    public function removeCharacters(?string $string): ?string
    {
        if (!empty($string)) {
            preg_replace('/[0-9\@\.\;\" "]+/', '', $string);
        }

        return $string;
    }
}

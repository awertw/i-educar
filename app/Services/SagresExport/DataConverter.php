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

    public function cpfInstitutionConverter(?string $cpf): string
    {
        if (strlen($cpf) > 11) {
            return $cpf;
        }

        if (!empty($cpf)) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
        }

        return "000.000.000-00";
    }
}

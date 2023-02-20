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
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SagresExportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data_inicial' => [
                'required',
                'date_format:d/m/Y',
            ],
            'data_final' => [
                'required',
                'date_format:d/m/Y',
            ],
            'ref_cod_instituicao' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'data_inicial.required' => 'A data inicial é obrigatória.',
            'data_inicial.date_format' => 'O campo data inicial deve ser uma data válida.',
            'data_final.required' => 'A data final é obrigatória.',
            'data_final.date_format' => 'O campo data final deve ser uma data válida.',
            'ref_cod_instituicao.required' => 'A instituição é obrigatória.',
        ];
    }
}

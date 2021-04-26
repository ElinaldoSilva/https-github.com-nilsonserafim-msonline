<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class homeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'falecido'=>['required', 'max:100'],
            'Capela'=>['required', 'max:6'],
            'declaracao_obito'=>['required', 'max:15'],
            'munic_falecimento'=>['required', 'max:20'],
            'local_falecimento'=>['required', 'max:50'],
        ];
    }
}

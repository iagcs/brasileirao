<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'time_visitante_id' => 'required|integer|numeric',
            'time_visitante_id' => 'required|integer|numeric',
            'gols_visitante'    => 'required|integer|numeric',
            'gols_em_casa'      => 'required|integer|numeric'
        ];
    }
}

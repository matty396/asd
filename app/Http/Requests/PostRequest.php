<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return
        [
			'id' => 'required',
			'socio_nro' => 'required',
			'id_servicio' => 'required',
			'vto_1' => 'required',
			'importe_1' => 'required',
			'vto_2' => 'required',
			'importe_2' => 'required',
			'vto_3' => 'required',
			'importe_3' => 'required',
        ];
    }
}

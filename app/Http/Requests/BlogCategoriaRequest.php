<?php

namespace Soft\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoriaRequest extends FormRequest
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
           'nombre' => 'required|unique:blog_categorias',

        ];
    }


    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre no puede estar vacio',
            'nombre.unique' => 'El nombre Ingresado ya se encuentra en uso por otra categoria',
        ];
    }
}

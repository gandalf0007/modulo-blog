<?php

namespace Soft\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Soft\Http\Requests\Request;
use Illuminate\Validation\Rule;


class BlogStoreRequest extends FormRequest
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
           //que sea unico pero que ignore si probiene del mismo item es decir cuando se hace un update
           'titulo' => 'required|unique:blog_posts',
           'descripcioncorta' => 'required',
           'descripcionlarga' => 'required',

        ];

       
    }


    public function messages()
    {
        return [
            'titulo.required' => 'El campo Titulo no puede estar vacio',
            'titulo.unique' => 'el Titulo Ingresado ya se encuentra en uso',
        ];
    }


}

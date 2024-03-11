<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=212,height=214|required: true',
            'name' => 'required: true| max:30',
            'occupation' => 'required: true| max:30',
            'content' => 'required: true| max:200'
        ];
    }

    public function messages(): array
    {
        return [
            'image.dimensions' => 'Tiene que ser anchura 212px y altura de 214px',
            'image.image' => 'No es una imagen',
            'image.max' => 'Es muy grande',
        ];
    }
}

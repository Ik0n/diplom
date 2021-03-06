<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => [
                'max:191',
                'min:1',
                'regex:/^[\dA-ZЁА-Я][ \da-zа-яё]*$/u',
                'required',
            ],
            'about' => [
                'max:191',
                'min:0'
            ],
            'amount' => [
                'numeric',
                'required',
            ],
            'price' => [
                'numeric',
                'required'
            ]
        ];
    }
}

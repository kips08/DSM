<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DrawRequestUpdateRequest extends FormRequest
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
            'number' => [
                'required',
                'unique:requests,number',
                'max:255',
                'string',
            ],
            'object_name' => ['required', 'max:255', 'string'],
            'ship_type' => ['nullable', 'max:255', 'string'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }
}

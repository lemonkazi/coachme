<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'token' => 'required',  
            'new_password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',          
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'token.required' => trans('messages.token.required'),
            'new_password.required' => trans('messages.password.required'),
            'new_password.min' => trans('messages.password.min'),
            'new_password.same' => trans('messages.password.same'),
        ];
    }
}

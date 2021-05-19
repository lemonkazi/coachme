<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class ProfilePasswordUpdateRequest extends FormRequest
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
            'current_password' => 'filled',
            'new_password' => 'filled|min:8|same:confirm_new_password',
            'confirm_new_password' => 'filled',
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
            'current_password.filled' => trans('messages.current_password.required'),
            //'current_password.min' => trans('messages.current_password.min'),
            'new_password.filled' => trans('messages.new_password.required'),
            'new_password.min' => trans('messages.new_password.min'),
            'new_password.same' => trans('messages.new_password.same')
        ];
    }
}

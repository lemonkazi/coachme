<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class LoginRequest extends FormRequest
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
            'username' => 'required_if:grant_type,password|email',
            'password' => 'required_if:grant_type,password',
            'refresh_token' => 'required_if:grant_type,refresh_token',
            'grant_type' => 'required|in:password,refresh_token',
            'client_id' => 'required|numeric|max:18446744073709551615',
            'client_secret' => 'required',
            'client_type' => 'required_if:grant_type,password|in:iOS,Android,Web',
            'push_token' => 'required_if:client_type,iOS,Android',
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
            'username.required_if' => trans('messages.email.required'),
            'username.email' => trans('messages.email.email'),
            'password.required_if' => trans('messages.password.required'),
            'refresh_token.required_if' => trans('oauth.refresh_token.required'),
            'grant_type.required' => trans('oauth.grant_type.required'),
            'grant_type.in' => trans('oauth.grant_type.in'),
            'client_id.required' => trans('oauth.client_id.required'),
            'client_secret.required' => trans('oauth.client_secret.required'),
            'client_type.required_if' => trans('oauth.client_type.required'),
            'client_type.in' => trans('oauth.client_type.in'),
            'push_token.required_if' => trans('oauth.push_token.required'),
        ];
    }
}

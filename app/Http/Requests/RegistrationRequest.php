<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class RegistrationRequest extends FormRequest
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
            'city_id' => 'required|numeric',
            'city_block_id' => 'nullable|numeric',
            'name' => 'required|string|max:50',
            'nickname' => 'required|string|max:50',
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'avatar_image_path' => 'nullable|url',
            'gender' => 'nullable|string|in:MALE,FEMALE,OTHER',
            'birthday' => 'nullable|date_format:Y/m/d',
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
            'city_id.required' => trans('messages.city_id.required'),
            'city_id.numeric' => trans('messages.city_id.numeric'),
            'city_block_id.numeric' => trans('messages.city_block_id.required'),
            'name.required' => trans('messages.name.required'),
            'name.max' => trans('messages.name.max'),
            'nickname.required' => trans('messages.nickname.required'),
            'nickname.max' => trans('messages.nickname.max'),
            'email.required' => trans('messages.email.required'),
            'email.string' => trans('messages.email.string'),
            'email.email' => trans('messages.email.email'),
            'email.max' => trans('messages.email.max'),
            'password.required' => trans('messages.password.required'),
            'password.min' => trans('messages.password.min'),
            'password.confirmed' => trans('messages.password.confirmed'),
            'image_path.url' => trans('messages.image.url'),
            'gender.string' => trans('messages.gender.string'),
            'gender.in' => trans('messages.gender.in'),
            'birthday.date_format' => trans('messages.birthday.date_format'),
        ];
    }
}

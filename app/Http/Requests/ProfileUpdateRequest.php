<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'city_id' => 'filled|numeric',
            'city_block_id' => 'filled|numeric',
            'name' => 'filled|string|max:50',
            'nickname' => 'filled|string|max:50',
            'email' => 'filled|string|email|max:255',
            'password' => 'filled|min:8|confirmed',
            'password_confirmation' => 'filled',
            'image' => 'nullable|url',
            'gender' => 'nullable|string|in:MALE,FEMALE,OTHER',
            'birthday' => 'nullable|date:Y/m/d',
            'phone_number' => 'filled|string',
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
            'city_id.filled' => trans('messages.city_id.required'),
            'city_id.numeric' => trans('messages.city_id.numeric'),
            'city_block_id.filled' => trans('messages.city_block_id.required'),
            'city_block_id.numeric' => trans('messages.city_block_id.required'),
            'name.filled' => trans('messages.name.required'),
            'name.max' => trans('messages.name.max'),
            'nickname.filled' => trans('messages.nickname.required'),
            'nickname.max' => trans('messages.nickname.max'),
            'email.filled' => trans('messages.email.required'),
            'email.string' => trans('messages.email.string'),
            'email.email' => trans('messages.email.email'),
            'email.max' => trans('messages.email.max'),
            'password.filled' => trans('messages.password.required'),
            'password.confirmed' => trans('messages.password.confirmed'),
            'password.min' => trans('messages.password.min'),
            'image.url' => trans('messages.image.url'),
            'gender.filled' => trans('messages.gender.required'),
            'gender.string' => trans('messages.gender.string'),
            'gender.in' => trans('messages.gender.in'),
            'birthday.filled' => trans('messages.birthday.required'),
            'birthday.date' => trans('messages.birthday.date_format'),
            'phone_number.filled' => trans('messages.phone_number.required'),
            'phone_number.string' => trans('messages.phone_number.string'),
        ];
    }
}

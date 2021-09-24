<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class UserUpdateRequest extends FormRequest
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
            'authority' => 'required|in:SERVICE_ADMIN,CITY_ADMIN,USER',
            'city_id' => 'required_if:authority,CITY_ADMIN|numeric',
            'city_block_id' => 'nullable|numeric',
            'nickname' => 'filled|string|max:50',
            'name' => 'filled|string|max:50',            
            'email' => 'filled|string|email|max:255',
            'avatar_image_path' => 'nullable|url',
            'background_image_path' => 'nullable|url',
            'gender' => 'nullable|in:MALE,FEMALE,OTHER',
            'birthday' => 'nullable|date:Y/m/d'
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
            'city_id.required_if' => trans('messages.city_id.required'),
            'city_id.numeric' => trans('messages.city_id.numeric'),
            'city_block_id.numeric' => trans('messages.city_block_id.numeric'),
            'name.filled' => trans('messages.name.required'),
            'name.max' => trans('messages.name.max'),
            'nickname.filled' => trans('messages.nickname.required'),
            'nickname.max' => trans('messages.nickname.max'),
            'email.filled' => trans('messages.email.required'),
            'email.string' => trans('messages.email.string'),
            'email.email' => trans('messages.email.email'),
            'email.max' => trans('messages.email.max'),
            'avatar_image_path.url' => trans('messages.image.url'),
            'background_image_path.url' => trans('messages.image.url'),
            'gender.string' => trans('messages.gender.string'),
            'gender.in' => trans('messages.gender.in'),
            'birthday.date' => trans('messages.birthday.date_format'),
        ];
    }
}

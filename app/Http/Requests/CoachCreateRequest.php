<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class CoachCreateRequest extends FormRequest
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
            'authority' => 'required|in:SUPER_ADMIN,RINK_USER,COACH_USER',
            'city_id' => 'required_if:authority,CITY_ADMIN,USER|numeric',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:8',
            'avatar_image_path' => 'nullable|url',
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
            'authority.required' => trans('messages.authority.required'),
            'authority.in' => trans('messages.authority.in'),
            'city_id.required_if' => trans('messages.city_id.required'),
            'city_id.numeric' => trans('messages.city_id.numeric'),
            'name.required' => trans('messages.name.required'),
            'name.max' => trans('messages.name.max'),
            'email.required' => trans('messages.email.required'),
            'email.string' => trans('messages.email.string'),
            'email.email' => trans('messages.email.email'),
            'email.max' => trans('messages.email.max'),
            'password.required' => trans('messages.password.required'),
            'password.min' => trans('messages.password.min'),
            'image.url' => trans('messages.image.url'),
            'gender.string' => trans('messages.gender.string'),
            'gender.in' => trans('messages.gender.in'),
            'birthday.date' => trans('messages.birthday.date_format')
        ];
    }
}

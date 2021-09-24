<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class ContactCreateRequest extends FormRequest
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
            'city_id' => 'nullable|numeric',
            'user_id' => 'nullable|numeric',
            'title' => 'required|max:100',
            'user_name' => 'required|max:255',
            'user_email' => 'required|string|email|max:255',
            //'user_phone_number'=>'nullable|numeric|digits_between:9,11',
            'user_birthday' => 'nullable|date_format:Y/m/d',
            'content' => 'required',
            'status' => 'nullable|in:PENDING,IN_PROGRESS,COMPLETED',
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
            'city_id.numeric' => trans('messages.city_id.numeric'),
            'user_id.numeric' => trans('messages.user_id.numeric'),
            'title.required' => trans('contacts.title.required'),
            'title.max' => trans('contacts.title.max'),
            'user_name.required' => trans('contacts.name.required'),
            'user_name.max' => trans('contacts.name.max'),
            'user_email.required' => trans('messages.email.required'),
            'user_email.string' => trans('messages.email.string'),
            'user_email.email' => trans('messages.email.email'),
            'uesr_email.max' => trans('messages.email.max'),
            //'user_phone_number.numeric'=>trans('contacts.phone_number.numeric'),
            //'user_phone_number.digits_between'=>trans('contacts.phone_number.digits_between'),            
            'user_birthday.date_format' => trans('contacts.user_birthday.date_format'),
            'content.required' => trans('contacts.description.required'),
            'status.in' => trans('contacts.status.in'),
        ];
    }
}

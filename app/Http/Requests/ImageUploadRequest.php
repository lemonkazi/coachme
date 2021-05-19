<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class ImageUploadRequest extends FormRequest
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
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
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
            'file.required' => trans('messages.image.required'),
            'file.image' => trans('messages.image.image'),
            'file.mimes' => trans('messages.image.mimes'),
            'file.max' => trans('messages.image.max'),
        ];
    }
}

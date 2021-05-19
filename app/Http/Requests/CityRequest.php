<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;
class CityRequest extends FormRequest
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
            'name'=>'required|max:255',
            'image_path' => 'required|url',
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
            'name.required' => trans('cities.name.required'),
            'name.max' => trans('cities.name.max'),
            'image_path.required' => trans('cities.image_path.required'),
            'image_path.url' => trans('cities.image_path.url'),
        ];
    }
}

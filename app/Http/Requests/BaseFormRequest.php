<?php
namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $message = $validator->errors()->first();
        return redirect()->back()->withInput()->withErrors($validator);

        //throw new HttpResponseException(response()->error($message, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
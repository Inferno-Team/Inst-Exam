<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Traits\LocalResponse;

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
            'name' =>  'required|exists:users,name',
            'password' =>  'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'اسم المستخدم يجب ان يكون موجود',
            'name.exists' => 'اسم المستخدم غير موجود',
            'password.required' => 'كلمة المرور يجب ان تكون موجودة',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(LocalResponse::returnError('', 401, $validator->errors()));
    }
}

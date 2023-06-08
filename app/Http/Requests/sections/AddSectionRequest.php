<?php

namespace App\Http\Requests\sections;

use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:sections,name',
            'en_name' => 'required|unique:sections,en_name',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'هذا الحقل مطلوب',
            'name.unique' => 'اسم هذا القسم موجود بالفعل',
            'en_name.required' => 'هذا الحقل مطلوب',
            'en_name.unique' => 'اسم هذا القسم موجود بالفعل',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(LocalResponse::returnError('بيانات خاطئة', 400, $validator->errors()));
    }
}

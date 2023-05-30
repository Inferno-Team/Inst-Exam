<?php

namespace App\Http\Requests\moderator;
use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddNewStudentRequest extends FormRequest
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
            'first_name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'last_name' => 'required',
            'birth_place' => 'required',
            'gender' => 'required',
            'field_number' => 'required',
            'recruitment_division' => 'required',
            'city' => 'required',
            'address' => 'required',
            'nationalty' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(LocalResponse::returnError('بيانات خاطئة', 400, $validator->errors()));
    }
}

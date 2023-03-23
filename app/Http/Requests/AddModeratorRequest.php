<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\Hash;

class AddModeratorRequest extends FormRequest
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
            'last_name' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'year_id' => 'required|exists:years,id|unique:year_moderators,year_id'
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'هذا الحقل مطلوب',
            'last_name.required' => 'هذا الحقل مطلوب',
            'phone_number.required' => 'هذا الحقل مطلوب',
            'password.required' => 'هذا الحقل مطلوب',
            'year_id.required' => 'هذا الحقل مطلوب',
            'year_id.exists' => 'هذا الرقم يجب ان يكون ضمن جدول السنوات',
            'year_id.unique' => 'هذه السنة تمتلك مشرف بالفعل',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(LocalResponse::returnError('بيانات خاطئة', 400, $validator->errors()));
    }
    public function values()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($this->password),
            'type' => 'مشرف',
        ];
    }
}

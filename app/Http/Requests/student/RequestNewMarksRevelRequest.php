<?php

namespace App\Http\Requests\student;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\Hash;

class RequestNewMarksRevelRequest extends FormRequest
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
            "date_financial_receipt" => "required|numeric",
            "no_financial_receipt" => "required|numeric",
        ];
    }
    public function messages()
    {
        return [
            'date_financial_receipt.required' => 'هذا الحقل مطلوب',
            'date_financial_receipt.numeric' => "ليس تاريخ صحيح",
            'no_financial_receipt.required' => 'هذا الحقل مطلوب',
            'no_financial_receipt.numeric' => "يجب ان يكون رقم",

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(LocalResponse::returnError('بيانات خاطئة', 400, $validator->errors()));
    }
    public function values()
    {
        return [
            "date_financial_receipt" => $this->date_financial_receipt,
            "no_financial_receipt" => $this->no_financial_receipt,
            "student_id" => Auth::user()->id,
        ];
    }
}

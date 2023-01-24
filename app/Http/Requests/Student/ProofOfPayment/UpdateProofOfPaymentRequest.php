<?php

namespace App\Http\Requests\Student\ProofOfPayment;

use App\Http\Requests\ResponseRequest;

class UpdateProofOfPaymentRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('student')->user()->hasRole(['STUDENT']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paymentOption'  => ['required', 'in:ENTRANCE FEE,PRELIM,MIDTERM,PRE-FINAL,FINAL,FULL PAYMENT,OTHER'],
            'other'          => ['required_if:paymentOption,OTHER'],
            'amount'         => ['required'],
            'paymentReceipt' => ['sometimes', 'required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
        ];
    }
}

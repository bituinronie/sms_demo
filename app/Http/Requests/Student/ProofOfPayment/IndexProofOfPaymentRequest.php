<?php

namespace App\Http\Requests\Student\ProofOfPayment;

use App\Http\Requests\ResponseRequest;

class IndexProofOfPaymentRequest extends ResponseRequest
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
            //
        ];
    }
}

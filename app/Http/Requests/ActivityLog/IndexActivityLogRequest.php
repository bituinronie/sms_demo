<?php

namespace App\Http\Requests\ActivityLog;

use App\Http\Requests\ResponseRequest;

class IndexActivityLogRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole([
            'ADMIN',
            'ACCOUNTING',
            'ADMISSION',
            'AUDITOR',
            'BASIC EDUCATION',
            'CASHIER',
            'DEAN',
            'FACULTY',
            'FOREIGN',
            'HUMAN RESOURCE',
            'INFORMATION TECHNOLOGY SERVICE',
            'PROGRAM HEAD',
            'REGISTRAR',
            'SECRETARY',
            'SCHOLARSHIP',
            'STUDENT'
        ]);
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

<?php

namespace App\Http\Requests\Room;

use App\Http\Requests\ResponseRequest;

class CreateRoomRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('user')->user()->hasRole(['ADMIN']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'       => ['required', 'string', 'unique:rooms,code,NULL,id,branch_id,'.$this->getBuildingBranchId($this->building)],
            'name'       => ['required', 'string', 'unique:rooms,name,NULL,id,branch_id,'.$this->getBuildingBranchId($this->building)],
            'type'       => ['required', 'string', 'in:LECTURE,LABORATORY'],
            'laboratory' => ['required_if:type,LABORATORY', 'string'],
            'building'   => ['required', 'string'],
        ];
    }
}

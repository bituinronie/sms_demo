<?php

namespace App\Repositories\Admission\Miscellaneous;

use App\Repositories\BaseRepository;

class EmailValidationAdmissionRepository extends BaseRepository
{
    public function execute(){
			
		return $this->success("Email Validation", ["emailAddress"=>"Email is available"]);
	}
}
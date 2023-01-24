<?php

namespace App\Repositories\Student\Auth;

use App\Repositories\BaseRepository;

class RefreshStudentRepository extends BaseRepository
{
    public function execute(){	
					
		return $this->respondWithToken(auth('student')->refresh());
	}
}
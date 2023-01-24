<?php

namespace App\Repositories\Student\Auth;

use App\Repositories\BaseRepository;

class LogoutStudentRepository extends BaseRepository
{
    public function execute(){

		auth('student')->logout();

		return $this->logoutMessage("Succesfully logged out");
	}
}
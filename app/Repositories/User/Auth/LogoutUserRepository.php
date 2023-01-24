<?php

namespace App\Repositories\User\Auth;

use App\Repositories\BaseRepository;

class LogoutUserRepository extends BaseRepository
{
    public function execute(){

		auth('user')->logout();

		return $this->logoutMessage("Succesfully logged out");
	}
}
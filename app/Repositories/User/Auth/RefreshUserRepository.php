<?php

namespace App\Repositories\User\Auth;

use App\Repositories\BaseRepository;

class RefreshUserRepository extends BaseRepository
{
    public function execute(){	
					
		return $this->respondWithToken(auth('user')->refresh());
	}
}
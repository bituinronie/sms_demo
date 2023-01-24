<?php

namespace App\Repositories\Curriculum\Miscellaneous;

use App\Repositories\BaseRepository;

class CodeValidationCurriculumRepository extends BaseRepository
{
    public function execute(){
			
		return $this->success("Curriculum Code Validation", ["code"=>"Curriculum code is available"]);
	}
}
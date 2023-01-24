<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

trait FileDirectory
{

    protected function studentFolder($priorityNumber){
		
		return "public/student/{$priorityNumber}";
	}

	
    protected function employeeFolder($employeeNumber){
		
		return "public/employee/{$employeeNumber}";
	}
}
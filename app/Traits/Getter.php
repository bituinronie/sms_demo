<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

use Str, Arr;

use App\Models\Admission\ApplicantAdmission,
	App\Models\Branch\Branch,
	App\Models\Department\Department,
	App\Models\Program\Program,
	App\Models\Strand\Strand,
	App\Models\Employee\Employee,
	App\Models\Building\Building,
	App\Models\Laboratory\Laboratory,
	App\Models\Subject\Subject,
	App\Models\Section\Section,
	App\Models\Room\Room;

trait Getter
{
	protected function getIndexData($model,  $getForeign = [], $only = []){

		foreach($model as $modelCtr => $modelValue){

			$keyName = array_keys($modelValue->toArray());
			
			for ($i=0; $i < count($keyName); $i++) {

				if ($this->showOnly($keyName[$i], $only)) {

					$data[$modelCtr][$i] = [Str::camel($keyName[$i]) => $modelValue[$keyName[$i]]];
				}

				if ($only == []) {

					$data[$modelCtr][$i] = [Str::camel($keyName[$i]) => $modelValue[$keyName[$i]]];
				}

			}

			if (Arr::accessible($getForeign)) {

				foreach (collect($getForeign) as $foreignKey => $foreignKeyData) {

					foreach ($foreignKeyData as $foreignValue) {

						if ($modelValue->$foreignKey) {

							$foreign[Str::camel($foreignKey)][Str::camel($foreignValue)] = $modelValue->$foreignKey->$foreignValue;

						}else{

							$foreign[$foreignKey] = null;
						}
					}
				}
			}
			
			$groupData[$modelCtr] = Arr::collapse([Arr::collapse($data[$modelCtr]), $foreign ?? []]);
		}

		return $groupData ?? [];

	}

	
	private function showOnly($keyName, $only){

		foreach ($only as $onlyCtr => $onlyKeyName) {

            if ($keyName == $onlyKeyName) {

                return true;
            }
        }

        return false;
	}


	protected function getListData($model, $getForeign = [], $only = []){

		return $this->getIndexData($model, $getForeign, $only);
        
	}



	protected function getShowData($model, $getForeign = [], $only = []){
		
		$keyName = array_keys($model->toArray());

		for ($i=0; $i < count($keyName); $i++) {

			if ($this->showOnly($keyName[$i], $only)) {

				$data[$i] = [Str::camel($keyName[$i]) => $model[$keyName[$i]]];
			}

			if ($only == []) {

				$data[$i] = [Str::camel($keyName[$i]) => $model[$keyName[$i]]];
			}
			
		}


		if (Arr::accessible($getForeign)) {

			foreach (collect($getForeign) as $foreignKey => $foreignKeyData) {

				foreach ($foreignKeyData as $foreignValue) {

					if ($model->$foreignKey) {

						$foreign[Str::camel($foreignKey)][Str::camel($foreignValue)] = $model->$foreignKey->$foreignValue;

					}else{

						$foreign[$foreignKey] = null;
					}
				}
			}
		}

		
		return Arr::collapse([Arr::collapse($data), $foreign ?? []]);
            
	}



    protected function getPersonalId($priorityNumber){

		$admission = ApplicantAdmission::where("priority_number", "=", $priorityNumber)->firstOrFail();
		return $admission->applicant_id;

    }



	protected function getBranchId($code){

		$branch = Branch::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $branch->id;

    }



	protected function getDepartmentId($code){

		$department = Department::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $department->id;

    }



	protected function getProgramId($code){

		$program = Program::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $program->id;
  
    }



	protected function getStrandId($code){

		$strand = Strand::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $strand->id;

    }



	protected function getEmployeeId($employeeNumber){

		$employee = Employee::where('employee_number', '=', $employeeNumber)->firstOrFail();
		return $employee->id;

    }
	

	
	protected function getLaboratoryId($code){

		$laboratory = Laboratory::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $laboratory->id;
    }

	

	protected function getBuildingId($code){

		$building = Building::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $building->id;
    }



	protected function getSubjectId($code){

		$subject = Subject::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $subject->id;
    }



	protected function getSectionId($code){

		$section = Section::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $section->id;
    }



	protected function getRoomId($code){

		$room = Room::withTrashed()->where('code', '=', strtoupper($code))->firstOrFail();
		return $room->id;
    }
}
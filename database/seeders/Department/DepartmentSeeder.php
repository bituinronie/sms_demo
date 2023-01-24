<?php

namespace Database\Seeders\Department;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Department\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = array(
                        [
                            'code'        => 'ICTDU',
                            'name'        => 'INFORMATION AND COMMUNICATIONS TECHNOLOGY DEVELOPMENT UNIT',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        ],
                        [
                            'code'       => 'CCIS',
                            'name'       => 'COLLEGE OF COMPUTING AND INFORMATION SCIENCES',
                            'employee_id' => null,
                            'type'       => 'ACADEMIC',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now(),
                        ],
                        [
                            'code'        => 'COB',
                            'name'        => 'COLLEGE OF BUSINESS',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),

                        ],
                        [
                            'code'        => 'COE',
                            'name'        => 'COLLEGE OF ENGINEERING',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        
                        ],
                        [
                            'code'        => 'CASS',
                            'name'        => 'COLLEGE OF ARTS AND SOCIAL SCIENCES',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                            
                        ],
                        [
                            'code'        => 'CHM',
                            'name'        => 'COLLEGE OF HOSPITALITY MANAGEMENT',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                            
                        ],
                        [
                            'code'        => 'COC',
                            'name'        => 'COLLEGE OF CRIMINOLOGY',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        
                        ],
                        [
                            'code'        => 'COED',
                            'name'        => 'COLLEGE OF EDUCATION',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        
                        ],
                        [
                            'code'        => 'CON',
                            'name'        => 'COLLEGE OF NURSING',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        
                        ],
                        [
                            'code'        => 'ND',
                            'name'        => 'NSTP DEPARTMENT',
                            'employee_id' => null,
                            'type'        => 'ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        
                        ],
                        [
                            'code'        => 'REGISTRAR OFFICE',
                            'name'        => 'REGISTRAR OFFICE',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        
                        ],
                        [
                            'code'        => 'ADMISSION OFFICE',
                            'name'        => 'ADMISSION OFFICE',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                    
                        ],
                        [
                            'code'        => 'ACCOUNTING OFFICE',
                            'name'        => 'ACCOUNTING OFFICE',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                            
                        ],
                        [
                            'code'        => 'SCHOLARSHIP OFFICE',
                            'name'        => 'SCHOLARSHIP OFFICE',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                            
                        ],
                        [
                            'code'        => 'FOREIGN AFFRAIRS OFFICE',
                            'name'        => 'FOREIGN AFFRAIRS OFFICE',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                            
                        ],
                        [
                            'code'        => 'HR',
                            'name'        => 'HUMAN RESOURCES',
                            'employee_id' => null,
                            'type'        => 'NON-ACADEMIC',
                            'branch_id'   => 1,
                            'created_at'  => Carbon::now(),
                        ],
        );

        Department::insert($seed);
    }
}

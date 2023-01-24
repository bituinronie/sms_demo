<?php

namespace Database\Seeders\Program;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Program\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Command : php artisan db:seed --class=Database\\Seeders\\Program\\ProgramSeeder
     * @return void
     */
    public function run()
    {
        $seed = array(
                        //CCIS
                        [
                            'code'          => 'BSCS',
                            'name'          => 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSIS',
                            'name'          => 'BACHELOR OF SCIENCE IN INFORMATION SYSTEMS',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSIT - NETAD',
                            'name'          => 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY (MAJOR IN NETWORK ADMINISTRATION)',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSIT - MOBILE DEV',
                            'name'          => 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY (MAJOR IN MOBILE DEVELOPMENT)',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSEMC - GAME DEV',
                            'name'          => 'BACHELOR OF SCIENCE IN ENTERTAINMENT AND MULTIMEDIA COMPUTING (MAJOR IN GAME DEVELOPMENT)',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSEMC - DIGITAL ANIMATION',
                            'name'          => 'BACHELOR OF SCIENCE IN ENTERTAINMENT AND MULTIMEDIA COMPUTING (MAJOR IN DIGITAL ANIMATION)',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'ACT',
                            'name'          => 'ASSOCIATE IN COMPUTER TECHNOLOGY',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 2,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //CASS
                        [
                            'code'          => 'BAC',
                            'name'          => 'BACHELOR OF ARTS IN COMMUNICATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 5,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSSW',
                            'name'          => 'BACHELOR OF SCIENCE IN SOCIAL WORK',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 5,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //COED
                        [
                            'code'          => 'BEED',
                            'name'          => 'BACHELOR OF ELEMENTARY EDUCATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 8,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BPE',
                            'name'          => 'BACHELOR OF PHYSICAL EDUCATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 8,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSEM',
                            'name'          => 'BACHELOR OF SECONDARY EDUCATION MAJOR IN MATHEMATICS',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 8,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSEE',
                            'name'          => 'BACHELOR OF SECONDARY EDUCATION MAJOR IN ENGLISH',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 8,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //COB
                        [
                            'code'          => 'BSA',
                            'name'          => 'BACHELOR OF SCIENCE IN ACCOUNTING',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 3,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()

                        ],
                        [
                            'code'          => 'BSAI',
                            'name'          => 'BACHELOR OF SCIENCE IN ACCOUNTING INFORMATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 3,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()

                        ],
                        [
                            'code'          => 'BSBA',
                            'name'          => 'BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 3,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSCA',
                            'name'          => 'BACHELOR OF SCIENCE IN CUSTOMS ADMINISTRATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 3,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSOA',
                            'name'          => 'BACHELOR OF SCIENCE IN OFFICE ADMINISTRATION',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 3,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSREM',
                            'name'          => 'BACHELOR OF SCIENCE IN REAL ESTATE MANAGEMENT',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 3,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //COE
                        [
                            'code'          => 'BSCE',
                            'name'          => 'BACHELOR OF SCIENCE IN COMPUTER ENGINEERING',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 4,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSELE',
                            'name'          => 'BACHELOR OF SCIENCE IN ELECTRONICS ENGINEERING',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 4,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //CON
                        [
                            'code'          => 'BSN',
                            'name'          => 'BACHELOR OF SCIENCE IN NURSING',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 9,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //CHM
                        [
                            'code'          => 'BSHM',
                            'name'          => 'BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 6,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
                        [
                            'code'          => 'BSTM',
                            'name'          => 'BACHELOR OF SCIENCE IN TOURISM MANAGEMENT',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 6,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //COC
                        [
                            'code'          => 'BSC',
                            'name'          => 'BACHELOR OF SCIENCE IN CRIMINOLOGY',
                            'type'          => 'UNDERGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 7,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],

                        //GRADUATE STUDIES
                        [
                            'code'          => 'MIT',
                            'name'          => 'MASTER IN INFORMATION TECHNOLOGY',
                            'type'          => 'POSTGRADUATE',
                            'duration'      => 4,
                            'employee_id'   => null,
                            'department_id' => 2,
                            'branch_id'     => 1,
                            'created_at'    => Carbon::now()
                        ],
        );

        Program::insert($seed);
    }
}

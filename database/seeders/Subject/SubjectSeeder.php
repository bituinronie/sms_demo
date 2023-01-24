<?php

namespace Database\Seeders\Subject;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Subject\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = array(
                        //CCIS
                        [
                            'code'            => 'PROG1_L',
                            'name'            => 'FUNDAMENTALS OF PROGRAMMING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 5,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'ITC',
                            'name'            => 'INTRODUCTION TO COMPUTING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'DMATH',
                            'name'            => 'DISCRETE MATHEMATICS',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'PROG2_L',
                            'name'            => 'INTERMEDIATE PROGRAMMING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'DSAA_L',
                            'name'            => 'DATA STRUCTURES AND ALGORITHMS',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'SIPP',
                            'name'            => 'SOCIAL ISSUES AND PROFESSIONAL PRACTICE',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'OS_L',
                            'name'            => 'OPERATING SYSTEMS',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'IM_L',
                            'name'            => 'INFORMATION MANAGEMENT',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'ET_L',
                            'name'            => 'APPLICATION DEVELOPMENT AND EMERGING TECHNOLOGIES',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'SE1',
                            'name'            => 'SOFTWARE ENGINEERING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'PROG3_L',
                            'name'            => 'OBJECT ORIENTED PROGRAMMING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'IAS1_L',
                            'name'            => 'FUNDAMENTALS OF INFORMATION ASSURANCE AND SECURITY',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'ALGO',
                            'name'            => 'ALGORITHMS AND COMPLEXITY',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'NET1_L',
                            'name'            => 'DATA COMMUNICATIONS AND NETWORKING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 1,
                            'laboratory_hour' => 4,
                            'branch_id'       => 1,
                            'laboratory_id'   => 2,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'SE2',
                            'name'            => 'ADVANCED SOFTWARE ENGINEERING',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'NUMA',
                            'name'            => 'NUMERICAL ANALYSIS',
                            'type'            => 'PROFESSIONAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 2,
                            'created_at'      => Carbon::now()
                        ],
                        //END CCIS
                
                        //CASS
                        [
                            'code'            => 'CUS',
                            'name'            => 'UNDERSTANDING THE SELF',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CCW',
                            'name'            => 'THE CONTEMPORARY WORLD',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CPH',
                            'name'            => 'READINGS IN PHILIPPINE HISTORY',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CMW',
                            'name'            => 'MATHEMATICS IN THE MODERN WORLD',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CPC',
                            'name'            => 'PURPOSIVE COMMUNICATION',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CET',
                            'name'            => 'ETHICS',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CST',
                            'name'            => 'SCIENCE, TECHNOLOGY AND SOCIETY',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'CAA',
                            'name'            => 'ART APPRECIATION',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 5,
                            'created_at'      => Carbon::now()
                        ],
                        //END CASS
                
                        //COED
                        [
                            'code'            => 'FIL1',
                            'name'            => 'PAGBASA AT PAGSULAT TUNGO SA PANANALIKSIK',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'FIL2',
                            'name'            => 'MASINING NA PAGPAPAHAYAG',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'FIL3',
                            'name'            => 'ANG PANITIKANG FILIPINO',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'PE1',
                            'name'            => 'MOVEMENT ENCHANCEMENT',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 2,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'PE2',
                            'name'            => 'FITNESS EXERCISES',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 2,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'PE3',
                            'name'            => 'PHYSICAL ACTIVITIES TOWARDS HEALTH AND FITNESS 1',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 2,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'PE4',
                            'name'            => 'PHYSICAL ACTIVITIES TOWARDS HEALTH AND FITNESS II',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 2,
                            'lecture_hour'    => 1,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'LWR',
                            'name'            => 'LIFE AND WORKS OF RIZAL',
                            'type'            => 'GENERAL EDUCATION',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 8,
                            'created_at'      => Carbon::now()
                        ],
                        //END COED
                
                        //NSTP
                        [
                            'code'            => 'NSTP_1',
                            'name'            => 'CIVIC WELFARE TRAINING SERVICE 1',
                            'type'            => 'NSTP',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 10,
                            'created_at'      => Carbon::now()
                        ],
                        [
                            'code'            => 'NSTP_2',
                            'name'            => 'CIVIC WELFARE TRAINING SERVICE 2',
                            'type'            => 'NSTP',
                            'lecture_unit'    => 3,
                            'lecture_hour'    => 3,
                            'laboratory_unit' => 0,
                            'laboratory_hour' => 0,
                            'branch_id'       => 1,
                            'laboratory_id'   => null,
                            'department_id'   => 10,
                            'created_at'      => Carbon::now()
                        ]
                        //END NSTP
        );

        Subject::insert($seed);
    }
}

<?php

namespace Database\Seeders\Section;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Section\Section;

class SectionSeeder extends Seeder
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
                'code'          => 'CCIS1A',
                'type'          => 'COLLEGE',
                'year_level'    => 'FIRST YEAR',
                'semester'      => 'FIRST SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS2A',
                'type'          => 'COLLEGE',
                'year_level'    => 'FIRST YEAR',
                'semester'      => 'SECOND SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS3A',
                'type'          => 'COLLEGE',
                'year_level'    => 'SECOND YEAR',
                'semester'      => 'FIRST SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS4A',
                'type'          => 'COLLEGE',
                'year_level'    => 'FIRST YEAR',
                'semester'      => 'SECOND SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS5A',
                'type'          => 'COLLEGE',
                'year_level'    => 'THIRD YEAR',
                'semester'      => 'FIRST SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],

             [
                'code'          => 'CCIS1B',
                'type'          => 'COLLEGE',
                'year_level'    => 'FIRST YEAR',
                'semester'      => 'FIRST SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS2B',
                'type'          => 'COLLEGE',
                'year_level'    => 'FIRST YEAR',
                'semester'      => 'SECOND SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS3B',
                'type'          => 'COLLEGE',
                'year_level'    => 'SECOND YEAR',
                'semester'      => 'FIRST SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS4B',
                'type'          => 'COLLEGE',
                'year_level'    => 'FIRST YEAR',
                'semester'      => 'SECOND SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
            [
                'code'          => 'CCIS5B',
                'type'          => 'COLLEGE',
                'year_level'    => 'THIRD YEAR',
                'semester'      => 'FIRST SEMESTER',
                'class_size'    => '20',
                'branch_id'     => '1',
                'department_id' => '2',
                'created_at'    => Carbon::now(),
            ],
        );

        Section::insert($seed);
    }
}

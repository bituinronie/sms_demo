<?php

namespace Database\Seeders\Strand;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Strand\Strand; 

class StrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Command : php artisan db:seed --class=Database\\Seeders\\StrandSeeder\\StrandSeeder 
     * @return void
     */
    public function run()
    {
        $seed = array(
                        [
                            'code'       => 'ABM',
                            'name'       => 'ACCOUNTANCY, BUSINESS AND MANAGEMENT',
                            'track'      => 'ACADEMIC',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => 'STEM',
                            'name'       => 'SCIENCE, TECHNOLOGY, ENGINEERING AND MATHEMATICS',
                            'track'      => 'ACADEMIC',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => 'GAS',
                            'name'       => 'GENERAL ACADEMIC STRAND',
                            'track'      => 'ACADEMIC',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => 'HUMMS',
                            'name'       => 'HUMANITIES AND SOCIAL SCIENCES',
                            'track'      => 'ACADEMIC',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => 'HE',
                            'name'       => 'HOME ECONOMICS',
                            'track'      => 'TECHNICAL VOCATIONAL LIVELIHOOD',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => 'ICT - ANIMATION',
                            'name'       => 'INFORMATION COMMUNICATIONS AND TECHNOLOGY - ANIMATION',
                            'track'      => 'TECHNICAL VOCATIONAL LIVELIHOOD',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => 'ICT - PROGRAMMING',
                            'name'       => 'INFORMATION COMMUNICATIONS AND TECHNOLOGY - PROGRAMMING',
                            'track'      => 'TECHNICAL VOCATIONAL LIVELIHOOD',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                    );

        Strand::insert($seed);
    }
}

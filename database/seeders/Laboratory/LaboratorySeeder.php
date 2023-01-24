<?php

namespace Database\Seeders\Laboratory;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Laboratory\Laboratory;

class LaboratorySeeder extends Seeder
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
                            'code'       => 'COMP_LAB',
                            'name'       => 'COMPUTER',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'SCIENCE_LAB',
                            'name'       => 'CHEMISTRY',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'NURSING_LAB',
                            'name'       => 'NURSING',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'TECH_LAB',
                            'name'       => 'TECH',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'CRIM_LAB',
                            'name'       => 'CRIMINOLOGY',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'ENGR_LAB',
                            'name'       => 'ENGINEERING',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'KITCHEN_LAB',
                            'name'       => 'KITCHEN',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
                        [
                            
                            'code'       => 'SPEECH_LAB',
                            'name'       => 'SPEECH',
                            'amount'     => 0.0,
                            'branch_id'  => 1,
                            'created_at' => Carbon::now()
                        ],
        );

        Laboratory::insert($seed);
    }
}

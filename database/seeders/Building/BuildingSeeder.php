<?php

namespace Database\Seeders\Building;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Building\Building;

class BuildingSeeder extends Seeder
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
                            'code'       => 'IT',
                            'name'       => 'IT BUILDING',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now(),
                        ],
                        [
                            'code'       => 'RVJ',
                            'name'       => 'RVJ BUILDING',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now(),
                        ],
                        [
                            'code'       => 'SPCF_GYM',
                            'name'       => 'GYMNASIUM',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now(),
                        ],
                        [
                            'code'       => 'SJO',
                            'name'       => 'SJO BUILDING',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now(),
                        ],
                        [
                            'code'       => 'MCB',
                            'name'       => 'MCB BUILDING',
                            'branch_id'  => 1,
                            'created_at' => Carbon::now(),
                        ],
                    );
    
          Building::insert($seed);
    }
}

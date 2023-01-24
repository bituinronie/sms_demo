<?php

namespace Database\Seeders\Branch;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Branch\Branch;

class BranchSeeder extends Seeder
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
                            'code'       => '01',
                            'name'       => 'BALIBAGO',
                            'type'       => 'MAIN',
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => '02',
                            'name'       => 'MIRANDA',
                            'type'       => 'SUB',
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => '03',
                            'name'       => 'CALOOCAN',
                            'type'       => 'SUB',
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => '04',
                            'name'       => 'SAN FERNANDO',
                            'type'       => 'SUB',
                            'created_at' => Carbon::now()
                        ],
                        [
                            'code'       => '05',
                            'name'       => 'RIZAL',
                            'type'       => 'SUB',
                            'created_at' => Carbon::now()
                        ],
                    );

        Branch::insert($seed);
    }
}

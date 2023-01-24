<?php

namespace Database\Seeders\Room;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\Room\Room;

class RoomSeeder extends Seeder
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
                            'code'          => 'RVJ101',
                            'name'          => 'RVJ101',
                            'type'          => 'LECTURE',
                            'branch_id'     => 1,
                            'laboratory_id' => null,
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'RVJ102',
                            'name'          => 'RVJ102',
                            'type'          => 'LECTURE',
                            'branch_id'     => 1,
                            'laboratory_id' => null,
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'RVJ103',
                            'name'          => 'RVJ102',
                            'type'          => 'LECTURE',
                            'branch_id'     => 1,
                            'laboratory_id' => null,
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'RVJ104',
                            'name'          => 'RVJ104',
                            'type'          => 'LECTURE',
                            'branch_id'     => 1,
                            'laboratory_id' => null,
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'RVJ105',
                            'name'          => 'RVJ105',
                            'type'          => 'LECTURE',
                            'branch_id'     => 1,
                            'laboratory_id' => null,
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'SPCF GYM',
                            'name'          => 'GYMNASIUM',
                            'type'          => 'LECTURE',
                            'branch_id'     => 1,
                            'laboratory_id' => null,
                            'building_id'   => '3',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'OPENSOURCE',
                            'name'          => 'OPENSOURCE',
                            'type'          => 'LABORATORY',
                            'branch_id'     => 1,
                            'laboratory_id' => '2',
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'ANIM_LAB',
                            'name'          => 'ANIMATION LABORATORY',
                            'type'          => 'LABORATORY',
                            'branch_id'     => 1,
                            'laboratory_id' => '2',
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
                        [
                            'code'          => 'CISCO_LAB',
                            'name'          => 'CISCO LABORATORY',
                            'type'          => 'LABORATORY',
                            'branch_id'     => 1,
                            'laboratory_id' => '2',
                            'building_id'   => '2',
                            'created_at'    => Carbon::now(),
                        ],
        );

        Room::insert($seed);
    }
}

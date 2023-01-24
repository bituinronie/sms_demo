<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// *** Seeder
use Database\Seeders\User\UserSeeder,
    Database\Seeders\Branch\BranchSeeder,
    Database\Seeders\Program\ProgramSeeder,
    Database\Seeders\Strand\StrandSeeder,
    Database\Seeders\Admission\ApplicantSeeder,
    Database\Seeders\Student\StudentAccountSeeder,
    Database\Seeders\Building\BuildingSeeder,
    Database\Seeders\Department\DepartmentSeeder,
    Database\Seeders\Employee\EmployeeSeeder,
    Database\Seeders\Role\RoleSeeder,
    Database\Seeders\Room\RoomSeeder,
    Database\Seeders\Laboratory\LaboratorySeeder,
    Database\Seeders\Subject\SubjectSeeder,
    Database\Seeders\Section\SectionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        if(env('APP_DEBUG'))
        {
            $this->call([
                RoleSeeder::class,
                BranchSeeder::class,
                StrandSeeder::class,
                DepartmentSeeder::class,
                EmployeeSeeder::class,
                ProgramSeeder::class,
                ApplicantSeeder::class,
                BuildingSeeder::class,
                LaboratorySeeder::class,
                RoomSeeder::class,
                SubjectSeeder::class,
                StudentAccountSeeder::class,
                UserSeeder::class,
                SectionSeeder::class
            ]);
        }
    }
}

<?php

namespace Database\Seeders\Student;

use Illuminate\Database\Seeder;

use App\Models\Student\StudentAccount;

class StudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentAccount::factory()
            ->times(5)
            ->create()
            ->each(function ($student){
                $student->assignRole('STUDENT');
            }); 
    }
}

<?php

namespace Database\Seeders\Employee;

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\Employee\Employee;

class EmployeeSeeder extends Seeder
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
                "employee_number"                => '03-26-2021',
                "type"                           => 'NON-TEACHING',
                "last_name"                      => 'SMS',
                "first_name"                     => 'DEVELOPER',
                "middle_name"                    => 'TEAM',
                "gender"                         => 'MALE',
                "age"                            => '21',
                "birth_date"                     => '2000/26/03',
                "birth_place"                    => 'SYSTEMS PLUS COLLEGE FOUNDATION',
                "mobile_number"                  => '90123456789',
                "email_address"                  => 'devteam@gmail.com',
                "civil_status"                   => 'SINGLE',
                "nationality"                    => 'FILIPINO',
                "religion"                       => 'CHRISTIAN',
                "current_address_house_number"   => '2021',
                "current_address_street_name"    => 'BALIBAGO STREET',
                "current_address_barangay"       => 'SPCF',
                "current_address_city"           => 'ANGELES',
                "current_address_province"       => 'PAMPANGA',
                "current_address_zip_code"       => '2019',
                "permanent_address_house_number" => '2019',
                "permanent_address_street_name"  => 'SYSTEMS PLUS',
                "permanent_address_barangay"     => 'PANDAN',
                "permanent_address_city"         => 'ANGELS',
                "permanent_address_province"     => 'PAMPANGA',
                "permanent_address_zip_code"     => '2022',
                "department_id"                  => '1',
                "branch_id"                      => '1',
                "image_id_front"                 => null,
                "image_id_back"                  => null,
                "image_signature"                => null
            ]
            
        );

        Employee::insert($seed);

        Employee::factory()
            ->times(14)
            ->state(new Sequence(
                ["employee_number" => "03-26-0001"],
                ["employee_number" => "03-26-0002"],
                ["employee_number" => "03-26-0003"],
                ["employee_number" => "03-26-0004"],
                ["employee_number" => "03-26-0005"],
                ["employee_number" => "03-26-0006"],
                ["employee_number" => "03-26-0007"],
                ["employee_number" => "03-26-0008"],
                ["employee_number" => "03-26-0009"],
                ["employee_number" => "03-26-0010"],
                ["employee_number" => "03-26-0011"],
                ["employee_number" => "03-26-0012"],
                ["employee_number" => "03-26-0013"],
                ["employee_number" => "03-26-0014"]
            ))
            ->create(); 
    }
}

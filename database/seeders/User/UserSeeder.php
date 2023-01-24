<?php

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;

use Hash, Carbon\Carbon, Role;

use App\Models\User\UserAccount;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = UserAccount::create([
            'employee_id'     => 1,
            'employee_number' => '03-26-2021',
            'password'        => Hash::make('@Dev_2021'),
            'created_at'      => Carbon::now()
        ]);

        $accounting = UserAccount::create([
            'employee_id'     => 2,
            'employee_number' => '03-26-0001',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $admission = UserAccount::create([
            'employee_id'     => 3,
            'employee_number' => '03-26-0002',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $auditor = UserAccount::create([
            'employee_id'     => 4,
            'employee_number' => '03-26-0003',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $basicEducation = UserAccount::create([
            'employee_id'     => 5,
            'employee_number' => '03-26-0004',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $cashier = UserAccount::create([
            'employee_id'     => 6,
            'employee_number' => '03-26-0005',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $dean = UserAccount::create([
            'employee_id'     => 7,
            'employee_number' => '03-26-0006',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $faculty = UserAccount::create([
            'employee_id'     => 8,
            'employee_number' => '03-26-0007',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $foreign = UserAccount::create([
            'employee_id'     => 9,
            'employee_number' => '03-26-0008',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $humanResource = UserAccount::create([
            'employee_id'     => 10,
            'employee_number' => '03-26-0009',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $informationTechnologyService = UserAccount::create([
            'employee_id'     => 11,
            'employee_number' => '03-26-0010',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $programHead = UserAccount::create([
            'employee_id'     => 12,
            'employee_number' => '03-26-0011',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $registrar = UserAccount::create([
            'employee_id'     => 13,
            'employee_number' => '03-26-0012',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $secretary = UserAccount::create([
            'employee_id'     => 14,
            'employee_number' => '03-26-0013',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $scholarship = UserAccount::create([
            'employee_id'     => 15,
            'employee_number' => '03-26-0014',
            'password'        => Hash::make('developer'),
            'created_at'      => Carbon::now()
        ]);

        $adminRole                        = Role::findByName('ADMIN');
        $accountingRole                   = Role::findByName('ACCOUNTING');
        $admissionRole                    = Role::findByName('ADMISSION');
        $auditorRole                      = Role::findByName('AUDITOR');
        $basicEducationRole               = Role::findByName('BASIC EDUCATION');
        $cashierRole                      = Role::findByName('CASHIER');
        $deanRole                         = Role::findByName('DEAN');
        $facultyRole                      = Role::findByName('FACULTY');
        $foreignRole                      = Role::findByName('FOREIGN');
        $humanResourceRole                = Role::findByName('HUMAN RESOURCE');
        $informationTechnologyServiceRole = Role::findByName('INFORMATION TECHNOLOGY SERVICE');
        $programHeadRole                  = Role::findByName('PROGRAM HEAD');
        $registrarRole                    = Role::findByName('REGISTRAR');
        $secretaryRole                    = Role::findByName('SECRETARY');
        $scholarshipRole                  = Role::findByName('SCHOLARSHIP');

        $admin->assignRole($adminRole);
        $accounting->assignRole($accountingRole);
        $admission->assignRole($admissionRole);
        $auditor->assignRole($auditorRole);
        $basicEducation->assignRole($basicEducationRole);
        $cashier->assignRole($cashierRole);
        $dean->assignRole($deanRole);
        $faculty->assignRole($facultyRole);
        $foreign->assignRole($foreignRole);
        $humanResource->assignRole($humanResourceRole);
        $informationTechnologyService->assignRole($informationTechnologyServiceRole);
        $programHead->assignRole($programHeadRole);
        $registrar->assignRole($registrarRole);
        $secretary->assignRole($secretaryRole);
        $scholarship->assignRole($scholarshipRole);
    }
}

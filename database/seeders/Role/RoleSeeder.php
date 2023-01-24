<?php

namespace Database\Seeders\Role;

use Illuminate\Database\Seeder;

use Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $seed = array(
            [
                'name'       => 'ADMIN',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'ACCOUNTING',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'ADMISSION',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'AUDITOR',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'BASIC EDUCATION',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'CASHIER',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'DEAN',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'FACULTY',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'FOREIGN',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'HUMAN RESOURCE',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'INFORMATION TECHNOLOGY SERVICE',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'PROGRAM HEAD',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'REGISTRAR',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'SECRETARY',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'SCHOLARSHIP',
                'guard_name' => 'user'
            ],
            [
                'name'       => 'STUDENT',
                'guard_name' => 'student'
            ],
        );


        Role::insert($seed);
    }
}

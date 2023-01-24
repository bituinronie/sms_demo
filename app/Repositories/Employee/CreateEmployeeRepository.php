<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

use Carbon\Carbon;

use App\Models\Employee\Employee,
    App\Models\ActivityLog\ActivityLog;

class CreateEmployeeRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            // *** Generate employee number
            $employeeNumber = $this->employeeNumber();

            $employee = Employee::create([
                "employee_number"                => $employeeNumber,
                "type"                           => strtoupper($request->type),
                "last_name"                      => strtoupper($request->lastName),
                "first_name"                     => strtoupper($request->firstName),
                "middle_name"                    => strtoupper($request->middleName) ?: null,
                "gender"                         => strtoupper($request->gender),
                "age"                            => Carbon::parse($request->birthDate)->age,
                "birth_date"                     => $request->birthDate,
                "birth_place"                    => strtoupper($request->birthPlace),
                "mobile_number"                  => $request->mobileNumber,
                "email_address"                  => $request->emailAddress,                
                "civil_status"                   => strtoupper($request->civilStatus),
                "nationality"                    => strtoupper($request->nationality),
                "religion"                       => strtoupper($request->religion) ?: null,
                "current_address_house_number"   => strtoupper($request->currentAddressHouseNumber),
                "current_address_street_name"    => strtoupper($request->currentAddressStreetName),
                "current_address_barangay"       => strtoupper($request->currentAddressBarangay),
                "current_address_city"           => strtoupper($request->currentAddressCity),
                "current_address_province"       => strtoupper($request->currentAddressProvince),
                "current_address_zip_code"       => $request->currentAddressZipCode ?? null,
                "permanent_address_house_number" => strtoupper($request->permanentAddressHouseNumber),
                "permanent_address_street_name"  => strtoupper($request->permanentAddressStreetName),
                "permanent_address_barangay"     => strtoupper($request->permanentAddressBarangay),
                "permanent_address_city"         => strtoupper($request->permanentAddressCity),
                "permanent_address_province"     => strtoupper($request->permanentAddressProvince),
                "permanent_address_zip_code"     => $request->permanentAddressZipCode ?? null,
                "department_id"                  => $this->getDepartmentId($request->department),
                "branch_id"                      => $this->getBranchId($request->branch),
                "image_id_front"                 => $request->hasFile('imageIdFront') ? 
                                                    $this->storeFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $request->file('imageIdFront')
                                                    ) : null,
                "image_id_back"                  => $request->hasFile('imageIdBack') ? 
                                                    $this->storeFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $request->file('imageIdBack')
                                                    ) : null,
                "image_signature"                => $request->hasFile('imageSignature') ? 
                                                    $this->storeFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $request->file('imageSignature')
                                                    ) : null
            ]);


            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "HUMAN RESOURCE",
                "message" => "CREATED A EMPLOYEE",
                "data"    => 
                [
                    "new" => [
                        "EMPLOYEE NUMBER" => $employee->employee_number,
                        "FULL NAME"       => "{$employee->last_name}, {$employee->first_name}".($employee->middle_name ? ' '.$employee->middle_name:''),
                        "TYPE"            => $employee->type,
                        "DEPARTMENT"      => $employee->department->name,
                        "BRANCH"          => $employee->branch->name
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a employee");

        }

        return $this->success("Employee Successfuly Created", ["employeeNumber" => $employee->employee_number]);
    }
}
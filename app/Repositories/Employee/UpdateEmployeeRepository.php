<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

use Carbon\Carbon;

use App\Models\Employee\Employee,
App\Models\ActivityLog\ActivityLog;

class UpdateEmployeeRepository extends BaseRepository
{
    public function execute($request, $employeeNumber) {

        // *** Update only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $employee = Employee::where('employee_number', '=', $employeeNumber)->firstOrFail();

            // *** Initialized old data (used for: activity logs)
            $originalEmployee = Employee::find($employee->id);

            $employee->update([
                "employee_number"                => $employee->employee_number,
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
                                                    $this->updateFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $request->file('imageIdFront'),
                                                        $employee->image_id_front
                                                    ) :
                                                    $this->moveUnchangeFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $this->employeeFolder($employeeNumber),
                                                        $employee->imageIdFront
                                                    ),
                "image_id_back"                  => $request->hasFile('imageIdBack') ? 
                                                    $this->updateFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $request->file('imageIdBack'),
                                                        $employee->image_id_back
                                                    ) :
                                                    $this->moveUnchangeFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $this->employeeFolder($employeeNumber),
                                                        $employee->imageIdBack
                                                    ),
                "image_signature"                => $request->hasFile('imageSignature') ? 
                                                    $this->updateFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $request->file('imageSignature'),
                                                        $employee->image_signature
                                                    ) :
                                                    $this->moveUnchangeFile(
                                                        $this->employeeFolder($employeeNumber),
                                                        $this->employeeFolder($employeeNumber),
                                                        $employee->imageSignature
                                                    )
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedEmployee = Employee::find($employee->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "HUMAN RESOURCE",
                "message" => "UPDATED AN EMPLOYEE",
                "causeTo" => [
                    "EMPLOYEE NUMBER" => $employee->employee_number,
                    "FULL NAME"       => "{$employee->last_name}, {$employee->first_name}".($employee->middle_name ? ' '.$employee->middle_name:''),
                    "TYPE"            => $employee->type,
                    "DEPARTMENT"      => $employee->department->name,
                    "BRANCH"          => $employee->branch->name
                ],
                "data"    => $this->activityChangedOnly(
                    $originalEmployee,
                    $updatedEmployee,
                    getForeign: ['department'=>['code','name'], 'branch'=>['code','name']],
                    file      : ['image_id_front', 'image_id_back', 'image_signature'],
                    ignored   : ['department_id', 'branch_id']
                )
            ]);


        } else {

            return $this->error("You're not authorized to update this employee");

        }

        return $this->success("Employee Successfuly Updated", ["employeeNumber" => $employeeNumber]);
    }
}
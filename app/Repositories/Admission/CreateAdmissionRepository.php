<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use Str, Hash, Carbon\Carbon;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\Admission\ApplicantAdmission,
	App\Models\Admission\ApplicantEducationBackground,
	App\Models\Admission\ApplicantRequirement,
	App\Models\Student\StudentAccount;

class CreateAdmissionRepository extends BaseRepository
{
    public function execute($request){

		$personal = ApplicantPersonalInformation::create([
			'last_name'                          => strtoupper($request->lastName),
			'first_name'                         => strtoupper($request->firstName),
			'middle_name'                        => strtoupper($request->middleName) ?: null,
			'gender'                             => strtoupper($request->gender),
			'age'                                => Carbon::parse($request->birthDate)->age,
			'birth_date'                         => $request->birthDate,
			'birth_place'                        => strtoupper($request->birthPlace),
			'telephone_number'                   => $request->telephoneNumber ?? null,
			'mobile_number'                      => $request->mobileNumber,
			'email_address'                      => $request->emailAddress,
			'civil_status'                       => strtoupper($request->civilStatus),
			'nationality'                        => strtoupper($request->nationality),
			'religion'                           => strtoupper($request->religion) ?: null,
			'current_address_house_number'       => strtoupper($request->currentAddressHouseNumber),
			'current_address_street_name'        => strtoupper($request->currentAddressStreetName),
			'current_address_barangay'           => strtoupper($request->currentAddressBarangay),
			'current_address_city'               => strtoupper($request->currentAddressCity),
			'current_address_province'           => strtoupper($request->currentAddressProvince),
			'current_address_zip_code'           => $request->currentAddressZipCode ?? null,
			'permanent_address_house_number'     => strtoupper($request->permanentAddressHouseNumber),
			'permanent_address_street_name'      => strtoupper($request->permanentAddressStreetName),
			'permanent_address_barangay'         => strtoupper($request->permanentAddressBarangay),
			'permanent_address_city'             => strtoupper($request->permanentAddressCity),
			'permanent_address_province'         => strtoupper($request->permanentAddressProvince),
			'permanent_address_zip_code'         => $request->permanentAddressZipCode ?? null,
			'father_full_name'                   => strtoupper($request->fatherFullName) ?: null,
			'father_occupation'                  => strtoupper($request->fatherOccupation) ?: null,
			'father_address'                     => strtoupper($request->fatherAddress) ?: null,
			'father_contact_number'              => $request->fatherContactNumber ?? null,
			'father_email'                       => $request->fatherEmail ?? null,
			'mother_full_name'                   => strtoupper($request->motherFullName) ?: null,
			'mother_occupation'                  => strtoupper($request->motherOccupation) ?: null,
			'mother_address'                     => strtoupper($request->motherAddress) ?: null,
			'mother_contact_number'              => $request->motherContactNumber ?? null,
			'mother_email'                       => $request->motherEmail ?? null,
			'guardian_full_name'                 => strtoupper($request->guardianFullName),
			'guardian_relationship'              => strtoupper($request->guardianRelationship),
			'guardian_occupation'                => strtoupper($request->guardianOccupation) ?: null,
			'guardian_address'                   => strtoupper($request->guardianAddress),
			'guardian_contact_number'            => $request->guardianContactNumber,
			'guardian_email'                     => $request->guardianEmail ?? null,
			'parents_or_guardian_average_income' => strtoupper($request->parentsOrGuardianAverageIncome),
			'other_average_income'               => $request->otherAverageIncome ?? null
		]);

		$priorityNumber = $this->priorityNumber($request->branch, $personal->id);

		$admission = ApplicantAdmission::create([
			'applicant_id'             => $personal->id,
			'priority_number'          => $priorityNumber,
			'applicant_status'         => "PENDING",
			'remark'                   => "YOUR APPLICATION IS CURRENTLY BEING REVIEWED. WAIT FOR FURTHER INSTRUCTION.",
			'student_type'             => strtoupper($request->studentType),
			'method_teaching'          => strtoupper($request->methodTeaching),
			'semester'                 => strtoupper($request->semester) ?: null,
			'branch_id'                => $this->getBranchId($request->branch),
			'learner_reference_number' => $request->learnerReferenceNumber ?? null,
			'education_level'          => strtoupper($request->educationLevel),
			'grade_year_level'         => strtoupper($request->gradeYearLevel) ?: null,
			'strand_id'                => $request->strand ? $this->getStrandId($request->strand) : null,
			'program_id'               => $request->program ? $this->getProgramId($request->program) : null,
			'school_year'              => $request->schoolYear,
			'previous_school_type'     => strtoupper($request->previousSchoolType) ?: null,
			'voucher'                  => $request->hasFile('voucher') ?
											$this->storeFile(
												$this->studentFolder($priorityNumber),
												$request->file('voucher')
											) : null
		]);

		$educationBackground = ApplicantEducationBackground::create([
			'applicant_id'                      => $personal->id,
			'elementary_name'                   => strtoupper($request->elementaryName) ?: null,
			'elementary_address'                => strtoupper($request->elementaryAddress) ?: null,
			'elementary_year_completed'         => $request->elementaryYearCompleted ?? null,
			'junior_high_school_name'           => strtoupper($request->juniorHighSchoolName) ?: null,
			'junior_high_school_address'        => strtoupper($request->juniorHighSchoolAddress) ?: null,
			'junior_high_school_year_completed' => $request->juniorHighSchoolYearCompleted ?? null,
			'senior_high_school_name'           => strtoupper($request->seniorHighSchoolName) ?: null,
			'senior_high_school_strand'         => strtoupper($request->seniorHighSchoolStrand) ?: null,
			'senior_high_school_address'        => strtoupper($request->seniorHighSchoolAddress) ?: null,
			'senior_high_school_year_completed' => $request->seniorHighSchoolYearCompleted ?? null,
			'college_name'                      => strtoupper($request->collegeName) ?: null,
			'college_course'                    => strtoupper($request->collegeCourse) ?: null,
			'college_address'                   => strtoupper($request->collegeAddress) ?: null,
			'college_year_completed'            => $request->collegeYearCompleted ?? null,
			'previous_school'                   => strtoupper($request->collegeName) ?:
													strtoupper($request->seniorHighSchoolName) ?:
													strtoupper($request->juniorHighSchoolName) ?:
													strtoupper($request->elementaryName) ?: "NO PREVIOUS SCHOOL"
		]);


		$requirement = ApplicantRequirement::create([
			'applicant_id'                   => $personal->id,
			'profile_image'                  => $request->hasFile('profileImage') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('profileImage')
												) : null,
			'spcf_cat_result'                => $request->hasFile('spcfCatResult') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('spcfCatResult')
												) : null,

			'certificate_of_moral_character' => $request->hasFile('certificateOfMoralCharacter') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('certificateOfMoralCharacter')
												) : null,

			'nso_birth_certificate'          => $request->hasFile('nsoBirthCertificate') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('nsoBirthCertificate')
												) : null,

			'form_137'                       => $request->hasFile('form137') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('form137')
												) : null,

			'police_clearance'               => $request->hasFile('policeClearance') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('policeClearance')
												) : null,

			'barangay_clearance'             => $request->hasFile('barangayClearance') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('barangayClearance')
												) : null,

			'transfer_credential'           => $request->hasFile('transferCredential') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('transferCredential')
												) : null,

			'special_study_permit'           => $request->hasFile('specialStudyPermit') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('specialStudyPermit')
												) : null,

			'alien_certificate_registration' => $request->hasFile('alienCertificateRegistration') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('alienCertificateRegistration')
												) : null,

			'passport'                       => $request->hasFile('passport') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('passport')
												) : null,

			'visa'                           => $request->hasFile('visa') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('visa')
												) : null,

			'medical_clearance'              => $request->hasFile('medicalClearance') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('medicalClearance')
												) : null,

			'transcript_of_record'           => $request->hasFile('transcriptOfRecord') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('transcriptOfRecord')
												) : null,

			'marriage_certificate'           => $request->hasFile('marriageCertificate') ? 
												$this->storeFile(
													$this->studentFolder($priorityNumber),
													$request->file('marriageCertificate')
												) : null
		]);

		$password = Str::random(8);

		$studentAccount = StudentAccount::create([
			'applicant_id'   => $personal->id,
			'student_number' => $priorityNumber,
			'password'       => Hash::make($password)
		]);

		$this->sendTemporaryAccount(
			$priorityNumber,
			$personal->first_name,
			$password,
			$personal->email_address
		);
		
		return $this->success("Student Successfully Added", ["studentNumber" => $priorityNumber]);
    }
}
<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use Carbon\Carbon, Arr;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\Admission\ApplicantAdmission,
	App\Models\Admission\ApplicantEducationBackground,
	App\Models\Admission\ApplicantRequirement,
	App\Models\ActivityLog\ActivityLog;

class UpdateAdmissionRepository extends BaseRepository
{
    public function execute($request, $oldPriorityNumber){

		$personal = ApplicantPersonalInformation::where("id", "=", $this->getPersonalId($oldPriorityNumber))->firstOrFail();

		// *** Initialized old data (used for: activity logs)
		$originalPersonal    = ApplicantPersonalInformation::find($personal->id);
		$originalAdmission   = ApplicantAdmission::where("applicant_id", "=",  $originalPersonal->id)->firstOrFail();
		$originalEducation   = ApplicantEducationBackground::where("applicant_id", "=",  $originalPersonal->id)->firstOrFail();
		$originalRequirement = ApplicantRequirement::where("applicant_id", "=",  $originalPersonal->id)->firstOrFail();
		
		// *** Update only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $personal->admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
		) {

			$personal->update([
				'last_name'                          => strtoupper($request->lastName),
				'first_name'                         => strtoupper($request->firstName),
				'middle_name'                        => strtoupper($request->middleName) ?: null,
				'gender'                             => strtoupper($request->gender),
				'age'                                => Carbon::parse($request->birthDate)->age,
				'birth_date'                         => $request->birthDate,
				'birth_place'                        => strtoupper($request->birthPlace),
				'telephone_number'                   => $request->telephoneNumber ?? null,
				'mobile_number'                      => $request->mobileNumber,
				'email_address'                      => $request->emailAddress ?? $personal->email_address,
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

			if ($this->getBranchId($request->branch) != $personal->admission->branch_id) {

				$priorityNumber = $this->priorityNumber($request->branch, $personal->id);

			} else {

				$priorityNumber = $personal->admission->priority_number;
			}

			// *** USED FOR: sendApplicantStatus & Admission applicant_status update
			$applicantStatus = $personal->admission->applicant_status;
	
			$personal->admission->update([
				'applicant_id'             => $personal->id,
				'priority_number'          => $priorityNumber,
				'applicant_status'         => strtoupper($request->applicantStatus) ?: $applicantStatus,
				'remark'                   => strtoupper($request->remark) ?: $personal->admission->remark,
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
													$this->updateFile(
													$this->studentFolder($priorityNumber),
													$request->file('voucher'),
													$personal->admission->voucher
												) : 
												$this->moveUnchangeFile(
													$this->studentFolder($priorityNumber),
													$this->studentFolder($oldPriorityNumber),
													$personal->admission->voucher
												)
			]);
	
			$personal->education->update([
				'applicant_id'                      => $personal->id,
				'elementary_name'                   => strtoupper($request->elementaryName) ?: null,
				'elementary_address'                => strtoupper($request->elementaryAddress) ?: null,
				'elementary_year_completed'         => $request->elementaryYearCompleted,
				'junior_high_school_name'           => strtoupper($request->juniorHighSchoolName) ?: null,
				'junior_high_school_address'        => strtoupper($request->juniorHighSchoolAddress) ?: null,
				'junior_high_school_year_completed' => $request->juniorHighSchoolYearCompleted,
				'senior_high_school_name'           => strtoupper($request->seniorHighSchoolName) ?: null,
				'senior_high_school_strand'         => strtoupper($request->seniorHighSchoolStrand) ?: null,
				'senior_high_school_address'        => strtoupper($request->seniorHighSchoolAddress) ?: null,
				'senior_high_school_year_completed' => $request->seniorHighSchoolYearCompleted,
				'college_name'                      => strtoupper($request->collegeName) ?: null,
				'college_course'                    => strtoupper($request->collegeCourse) ?: null,
				'college_address'                   => strtoupper($request->collegeAddress) ?: null,
				'college_year_completed'            => $request->collegeYearCompleted,
				'previous_school'                   => strtoupper($request->collegeName) 			?:
														strtoupper($request->seniorHighSchoolName) 	?:
														strtoupper($request->juniorHighSchoolName) 	?:
														strtoupper($request->elementaryName) 		?:
														null
			]);

			$personal->requirement->update([
				'applicant_id'                   => $personal->id,
				'profile_image'                  => $request->hasFile('profileImage') ?
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('profileImage'),
														$personal->requirement->profile_image
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber),
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->profile_image
													),
				'spcf_cat_result'                => $request->hasFile('spcfCatResult') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('spcfCatResult'),
														$personal->requirement->spcf_cat_result
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber),
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->spcf_cat_result
													),

				'certificate_of_moral_character' => $request->hasFile('certificateOfMoralCharacter') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('certificateOfMoralCharacter'),
														$personal->requirement->certificate_of_moral_character
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber),
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->certificate_of_moral_character
													),

				'nso_birth_certificate'          => $request->hasFile('nsoBirthCertificate') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('nsoBirthCertificate'),
														$personal->requirement->nso_birth_certificate
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber),
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->nso_birth_certificate
													),

				'form_137'                       => $request->hasFile('form137') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('form137'),
														$personal->requirement->form_137
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->form_137
													),

				'police_clearance'               => $request->hasFile('policeClearance') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('policeClearance'),
														$personal->requirement->police_clearance
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->police_clearance
													),

				'barangay_clearance'             => $request->hasFile('barangayClearance') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('barangayClearance'),
														$personal->requirement->barangay_clearance
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->barangay_clearance
													),

				'transfer_credential'           => $request->hasFile('transferCredential') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('transferCredential'),
														$personal->requirement->transfer_credential
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->transfer_credential
													),

				'special_study_permit'           => $request->hasFile('specialStudyPermit') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('specialStudyPermit'),
														$personal->requirement->special_study_permit
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->special_study_permit
													),

				'alien_certificate_registration' => $request->hasFile('alienCertificateRegistration') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('alienCertificateRegistration'),
														$personal->requirement->alien_certificate_registration
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->alien_certificate_registration
													),
													
				'passport'                       => $request->hasFile('passport') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('passport'),
														$personal->requirement->passport
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->passport
													),

				'visa'                           => $request->hasFile('visa') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('visa'),
														$personal->requirement->visa
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->visa
													),

				'medical_clearance'              => $request->hasFile('medicalClearance') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('medicalClearance'),
														$personal->requirement->medical_clearance
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->medical_clearance
													),

				'transcript_of_record'          => $request->hasFile('transcriptOfRecord') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('transcriptOfRecord'),
														$personal->requirement->transcript_of_record
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->transcript_of_record
													),

				'marriage_certificate'           => $request->hasFile('marriageCertificate') ? 
													$this->updateFile(
														$this->studentFolder($priorityNumber),
														$request->file('marriageCertificate'),
														$personal->requirement->marriage_certificate
													) : 
													$this->moveUnchangeFile(
														$this->studentFolder($priorityNumber), 
														$this->studentFolder($oldPriorityNumber),
														$personal->requirement->marriage_certificate
													)
			]);
			
			if($priorityNumber != $oldPriorityNumber) {
				$this->deleteFolder($this->studentFolder($oldPriorityNumber));
			}

			if ($applicantStatus !== strtoupper($request->applicantStatus)) {
				
				$this->sendApplicantStatus(
					$personal->first_name,
					$personal->admission->applicant_status,
					$personal->email_address
				);
			}

			// *** Initialized updated data (used for: activity logs & displaying data)
			$updatedPersonal = ApplicantPersonalInformation::find($personal->id);
			
			$allActivity = [
				$this->activityChangedOnly($originalPersonal, $updatedPersonal),
				$this->activityChangedOnly(
					$originalAdmission, 
					$updatedPersonal->admission, 
					getForeign: [
						'branch'  => ['code', 'name'],
						'strand'  => ['code', 'name'],
						'program' => ['code', 'name']
					],
					file      : ['voucher'],
					ignored   : ['branch_id', 'strand_id', 'program_id', 'remark']
				),
				$this->activityChangedOnly($originalEducation, $updatedPersonal->education),
				$this->activityChangedOnly(
					$originalRequirement, 
					$updatedPersonal->requirement, 
					file: [
						'profile_image',
						'spcf_cat_result',
						'certificate_of_moral_character',
						'nso_birth_certificate',
						'form_137',
						'police_clearance',
						'barangay_clearance',
						'transfer_credential',
						'special_study_permit',
						'alien_certificate_registration',
						'passport',
						'visa',
						'medical_clearance',
						'transcript_of_record',
						'marriage_certificate'
					]
				)
			];

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "UPDATE",
				"module"  => "ADMISSION",
				"message" => "UPDATED AN APPLICANT",
				"causeTo" => [
					"PRIORITY NUMBER" => $updatedPersonal->admission->priority_number,
					"FULL NAME"       => "{$updatedPersonal->last_name}, {$updatedPersonal->first_name}".($updatedPersonal->middle_name ? ' '.$updatedPersonal->middle_name:''),
					"BRANCH"          => $updatedPersonal->admission->branch->name,
				],
				"data"    => [
					'old' => Arr::collapse(Arr::pluck($allActivity, 'old')),
					'new' => Arr::collapse(Arr::pluck($allActivity, 'new'))
				]
			]);

			

		} else {

			return $this->error("You're not authorized to update this student");

		}

		return $this->success("Student Successfully Updated", ["studentNumber" => $updatedPersonal->admission->priority_number]);
	}
}
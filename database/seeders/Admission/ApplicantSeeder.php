<?php

namespace Database\Seeders\Admission;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker, Str, Carbon\Carbon;

use App\Models\Admission\ApplicantPersonalInformation,
    App\Models\Admission\ApplicantAdmission,
    App\Models\Admission\ApplicantEducationBackground,
    App\Models\Admission\ApplicantRequirement,
    App\Models\Program\Program,
    App\Models\Strand\Strand,
    App\Models\Branch\Branch;

class ApplicantSeeder extends Seeder
{
   /**
     * Run the database seeds.
     * Command : php artisan db:seed --class=Database\\Seeders\\Admission\\ApplicantSeeder 
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,15) as $index) {

            //********** ADMISSION **********/
            $applicantStatus    = ['PENDING', 'ACCEPTED', 'ASSIGNED', 'OFFICIAL', 'ARCHIVED', 'DENIED'];
            $studentType        = ['NEW','TRANSFEREE', 'SECOND COURSER', 'OLD'];
            $methodOfTeaching   = ['ONLINE', 'MODULAR', 'MODULAR AND ONLINE'];
            $educationalLevel   = ["PRE-SCHOOL", 'ELEMENTARY', 'JUNIOR HIGH SCHOOL', 'SENIOR HIGH SCHOOL', 'COLLEGE', 'GRADUATE SCHOOL'];
            $semester           = ['FIRST SEMESTER', 'SECOND SEMESTER', 'SUMMER'];
            $previousSchoolType = ['PRIVATE SCHOOL', 'PUBLIC SCHOOL'];
            $yearLevel          = [
                                    "COLLEGE"            => ['FIRST YEAR', 'SECOND YEAR', 'THIRD YEAR', 'FOURTH YEAR', 'FIFTH YEAR'],
                                    "SENIOR HIGH SCHOOL" => ['GRADE ELEVEN', 'GRADE TWELVE'],
                                    "JUNIOR HIGH SCHOOL" => ['GRADE TEN', 'GRADE NINE', 'GRADE EIGHT', 'GRADE SEVEN'],
                                    "ELEMENTARY"         => ['GRADE SIX', 'GRADE FIVE', 'GRADE FOUR', 'GRADE THREE','GRADE TWO', 'GRADE ONE'],
                                    "PRE-SCHOOL"         => ['KINDERGARDEN ONE', 'KINDREGARDEN TWO']
                                ];

            $educationalLevelResult = $faker->randomElement($educationalLevel);

            switch ($educationalLevelResult) {
                case 'PRE-SCHOOL':

                    $yearLevelResult = $faker->randomElement($yearLevel['PRE-SCHOOL']);

                    break;
                case 'ELEMENTARY':

                    $yearLevelResult = $faker->randomElement($yearLevel['ELEMENTARY']);

                    break;
                case 'JUNIOR HIGH SCHOOL':

                    $yearLevelResult = $faker->randomElement($yearLevel['JUNIOR HIGH SCHOOL']);
                    $strandResult    = rand(1, count(Strand::all()));

                    break;
                case 'SENIOR HIGH SCHOOL':

                    $yearLevelResult = $faker->randomElement($yearLevel['SENIOR HIGH SCHOOL']);
                    $strandResult    = rand(1, count(Strand::all()));

                    break;
                case 'COLLEGE':

                    $yearLevelResult = $faker->randomElement($yearLevel['COLLEGE']);
                    $programResult   = rand(1, count(Program::all()));

                    break;
                case 'GRADUATE SCHOOL':

                    $yearLevelResult = $faker->randomElement($yearLevel['COLLEGE']);
                    $programResult   = rand(1, count(Program::all()));

                    break;
            }

            //********** EDUCATION BACKGROUND **********/
            $previousSchool = [
                'ANGELES UNIVERSITY FOUNDATION', 
                'HOLY ANGEL UNIVERSITY', 
                'OUR LADY OF FATIMA UNIVERSITY', 
                'REPUBLIC CENTRAL COLLEGES'
            ];

            //********** PERSONAL **********/
            $gender      = $faker->randomElement(["MALE", "FEMALE"]);
            $civilStatus = ['SINGLE', 'MARRIED', 'DIVORCED', 'SEPARATED', 'WIDOWED'];
            $nationality = ["FILIPINO", "KOREAN", "JAPANESE"];
            $religion    = ["ROMAN CATHOLIC", "INC", "CHRISTIAN"];
            $income      = [
                            "10,000 AND BELOW", 
                            "MORE THAN 10,000 TO 20,000", 
                            "MORE THAN 20,000 TO 30,000", 
                            "MORE THAN 30,000 TO 40,000", 
                            "MORE THAN 50,000", 
                            "NOT SPECIFIED"
                        ];
            $birthDate   = $faker->date('Y-m-d', '-5 years');
            $age         = date_diff(date_create($birthDate), date_create('now'))->y;


            ApplicantPersonalInformation::insert([
                "last_name"                          => Str::upper($faker->lastName),
                "first_name"                         => Str::upper($faker->firstName($gender)),
                "middle_name"                        => Str::upper($faker->lastName),
                "gender"                             => $gender,
                "age"                                => $age,
                "birth_date"                         => $birthDate,
                "birth_place"                        => Str::upper($faker->city),
                "telephone_number"                   => $faker->phoneNumber,
                'mobile_number'                      => $faker->numberBetween(1000000000, 9999999999),
                'email_address'                      => $faker->unique()->email,
                'civil_status'                       => $faker->randomElement($civilStatus),
                'nationality'                        => $faker->randomElement($nationality),
                'religion'                           => $faker->randomElement($religion),
                'current_address_house_number'       => $faker->randomNumber(5),
                'current_address_street_name'        => Str::upper($faker->streetName),
                'current_address_barangay'           => Str::upper($faker->city),
                'current_address_city'               => Str::upper($faker->city),
                'current_address_zip_code'           => $faker->numberBetween(1000, 9999),
                'current_address_province'           => Str::upper($faker->state),
                'permanent_address_house_number'     => $faker->randomNumber(5),
                'permanent_address_street_name'      => Str::upper($faker->streetName),
                'permanent_address_barangay'         => Str::upper($faker->city),
                'permanent_address_city'             => Str::upper($faker->city),
                'permanent_address_zip_code'         => $faker->numberBetween(1000, 9999),
                'permanent_address_province'         => Str::upper($faker->state),
                'father_full_name'                   => Str::upper($faker->name('male')),
                'father_occupation'                  => Str::upper($faker->jobTitle),
                'father_address'                     => Str::upper($faker->address()),
                'father_email'                       => $faker->email,
                'father_contact_number'              => $faker->numberBetween(1000000000, 9999999999),
                'mother_full_name'                   => Str::upper($faker->name('female')),
                'mother_occupation'                  => Str::upper($faker->jobTitle),
                'mother_address'                     => Str::upper($faker->address()),
                'mother_email'                       => $faker->email,
                'mother_contact_number'              => $faker->numberBetween(1000000000, 9999999999),
                'guardian_full_name'                 => Str::upper($faker->name()),
                'guardian_occupation'                => Str::upper($faker->jobTitle),
                'guardian_address'                   => Str::upper($faker->address),
                'guardian_email'                     => $faker->email,
                'guardian_contact_number'            => $faker->numberBetween(1000000000, 9999999999),
                'guardian_relationship'              => 'RELATIVE',
                'parents_or_guardian_average_income' => $faker->randomElement($income),
                'other_average_income'               => $faker->randomElement($income),
                'created_at'                         => Carbon::now()
            ]);

            ApplicantAdmission::insert([
                'applicant_id'             => $index,
                'priority_number'          => $faker->unique()->numberBetween(1021000000, 1022999999),
                'student_type'             => $faker->randomElement($studentType),
                'method_teaching'          => $faker->randomElement($methodOfTeaching),
                'applicant_status'         => 'PENDING',
                'learner_reference_number' => $faker->numberBetween(1000000000, 9999999999),
                'remark'                   => 'YOUR APPLICATION IS CURRENTLY BEING REVIEWED. WAIT FOR FURTHER INSTRUCTION.',
                'education_level'          => $educationalLevelResult,
                'grade_year_level'         => $yearLevelResult,
                'program_id'               => $programResult ?? null,
                'strand_id'                => $strandResult ?? null,
                'branch_id'                => rand(1, count(Branch::all())),
                'semester'                 => $faker->randomElement($semester),
                'school_year'              => '2020-2021',
                'voucher'                  => null,
                'previous_school_type'     => $faker->randomElement($previousSchoolType),
            ]);

            ApplicantEducationBackground::insert([
                'applicant_id'                      => $index,
                'elementary_name'                   => Str::upper($faker->sentence),
                'elementary_address'                => Str::upper($faker->streetAddress),
                'elementary_year_completed'         => '2011-2012',
                'junior_high_school_name'           => Str::upper($faker->sentence),
                'junior_high_school_address'        => Str::upper($faker->streetAddress),
                'junior_high_school_year_completed' => '2015-2016',
                'senior_high_school_name'           => Str::upper($faker->sentence),
                'senior_high_school_address'        => Str::upper($faker->streetAddress),
                'senior_high_school_year_completed' => '2017-2018',
                'college_name'                      => Str::slug($faker->sentence),
                'college_address'                   => Str::slug($faker->streetAddress),
                'college_year_completed'            => '2019-2020',
                'previous_school'                   => $faker->randomElement($previousSchool),
            ]);

            ApplicantRequirement::insert([
                'applicant_id'                   => $index,
                'spcf_cat_result'                => null,
                'profile_image'                  => $faker->sentence(),
                'certificate_of_moral_character' => null,
                'nso_birth_certificate'          => null,
                'form_137'                       => null,
                'police_clearance'               => null,
                'barangay_clearance'             => null,
                'transfer_credential'            => null,
                'special_study_permit'           => null,
                'alien_certificate_registration' => null,
                'passport'                       => null,
                'visa'                           => null,
                'medical_clearance'              => null,
                'transcript_of_record'           => null,
                'marriage_certificate'           => null,
            ]);
        }
    }
}

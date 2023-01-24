<?php

namespace Database\Factories\Student;

use Illuminate\Database\Eloquent\Factories\Factory;
use Hash;
use App\Models\Student\StudentAccount;
use App\Models\Admission\ApplicantPersonalInformation;

class StudentAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $id = $this->faker->unique()->numberBetween(1, 15);

        $personal = ApplicantPersonalInformation::findOrFail($id);

        return [
            'applicant_id'   => $id,
            'student_number' => $personal->admission->priority_number,
            'password'       => Hash::make('developer')
        ];
    }
}

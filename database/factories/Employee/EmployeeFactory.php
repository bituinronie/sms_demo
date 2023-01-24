<?php

namespace Database\Factories\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;
use App\Models\Employee\Employee;
use App\Models\Branch\Branch;
use App\Models\Department\Department;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $type        = ['TEACHING', 'NON-TEACHING', 'DEAN'];
        $gender      = $this->faker->randomElement(["MALE", "FEMALE"]);
        $civilStatus = ['SINGLE', 'MARRIED', 'DIVORCED', 'SEPARATED', 'WIDOWED'];
        $nationality = ["FILIPINO", "KOREAN", "JAPANESE", "AMERICAN", "RUSSIAN"];
        $religion    = ["ROMAN CATHOLIC", "INC", "CHRISTIAN"];

        $birthDate = $this->faker->date('Y-m-d', '-5 years');
        $age       = date_diff(date_create($birthDate), date_create('now'))->y;

        return [
            "type"                           => $this->faker->randomElement($type),
            "last_name"                      => Str::upper($this->faker->lastName),
            "first_name"                     => Str::upper($this->faker->firstName($gender)),
            "middle_name"                    => Str::upper($this->faker->lastName),
            "gender"                         => $gender,
            "age"                            => $age,
            "birth_date"                     => $birthDate,
            "birth_place"                    => Str::upper($this->faker->city),
            "mobile_number"                  => $this->faker->numberBetween(1000000000, 9999999999),
            "email_address"                  => $this->faker->unique()->email,
            "civil_status"                   => $this->faker->randomElement($civilStatus),
            "nationality"                    => $this->faker->randomElement($nationality),
            "religion"                       => $this->faker->randomElement($religion),
            "current_address_house_number"   => $this->faker->randomNumber(5),
            "current_address_street_name"    => Str::upper($this->faker->streetName),
            "current_address_barangay"       => Str::upper($this->faker->city),
            "current_address_city"           => Str::upper($this->faker->city),
            "current_address_province"       => Str::upper($this->faker->state),
            "current_address_zip_code"       => $this->faker->numberBetween(1000, 9999),
            "permanent_address_house_number" => $this->faker->randomNumber(5),
            "permanent_address_street_name"  => Str::upper($this->faker->streetName),
            "permanent_address_barangay"     => Str::upper($this->faker->city),
            "permanent_address_city"         => Str::upper($this->faker->city),
            "permanent_address_province"     => Str::upper($this->faker->state),
            "permanent_address_zip_code"     => $this->faker->numberBetween(1000, 9999),
            "department_id"                  => rand(1, count(Department::all())),
            "branch_id"                      => rand(1, count(Branch::all())),
            "image_id_front"                 => null,
            "image_id_back"                  => null,
            "image_signature"                => null
        ];
    }
}

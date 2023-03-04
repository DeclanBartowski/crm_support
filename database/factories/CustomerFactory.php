<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->company(),
            'e_address'=>$this->faker->url(),
            'contact_person_name'=>$this->faker->name(),
            'contact_person_position'=>$this->faker->jobTitle(),
            'contact_person_phone'=>$this->faker->phoneNumber(),
            'contact_person_phone_work'=>$this->faker->phoneNumber(),
            'contact_person_email'=>$this->faker->email(),

        ];
    }
}

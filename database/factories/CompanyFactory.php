<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class CompanyFactory extends Factory
{
    //protected $model=Company::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->company,
            'address'=>$this->faker->address,
            'phone'=>$this->faker->e164PhoneNumber,
        ];
    }
}

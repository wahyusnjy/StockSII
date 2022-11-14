<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama'      => $this->faker->sentence(),
            'alamat'    => $this->faker->text(),
            'email'     => $this->faker->email(),
            'telepon'   => $this->faker->phoneNumber()
        ];
    }
}

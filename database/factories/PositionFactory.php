<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = "App\Models\Position";

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            "title" => $this->faker->randomElement(["php developer", "ui/ux designer", "translator", "sales manager", "marketing manager"]),
            "category" => $this->faker->randomElement(["it", "designer", "accounting", "health care", "laboratory", "lawyer", "social service", "security service"]),
            "min_age" => 18,
            "max_age" => 40,
            "education" => $this->faker->randomElement(["BSc", "MD", "PhD", "diploma"]),
            "gender" => $this->faker->randomElement(["male", "female"]),
            "salary" => $this->faker->numberBetween(1000000, 3000000),
            "location" => $this->faker->city(),
            "created_at" => $this->faker->dateTime,
            "expired_at" => $this->faker->dateTime,
            "lived_at" => $this->faker->dateTime,
        ];
        return $data;

    }
}

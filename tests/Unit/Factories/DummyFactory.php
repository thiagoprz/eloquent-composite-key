<?php

namespace Thiagoprz\CompositeKey\Tests\Unit\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Thiagoprz\CompositeKey\Unit\Models\Dummy;

class DummyFactory extends Factory
{
    protected $model = Dummy::class;

    public function definition()
    {
        return [
            'key_1' => $this->faker->numberBetween(1, 9999999),
            'key_2' => $this->faker->numberBetween(1, 9999999),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->city(),
        ];
    }

}
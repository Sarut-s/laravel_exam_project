<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'THB' =>    $this->faker->numberBetween(10,600),
            'USD' =>    $this->faker->numberBetween(10,600),
            'BTC' =>    $this->faker->numberBetween(10,600),
            'ETH' =>    $this->faker->numberBetween(10,600),
            'XRP' =>    $this->faker->numberBetween(10,600),
            'DOGE' =>   $this->faker->numberBetween(10,600),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::inRandomOrder()->first()->id;
        $wallet_id = Wallet::getWallet($user_id);
        
       
        
        return [

            'user_id' =>  $user_id,
            'user_wallet_id' =>  $wallet_id->id,
            'payment_fiat' => $this->faker->randomElement(['THB','USD']),
            'asset' =>   $this->faker->randomElement(['BTC','ETH','XRP','DOGE']),
            'amount' =>  $this->faker->numberBetween(1,30),
            'price' =>   $this->faker->numberBetween(20,200),
            'status' => $this->faker->randomElement(['buy','sell']),
        ];
    }
}

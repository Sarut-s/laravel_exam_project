<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $test = new User ([ 
            'username' => 'test',
            'password' => bcrypt('1234'),
        ]);
        $test->save();
        $test->wallet()->save(Wallet::factory()->make());

        $user = User::factory(10)->create();
        $user->each(function ($u) {
     
            $u->wallet()->save(Wallet::factory()->make());
        });
    }
}

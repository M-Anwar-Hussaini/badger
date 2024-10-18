<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * @var User $user
         */
        $user = User::create([
            'name' => 'Hamid Tabish',
            'email' => 'hamid@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user->createToken('Hamid Tabish')->plainTextToken;
        User::factory(5)->create();

    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'strahinjalalic10@gmail.com')->first();

        if(!$user) {
            User::create([
                'name' => 'Strahinja Lalic',
                'password' => Hash::make('password'),
                'email' => 'strahinjalalic10@gmail.com',
                'role' => 'admin',
            ]);
        }

    }
}

<?php

use Illuminate\Database\Seeder;
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
        factory(App\User::class, 10)->create()->each(function ($user) {
            $userName = explode(' ', $user->name, 2);

            $user->userInfo()->create([
                'first_name' => $userName[0],
                'last_name'  => $userName[1],
            ]);
        });
    }
}

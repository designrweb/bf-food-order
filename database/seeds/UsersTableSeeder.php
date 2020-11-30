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
        $faker = \Faker\Factory::create();

        factory(App\User::class, 10)->create()->each(function ($user) use ($faker) {
            $user->userInfo()->create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
            ]);
        });
    }
}

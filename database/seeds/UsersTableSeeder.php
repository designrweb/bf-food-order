<?php

use App\User;
use Illuminate\Database\Seeder;

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

        factory(App\User::class, 1)->create()->each(function ($user) use ($faker) {
            $user->userInfo()->create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'salutation' => User::SALUTATION_MR,
                'zip'        => $faker->postcode,
                'city'       => $faker->city,
                'street'     => $faker->address,
            ]);
        });
    }
}

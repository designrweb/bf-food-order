<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        factory(App\User::class, 1)->create([
            'role'     => User::ROLE_SUPER_ADMIN,
            'email'    => 'admin@super.com',
            'password' => Hash::make('@9gyBG@LPzjG'),
        ])->each(function ($user) use ($faker) {
            $user->userInfo()->create([
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'salutation' => User::SALUTATION_MR,
                'zip'        => $faker->postcode,
                'city'       => $faker->city,
                'street'     => $faker->address,
            ]);
        });
    }
}

<?php

use App\User;
use Illuminate\Database\Seeder;

class ConsumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        factory(App\Consumer::class, 5)->create()->each(function ($consumer) use ($faker) {
            $consumer->user->userInfo()->create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'salutation' => User::SALUTATION_MR,
                'zip'        => $faker->postcode,
                'city'       => $faker->city,
                'street'     => $faker->address,
            ]);
        });;
    }
}

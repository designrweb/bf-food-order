<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $company = factory(App\Company::class)->create();

        factory(App\Location::class)->create([
            'company_id' => $company->id,
        ]);

        factory(App\User::class)->create([
            'company_id' => $company->id,
            'email'      => 'admin@admin.com',
        ])->each(function ($user) use ($faker) {
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

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
        $users = factory(App\User::class, 1)->make()->toArray();

        foreach ($users as $user) {
            $userModel           = new App\User($user);
            $userModel->password = Hash::make('admin');
            $userModel->save();
        }
    }
}

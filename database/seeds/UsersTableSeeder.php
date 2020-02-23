<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_short_url = env('APP_URL_SHORT');

        $super = User::create([
            'first_name' => 'test',
            'last_name' => 'super',
            'username' => 'test_super',
            'email' => "test_super@{$app_short_url}",
            'password' => Hash::make('password'),
        ]);
        $super->roles()->attach(Role::where('name','super')->first());

        $admin = User::create([
            'first_name' => 'test',
            'last_name' => 'admin',
            'username' => 'test_admin',
            'email' => "test_admin@{$app_short_url}",
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach(Role::where('name','admin')->first());
    }
}

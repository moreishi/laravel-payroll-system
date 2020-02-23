<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'super',
            'description' => 'An super account',
            'slug' => Str::slug('super')
        ]);

        Role::create([
            'name' => 'admin',
            'description' => 'An admin account',
            'slug' => Str::slug('admin')
        ]);

        Role::create([
            'name' => 'employee',
            'description' => 'An employee account',
            'slug' => Str::slug('employee')
        ]);
    }
}

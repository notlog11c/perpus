<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat Role Admin
        $roleAdmin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
        ]);

        // Membuat Role Member
        $roleMember = Role::create([
            'name' => 'member',
            'display_name' => 'Member',
        ]);

        // Contoh User dengan Role Admin
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123123'),
        ]);

        $adminUser->attachRole($roleAdmin);

        // Contoh User dengan Role Member
        $memberUser = User::create([
            'name' => 'Member',
            'email' => 'Member@mail.com',
            'password' => bcrypt('321321'),
        ]);

        $adminUser->attachRole($roleMember);
    }
}

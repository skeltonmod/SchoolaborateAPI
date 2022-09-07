<?php

namespace Database\Seeders;

use Deyji\Manage\Models\Privilege\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the database with roles
        Role::create([
            'name'=>"Student",
            'guard_name'=>"api"
        ]);

        Role::create([
            'name'=>"Facilitator",
            'guard_name'=>"api"
        ]);

        Role::create([
            'name'=>"Admin",
            'guard_name'=>"api"
        ]);
    }
}

<?php

namespace Deyji\Manage\Database\Seeders;

use Illuminate\Database\Seeder;
use Deyji\Manage\Models\Privilege\Role;

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
            'name'=>"Staff",
            'guard_name'=>"api"
        ]);

        Role::create([
            'name'=>"Admin",
            'guard_name'=>"api"
        ]);
    }
}

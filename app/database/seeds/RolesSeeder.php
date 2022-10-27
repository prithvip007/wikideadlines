<?php

namespace Seeds;

use Illuminate\Database\Seeder;
use \App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'admin',
            'description' => 'admin'
        ]);

        Role::create([
            'name' => 'owner',
            'display_name' => 'owner',
            'description' => 'owner'
        ]);
    }
}

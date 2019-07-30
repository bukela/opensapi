<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_admin = new Role();
        $role_admin->id = 1;
        $role_admin->name = 'Admin';
        $role_admin->code = 'admin';
        $role_admin->save();
        
        $role_donator = new Role();
        $role_donator->id = 2;
        $role_donator->name = 'Donator';
        $role_donator->code = 'donator';
        $role_donator->save();
    
        $role_organization = new Role();
        $role_organization->id = 3;
        $role_organization->name = 'Organization';
        $role_organization->code = 'organization';
        $role_organization->save();

        $role_user = new Role();
        $role_user->id = 4;
        $role_user->name = 'User';
        $role_user->code = 'user';
        $role_user->save();
    
    }
}

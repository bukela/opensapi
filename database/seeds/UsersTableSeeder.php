<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
    
        $adminUser = new User();
        $adminUser->name = 'Admin Istrator';
        $adminUser->role_id = $adminRole->id;
        $adminUser->email = 'admin@domain.com';
        $adminUser->password = bcrypt('secret');
        $adminUser->save();
        
        
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => '1',
        ]);
    }
}

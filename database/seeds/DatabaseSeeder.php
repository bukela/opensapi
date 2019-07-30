<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        $this->call(RolesTableSeeder::class);       
        $this->call(UsersTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        factory(App\User::class, 20)->create();
        factory(App\Event::class, 20)->create();
        factory(App\News::class, 20)->create();
        // factory(App\Organization::class, 20)->create();
        // factory(App\Project::class, 20)->create();
        // $this->call(CategoryProjectTableSeeder::class);
    }
}

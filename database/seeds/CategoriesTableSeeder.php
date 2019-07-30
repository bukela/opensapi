<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $cost_type_1 = new Category();
        // $cost_type_1->name = 'Direktni troškovi';
        // $cost_type_1->parent_id = 0;
        // $cost_type_1->save();
    
        // $cost_type_2 = new Category();
        // $cost_type_2->name = 'Indirektni troškovi';
        // $cost_type_2->parent_id = 0;
        // $cost_type_2->save();
    
        $cost_type_3 = new Category();
        $cost_type_3->name = 'Troškovi članova projektnog tima';
        // $cost_type_3->parent_id = 1;
        $cost_type_3->save();

        $cost_type_4 = new Category();
        $cost_type_4->name = 'Troškovi transporta';
        // $cost_type_4->parent_id = 1;
        $cost_type_4->save();
        
        $cost_type_5 = new Category();
        $cost_type_5->name = 'Troškovi materijala';
        // $cost_type_5->parent_id = 1;
        $cost_type_5->save();
        
        $cost_type_6 = new Category();
        $cost_type_6->name = 'Ostali troškovi';
        // $cost_type_6->parent_id = 1;
        $cost_type_6->save();

        $cost_type_7 = new Category();
        $cost_type_7->name = 'Administrativni troškovi';
        // $cost_type_7->parent_id = 2;
        $cost_type_7->save();        
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page_privacy = new Page();
        $page_privacy->title = 'Privacy Policy';
        $page_privacy->slug = 'Privacy Policy';
        $page_privacy->save();
    
        $page_terms = new Page();
        $page_terms->title = 'Terms of Use';
        $page_terms->slug = 'Terms of Use';
        $page_terms->save();
    
        $page_funeral = new Page();
        $page_funeral->title = 'List Your Funeral Home';
        $page_funeral->slug = 'List Your Funeral Home';
        $page_funeral->save();
    
        $page_how_help = new Page();
        $page_how_help->title = 'How We Help';
        $page_how_help->slug = 'How We Help';
        $page_how_help->save();
    
        $page_help = new Page();
        $page_help->title = 'Help';
        $page_help->slug = 'Help';
        $page_help->save();
    
        $page_checklist = new Page();
        $page_checklist->title = 'Checklist';
        $page_checklist->slug = 'Checklist';
        $page_checklist->save();
    }
}

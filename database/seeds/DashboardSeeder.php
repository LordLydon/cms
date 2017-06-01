<?php

use App\Page;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dash = Page::create([
            'name' => 'Inicio', 
            'content' => '<h1>Bienvenido al CMS!</h1>', 
            'is_private' => false, 
            'position' => 'none', 
            'user_id' => 1
            ]);
    }
}

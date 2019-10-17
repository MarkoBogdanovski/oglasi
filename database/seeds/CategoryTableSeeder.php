<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    private $categories = ["Audi", "Alfa Romeo", "BMW", "Cadillac", "Ford", "Mercedes Benz", "Lexus", "Volkswagen"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        foreach($this->categories as $category) {
            Category::create([
                            'id' => $i,
                            'name' => str_replace(" ", "-", strtolower($category)),
                            'display_name' => $category,
                            'created_at' => now()
            ]);
            $i++;
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Ads;
use App\Models\Category;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        foreach($categories as $category) {
            if($category->name == 'audi') { continue; } 
            factory(Ads::class, 15)->create([
                'category' => $category->id
            ])->each(function ($ad) {
                return true;
            });
        }
    }
}
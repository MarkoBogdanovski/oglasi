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
        $categories = Category::all()->pluck('id');
        foreach($categories as $key => $value) {
            factory(Ads::class, 50)->create([
                'category' => $value
            ])->each(function ($ad) {
                return true;
            });
        }
        
    }
}
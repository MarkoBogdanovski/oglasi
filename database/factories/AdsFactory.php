<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ads;
use Faker\Generator as Faker;

$factory->define(Ads::class, function (Faker $faker) {
    return [
    	'owner_id' => 1,
    	'approved' => false,
    	'category' => 6,
    	'name' => $faker->catchPhrase,
    	'price' => $faker->randomNumber(4),
    	'year' => $faker->randomNumber(4),
    	'range' => $faker->randomNumber(4),
    	'image' => '1570726842.jpeg'
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ads;
use App\Models\User;
use App\Models\Roles;
use Faker\Generator as Faker;

$factory->define(Ads::class, function (Faker $faker, $params) {
    return [
    	'owner_id' => User::where('role_id', Roles::where('name', 'member')->first()->id)->inRandomOrder()->take(1)->first()->id,
    	'approved' => $faker->boolean(75),
    	'category' => $params['category'],
    	'name' => $faker->catchPhrase,
    	'price' => $faker->randomNumber(4),
    	'year' => $faker->randomNumber(4),
    	'range' => $faker->randomNumber(4),
        'created_at' => now(),
    	'image' => 'https://lorempixel.com/800/600/?'.time()
    ];
});

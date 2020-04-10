<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'description'=>$faker->sentence,
        'price'=>$faker->randomFloat(2),
        'discount_user_visible'=>$faker->randomNumber(2)
    ];
});

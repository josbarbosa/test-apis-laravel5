<?php

use App\Tag;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Tag Factory
|--------------------------------------------------------------------------
|
*/

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

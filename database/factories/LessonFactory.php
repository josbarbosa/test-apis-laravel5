<?php

use App\Lesson;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Lesson Factory
|--------------------------------------------------------------------------
*/

$factory->define(Lesson::class, function (Faker $faker) {

    return [
        'title'  => $faker->sentence(2),
        'body'   => $faker->paragraph(4),
        'active' => $faker->boolean,
    ];
});

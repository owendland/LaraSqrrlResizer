<?php

use Faker\Generator as Faker;

$factory->define(
    App\Image::class,
    function (Faker $faker) {
        return [
            'source_url' => "http://squirrelworld.com/{$faker->word}.jpg",
            'name'       => $faker->name,
        ];
    }
);

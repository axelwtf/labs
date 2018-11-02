<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name'=>$faker->sentence(1,3),
        'valid'=>null,
        'content'=>$faker->realText(100),
        'image'=>$faker->imageUrl($width=360, $height=260)
    ];
});
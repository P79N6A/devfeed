<?php

use Faker\Factory as Faker;

$factory->define(Fedn\Models\Team::class, function () {
    $faker = Faker::create('zh_CN');

    return [
        'title'       => $faker->company,
        'description' => $faker->paragraphs(3, true),
        'logo'        => $faker->imageUrl(200, 200, 'business', true),
        'website'     => $faker->url,
        'likes'       => $faker->numberBetween(0, 2349024)
    ];
});

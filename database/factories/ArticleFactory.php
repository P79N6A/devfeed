<?php

use Faker\Factory as Faker;

$factory->define(Fedn\Models\Article::class, function () {
    $faker = Faker::create('zh_CN');

    return [
        'user_id'     => function () {
            return factory('Fedn\Models\User')->create()->id;
        },
        'title'       => $faker->sentence,
        'source_url'  => $faker->url,
        'figure'      => $faker->imageUrl(200, 200),
        'summary'     => $faker->paragraph,
        'author'      => $faker->name,
        'author_url'  => $faker->url,
        'content'     => $faker->text(5000),
        'click_count' => $faker->randomNumber(0),
        'status'      => 'publish',
        'likes'       => 0,
        'dislikes'    => 0
    ];
});

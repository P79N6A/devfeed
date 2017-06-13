<?php
use Faker\Factory as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Fedn\Models\User::class, function () {
    $faker = Faker::create('zh_CN');
    static $password;

    return [
        'name' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'nickname' => $faker->name,
    ];
});

$factory->define(Fedn\Models\Team::class, function () {
    $faker = Faker::create('zh_CN');
    return [
        'title' => $faker->company,
        'description' => $faker->paragraphs(3, true),
        'logo' => $faker->imageUrl(200, 200, 'business', true),
        'website' => $faker->url,
        'likes' => $faker->numberBetween(0, 2349024)
    ];
});

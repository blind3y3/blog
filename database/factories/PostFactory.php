<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    //$faker = \Faker\Factory::create('ru_RU');
    $title = $faker->realText(rand(10, 40));
    $description = $faker->realText(rand(100, 500));
    $shortTitle = mb_strlen($title) > 30 ? mb_substr($title, 0, 30) . '...' : $title;
    $created = $faker->dateTimeBetween('-30 days', '-1 days');

    return [
        'title' => $title,
        'short_title' => $shortTitle,
        'description' => $description,
        'author_id' => rand(1, 4), //т.к. предварительно создадим 4 пользователей
        'created_at' => $created,
        'updated_at' => $created,
    ];
});

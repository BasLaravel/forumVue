<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true
    ];
});

$factory->state(App\User::class, 'unconfirmed', function (){
    return [
        'confirmed' => 'false'
    ];
});


$factory->state(App\User::class, 'administrator', function (){
        return [
            'name' => 'Bas'
        ];
});


$factory->define(App\Thread::class, function (Faker $faker) {
    $title= $faker->sentence;
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'channel_id' =>function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => str_slug($title),
        'locked' => false
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {
    $name= $faker->word;
    return [
     
        'name' => $name,
        'slug' => $name
    ];
});


$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'thread_id' => function(){
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});


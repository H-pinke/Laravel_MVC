<?php

$app['router']->get('/', function () {
    return '<h1>hello world laravel</h1>';
});

$app['router']->get('welcome', 'App\Http\Controllers\WelcomeController@index');
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['namespace' => 'Admin', 'prefix' => 'admin'], function () use ($router) {
    $router->get('cv-parser', 'CVParserController@view');

    $router->post('cv-parser', [
        'as' => 'cv.parse', 'uses' => 'CVParserController@parse'
    ]);

    $router->get('home', 'HomeController@view');
    $router->get('login', 'AuthController@login');
});


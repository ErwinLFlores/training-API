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

$router->post('/auth/getToken', 'AuthController@getToken');


// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/user/all', 'UserController@getAllUser');
    $router->post('/user/getUserId', 'UserController@getUserById');
    $router->post('/user/save', 'UserController@saveUser');
    $router->post('/user/delete', 'UserController@deleteUser');
    $router->post('/user/update', 'UserController@updateUser');
});





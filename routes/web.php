<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->group(['middleware' => 'cors'], function ($router) {

    
     $router->get('/products', 'ProductController@index');
     $router->get('/category', 'CategoryController@index');
     
     $router->post('/login', 'AuthController@login');
     $router->get('/logout', 'AuthController@logout');
     $router->get('/profile', 'AuthController@me');
     
     });



$router->group(['prefix' => 'product'], function() use ($router)
{
     // statis method
     $router->get('/data', 'ProductController@index');
     $router->post('/', 'ProductController@store');
     
     
     //  // dinamis method
     
     $router->get('/{id}', 'ProductController@show');
     $router->patch('/{id}', 'ProductController@update');
     $router->delete('/{id}', 'ProductController@destroy');
    //  $router->get('/trash', 'ProductController@trash');
     $router->get('/restore/{id}', 'ProductController@restore');
     $router ->delete('/permanent/{id}', 'ProductController@deletePermanent');

});

$router->group(['prefix' => 'category'], function() use ($router)
{
     // statis method
     $router->get('/data', 'CategoryController@index');
     $router->post('/', 'CategoryController@store');
     
     
     //  // dinamis method
     
     $router->get('/{id}', 'CategoryController@show');
     $router->patch('/{id}', 'CategoryController@update');
     $router->delete('/{id}', 'CategoryController@destroy');
    //  $router->get('/trash', 'CategoryController@trash');
     $router->get('/restore/{id}', 'CategoryController@restore');
     $router ->delete('/permanent/{id}', 'CategoryController@deletePermanent');

});

$router->group(['prefix' => 'user/'], function() use ($router)
{
     // statis method
     $router->get('/data', 'UserController@index');
     $router->post('/', 'UserController@store');

 
     // dinamis method
     $router->get('{id}', 'UserController@show');
     $router->patch('/{id}', 'UserController@update');
     $router->delete('/{id}', 'UserController@destroy');

});


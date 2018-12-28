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

$router->group(['middleware' => 'auth', 'prefix' => 'v1'], function () use ($router) {
    $router->get('products',  ['uses' => 'ProductController@getAllProducts', 'as' => 'get_all_products']);
    $router->get('products/{id}',  ['uses' => 'ProductController@getProductById', 'as' => 'get_products_by_id']);
    $router->post('products',  ['uses' => 'ProductController@create', 'as' => 'create_products']);
    $router->patch('products/{id}',  ['uses' => 'ProductController@update', 'as' => 'update_products']);
    $router->delete('products/{id}',  ['uses' => 'ProductController@delete', 'as' => 'delete_products']);
});
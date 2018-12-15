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
    $url = route('get_product_by_id');
    return $url;
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('products',  ['uses' => 'ProductController@getAllProducts', 'as' => 'get_all_products']);
    $router->get('product/{id}',  ['uses' => 'ProductController@getProductById', 'as' => 'get_product_by_id']);
});
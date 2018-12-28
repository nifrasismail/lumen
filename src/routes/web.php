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
    $router->get(
        'products',
        [
            'uses' => 'ProductController@getAllProducts',
            'as' => 'products'
        ]
    );
    $router->get(
        'products/{id}',
        [
            'uses' => 'ProductController@getProductById',
            'as' => 'products.by.id'
        ]
    );
    $router->post(
        'products',
        [
            'uses' => 'ProductController@create',
            'as' => 'create.products']
    );
    $router->patch(
        'products/{id}',
        [
            'uses' => 'ProductController@update',
            'as' => 'update.products']
    );
    $router->delete(
        'products/{id}',
        [
            'uses' => 'ProductController@delete',
            'as' => 'delete.products'
        ]
    );
});

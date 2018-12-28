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

$router->group(['middleware' => 'auth', 'prefix' => 'v1/products'], function () use ($router) {
    $router->get(
        '/',
        [
            'uses' => 'ProductController@getAllProducts',
            'as' => 'products'
        ]
    );
    $router->get(
        '{id}',
        [
            'uses' => 'ProductController@getProductById',
            'as' => 'product'
        ]
    );
    $router->post(
        '/',
        [
            'uses' => 'ProductController@create',
            'as' => 'create.product']
    );
    $router->patch(
        '{id}',
        [
            'uses' => 'ProductController@update',
            'as' => 'update.product']
    );
    $router->delete(
        '{id}',
        [
            'uses' => 'ProductController@delete',
            'as' => 'delete.product'
        ]
    );
    $router->get(
        '{product_id}/images',
        [
            'uses' => 'Product\ImageController@getImages',
            'as' => 'products.images'
        ]
    );
    $router->get(
        '{product_id}/images/{image_id}',
        [
            'uses' => 'Product\ImageController@getImage',
            'as' => 'products.image'
        ]
    );
    $router->post(
        '{product_id}/images',
        [
            'uses' => 'Product\ImageController@create',
            'as' => 'create.product.images'
        ]
    );
    $router->patch(
        '{product_id}/images',
        [
            'uses' => 'Product\ImageController@update',
            'as' => 'update.product.images'
        ]
    );
    $router->delete(
        '{product_id}/images',
        [
            'uses' => 'Product\ImageController@delete',
            'as' => 'delete.product.images'
        ]
    );
});

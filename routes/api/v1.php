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

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('lists/findEmpty', 'SubscriberListController@findEmpty');
    $router->get('lists/findByNewsletterSent', 'SubscriberListController@findByNewsletterSent');
    $router->post('subscribers', 'SubscriberController@create');
    $router->get('subscribers/{id}', 'SubscriberController@show');
    $router->get('subscribers/findByEmail/{email}', 'SubscriberController@showByEmail');
    $router->get('subscribers/findByList/{idList}', 'SubscriberController@findByList');
    $router->delete('subscribers/findByList/{idList}', 'SubscriberController@destroyByList');
    $router->post('newsletters', 'NewsletterController@create');
    $router->post('newsletters/createByEmptyList', 'NewsletterController@createByEmptyList');
    $router->get('newsletters/{id}', 'NewsletterController@show');
});



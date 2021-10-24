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

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@authenticate');

$router->get('/tree', 'TreeController@getNodeExists');
$router->get('/sequence', 'SequenceController@searchSequenceExists');

$router->group(['middleware' => 'jwt.auth','throttle:60,1'], function () use ($router) {
    $router->get('/user', 'UserController@getUser');
    $router->get('/user/{code}', 'UserController@getUserDetail');
    $router->delete('/user/{code}', 'UserController@deleteUser');

    $router->group(['prefix' => 'me'], function () use ($router) {
        $router->get('/account', 'MeController@account');
        $router->get('/wallet', 'MeController@getWallet');
        $router->post('/wallet', 'MeController@createNewWallet');
        $router->post('/wallet/{walletCode}/topup', 'MeController@topUp');
        $router->get('/card/{walletCode}', 'UserWalletCardController@getUserAllCard');
        $router->post('/card/{walletCode}', 'UserWalletCardController@createNewCard');
        $router->put('card/{cardCode}','UserWalletCardController@updateCard');
        $router->delete('card/{cardCode}','UserWalletCardController@deleteCard');
    });
});
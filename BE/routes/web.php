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

$router->get('transactionlist', [
    'as' => 'list', 
	'uses' => 'PermintaanController@index'
]);

$router->get('transactionViewHeader', [
    'as' => 'list', 
	'uses' => 'PermintaanController@transactionViewHeader'
]);

$router->get('transactionBaranglist', [
    'as' => 'list', 
	'uses' => 'PermintaanController@transactionBaranglist'
]);

$router->post('/transaction', [
    'as' => 'posting', 
	'uses' => 'PermintaanController@create'
]);

$router->get('/searchkaryawan', [
    'as' => 'pencarian', 
	'uses' => 'KaryawanController@searchKaryawan'
]); 

$router->get('/baranglist', [
    'as' => 'list', 
	'uses' => 'BarangController@index'
]);




<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

$router->group(['prefix' => 'posts'],function () use ($router){

    $router->get('', PostController::class . '@getList');
    $router->get('{id}', PostController::class . '@get');
    $router->group(['middleware'=>'auth'],function () use ($router){
        $router->post('', PostController::class . '@create');
        $router->put('{id}', PostController::class . '@update');
        $router->delete('{id}', PostController::class . '@delete');
    });
});


$router->group(['prefix' => 'posts/{postId}/comments', 'middleware'=>'auth'], function () use ($router){
    $router->post('', CommentController::class . '@create');
    $router->put('{id}', CommentController::class . '@update');
    $router->delete('{id}', CommentController::class . '@delete');
});

$router->group(['prefix' => 'auth'], function () use ($router){
    $router->get('', UserController::class . '@getList');
    $router->post('register', UserController::class . '@register');
    $router->post('login', UserController::class . '@login');
});



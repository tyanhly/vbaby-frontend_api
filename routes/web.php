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


$app->get('/', function () use ($app) {
    return 'Hello PHP API';
});

$app->group(['prefix' => 'v1'], function () use ($app) {
    $app->get('index', 'TodosController@index');
    $app->get('todos', 'TodosController@indexTodos');
    $app->get('todos/{id}', 'TodosController@viewTodo');
    $app->post('todos', 'TodosController@createTodo');
    $app->put('todos/{id}', 'TodosController@updateTodo');
    $app->delete('todos/{id}', 'TodosController@deleteTodo');
    $app->post('todos/{id}/move', 'TodosController@moveTodo');
    $app->get('swagger.yml', function () {
        return file_get_contents(base_path("/resources/views/swagger.yml"));
    });
});

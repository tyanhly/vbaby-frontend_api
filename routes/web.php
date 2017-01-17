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


    //Contents
    $app->get('index', 'ContentsController@index');
    $app->get('contents', 'ContentsController@indexContents');
    $app->get('contents/{id}', 'ContentsController@viewContent');
    $app->post('contents', 'ContentsController@createContent');
    $app->put('contents/{id}', 'ContentsController@updateContent');
    $app->delete('contents/{id}', 'ContentsController@deleteContent');
    $app->post('contents/{id}/move', 'ContentsController@moveContent');

    //Content Categories
    $app->get('index', 'contentCategoriesController@index');
    $app->get('contentCategories', 'contentCategoriesController@indexContentCategories');
    $app->get('contentCategories/{id}', 'contentCategoriesController@viewContentCategories');
    $app->post('contentCategories', 'contentCategoriesController@createContentCategories');
    $app->put('contentCategories/{id}', 'contentCategoriesController@updateContentCategories');
    $app->delete('contentCategories/{id}', 'contentCategoriesController@deleteContentCategories');
    $app->post('contentCategories/{id}/move', 'contentCategoriesController@moveContentCategories');

    //Swagger.yml
    $app->get('swagger.yml', function () {
        return file_get_contents(base_path("/resources/views/swagger.yml"));
    });
});


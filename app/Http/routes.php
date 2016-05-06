<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/{workerId?}', 'HomeController@index');

Route::get('workers', ['uses' => 'WorkerController@index', 'as' => 'workers']);
Route::resource('worker', 'WorkerController', ['except' => 'index']);
Route::get('tasks', ['uses' => 'TaskController@index', 'as' => 'tasks']);
Route::resource('task', 'TaskController', ['except' => 'index']);

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

Route::get('/users{id}', function($id){
  return 'this is user '.$id;
});

Route::get('/users/{id}', function($id){
  return 'this is user '.$id;

*/
Auth::routes();

Route::get('/home', 'PagesController@index');
Route::get('/', 'PagesController@index');
Route::get('/top10', 'PagesController@top10');
Route::get('/notifications', 'PagesController@notifications');

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
Route::post('/', array('as' => 'search','uses' => 'PagesController@search'));
Route::post('/sortby', array('as' => 'sortby','uses' => 'PagesController@sortby'));

Route::get('/top10', 'PagesController@top10');

Route::get('/users', 'PagesController@users');
Route::post('/users', array('as' => 'search_users','uses' => 'PagesController@search_users'));

Route::get('/figure/{id}', array('as' => 'show_figure','uses' => 'PagesController@figure'));

Route::group(['middleware' => ['auth']], function() {

  Route::get('/figure/{id}/add', array('as' => 'add_notification','uses' => 'PagesController@notification'));
  Route::get('/figure/{id}/addlike', array('as' => 'add_like','uses' => 'PagesController@add_like'));
  Route::get('/figure/{id}/addtocollection', array('as' => 'add_tocollection','uses' => 'PagesController@add_tocollection'));

  Route::post('/addcomment', array('as' => 'add_comment','uses' => 'PagesController@add_comment'));
  Route::get('/deletecomment/{id}', array('as' => 'delete_comment','uses' => 'PagesController@delete_comment'));
  Route::get('/reportcomment/{id}', array('as' => 'report_comment','uses' => 'PagesController@report_comment'));

  Route::get('/notifications', 'PagesController@notifications');
  Route::get('/notifications/{id}', array('as' => 'delete_notification','uses' => 'PagesController@delete_notification'));

  Route::get('/profile/{name}', array('as' => 'profile','uses' => 'PagesController@profile'));
  Route::get('/profile/addfriend/{id}', array('as' => 'add_friend','uses' => 'PagesController@add_friend'));
  Route::get('/profile/acceptfriend/{id}', array('as' => 'accept_friend','uses' => 'PagesController@accept_friend'));
  Route::get('/profile/deletefriend/{id}', array('as' => 'delete_friend','uses' => 'PagesController@delete_friend'));
  Route::post('profile/reportuser', array('as' => 'report_user','uses' => 'PagesController@report_user'));
  Route::post('/profile/sendmessage', array('as' => 'send_message','uses' => 'PagesController@send_message'));
  Route::post('/profile/editdescription', array('as' => 'edit_description','uses' => 'PagesController@edit_description'));
  Route::post('/profile/changeav', 'PagesController@change_av');
  Route::get('/profile/deletefromcol/{id}', array('as' => 'delete_from_collection','uses' => 'PagesController@delete_from_collection'));

  Route::get('/mailbox', 'PagesController@mailbox');
  Route::get('/mailbox/deletesent/{id}', array('as' => 'delete_sent','uses' => 'PagesController@delete_sent'));
  Route::get('/mailbox/deletereceived/{id}', array('as' => 'delete_received','uses' => 'PagesController@delete_received'));

  Route::get('/admin', array('as' => 'admin','uses' => 'PagesController@admin'));
  Route::get('/admin/banuser/{id}', array('as' => 'ban_user','uses' => 'PagesController@ban_user'));
  Route::get('/admin/deletereport/{id}', array('as' => 'delete_report','uses' => 'PagesController@delete_report'));
  Route::get('/deletereportcom/{id}', array('as' => 'delete_report_com','uses' => 'PagesController@delete_report_com'));
});

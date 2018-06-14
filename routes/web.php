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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

//Registratie
Auth::routes();
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index');


//threads
Route::get('/threads/create', 'ThreadsController@create')->name('thread.create');
Route::post('threads', 'ThreadsController@store')->name('threads')->middleware('must-be-confirmed');
Route::get('/threads/{channel?}', 'ThreadsController@index')->name('threads.index');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('thread.show');
Route::patch('/threads/{channel}/{thread}', 'ThreadsController@update')->name('thread.update');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy')->name('thread.destroy');

//lock-unlock een thread
Route::post('/locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');


//replies
Route::patch('/replies/{reply}', 'RepliesController@update')->name('reply.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('reply.destroy');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('reply.store');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('favorite.store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('favorite.delete');


//best-replies
Route::post('/replies/{reply}/best', 'BestRepliesController@store');


//profiles
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile.show');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

//subscriptions
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy');

//Api
Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');


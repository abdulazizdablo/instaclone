<?php

use Illuminate\Support\Facades\Route;
use App\Mail\NewUserWelcomeMail;

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

Auth::routes();

// Profile routes
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}/update', 'ProfilesController@update')->name('profile.update');

// home route
Route::get('/', 'PostsController@index');
// Post routes
Route::get('/p/create', 'PostsController@create');
Route::post('/p', 'PostsController@store');
Route::get('/p/{post}', 'PostsController@show');

// Follow route
Route::post('/follow/{user}', 'FollowsController@store');

Route::get('/email', function(){
    return new NewUserWelcomeMail();
});
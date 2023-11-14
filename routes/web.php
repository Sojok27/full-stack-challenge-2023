<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

use App\Http\Controllers\CommentController;

// Comments

Route::post('/add-comment', "\App\Http\Controllers\CommentController@store")->name("add-comment");


Route::get('/delete-comment/{id}', "\App\Http\Controllers\CommentController@destroy")->name("delete-comment");

Route::get('/users', "\App\Http\Controllers\UserController@create")->name("users");
Route::post('/users/store', "\App\Http\Controllers\UserController@store")->name("store-user");
Route::post('/users/update', "\App\Http\Controllers\UserController@update")->name("update-user");
Route::get('/users/delete/{id}', "\App\Http\Controllers\UserController@destroy")->name("delete-user");

Route::get('/', function () {
	return view('default');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

// //Routes for Posts
// Route::get('posts', 'PostsController@index');
// Route::post('posts', 'PostsController@store');
// Route::get('posts/create', 'PostsController@create');
// Route::get('posts/{post}', 'PostsController@show');

//Routes for Referrals
Route::get('referrals/upload', 'ReferralController@upload');
Route::post('referrals/upload', 'ReferralController@processUpload');
Route::get('referrals/create', 'ReferralController@create')->name('add-referral');
Route::get('referrals/', 'ReferralController@index');
Route::post('referrals-filtered/', 'ReferralController@index')->name("referrals-filtered");
Route::get('referrals-filtered/', 'ReferralController@index');
Route::post('referrals', 'ReferralController@store')->name("referrals");

//Logged in Users
// Route::get('my-posts', 'AuthorsController@posts')->name('my-posts');

// //Routes for Authors
// Route::get('authors', 'AuthorsController@index');
// Route::get('authors/{author}', 'AuthorsController@show');


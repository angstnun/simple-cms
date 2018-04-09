<?php

use Illuminate\Http\Request;

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

Auth::routes();

Route::middleware('auth')->group(function() {

	//Dashboard

	Route::get('/dashboard', 'Dashboard\ArticleController@index');
	Route::get('/settings', 'Dashboard\SettingController@showSettings');
	Route::post('/edit-settings', 'Dashboard\SettingController@editSettings');

	//Pages

	Route::get('/pages', 'Dashboard\PageController@index');

	Route::get('/create-page', 'Dashboard\PageController@showPageCreator');
	Route::get('/delete-page', 'Dashboard\PageController@deletePage');
	Route::get('/edit-page', 'Dashboard\PageController@showPageEditor');
	Route::get('/search-page', 'Dashboard\PageController@searchPage');
	
	Route::post('/getPages', 'Dashboard\PageController@getPagesNames');
	Route::post('/create-page', 'Dashboard\PageController@newPage');
	Route::post('/edit-page', 'Dashboard\PageController@editPage');

	//Articles

	Route::get('/articles', 'Dashboard\ArticleController@index');

	Route::get('/create-article', 'Dashboard\ArticleController@showArticleCreator');
	Route::get('/delete-article', 'Dashboard\ArticleController@deleteArticle');
	Route::get('/edit-article', 'Dashboard\ArticleController@showArticleEditor');
	Route::get('/search-article', 'Dashboard\ArticleController@searchArticle');
	Route::post('/edit-article', 'Dashboard\ArticleController@editArticle');
	Route::post('/create-article', 'Dashboard\ArticleController@createArticle');
	Route::post('/getArticles', 'Dashboard\ArticleController@getArticleNames');

	//Categories
	
	Route::get('/categories', 'Dashboard\CategoryController@index');

	Route::get('/edit-category', 'Dashboard\CategoryController@showCategoryEditor');
	Route::get('/create-category', 'Dashboard\CategoryController@showCategoryCreator');
	Route::get('/delete-category', 'Dashboard\CategoryController@deleteCategory');
	Route::get('/search-category', 'Dashboard\CategoryController@searchCategory');

	Route::post('/getCategories', 'Dashboard\CategoryController@getCategoryNames');
	Route::post('/create-category', 'Dashboard\CategoryController@createCategory');
	Route::post('/edit-category', 'Dashboard\CategoryController@editCategory');

	//User

	Route::get('/user', 'Dashboard\UserController@showUser');
	Route::post('/edit-user', 'Dashboard\UserController@editUser');

	//Images
	
	Route::post('/imgUpload', 'Dashboard\ImageController@upload');
});

//Search - Returns pages, categories or articles.

Route::get('/test', 'HomeController@test');	

Route::get('/search', 'HomeController@search');

Route::get('/', 'HomeController@index');

Route::get('/{slug}', 'HomeController@getResource');

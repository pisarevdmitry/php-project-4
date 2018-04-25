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

Route::get('/search/goods', 'Search@searchGoods');
Route::get('/search/news', 'Search@searchNews');
Route::get('/', 'Home@index');
Route::get('/category/{id}', 'Category@index');
Route::get('/product/{id}', 'Product@index');
Route::get('/about', 'About@index');
Route::get('/orders', 'Orders@index');
Route::get('/news', 'NewsController@index');
Route::get('/news/article/{id}', 'NewsController@article');

Route::get('/orders/confirm', 'Orders@confirm');
Route::get('/admin/mail', 'Orders@mail');
Route::get('/admin/orders', 'Orders@getOrdersAdmin');
Route::get('/admin/category', 'Category@CategoryList');
Route::get('/admin/product', 'Product@productList');
Route::get('/admin/product/store-form', 'Product@storeShow');
Route::get('/admin/product/edit-form/{id}', 'Product@editShow');
Route::post('/admin/product/store', 'Product@store');
Route::post('/admin/product/edit', 'Product@edit');
Route::get('/admin/product/delete/{id}', 'Product@delete');

Route::get('/admin/news', 'NewsController@newsList');
Route::get('/admin/news/store-form', 'NewsController@storeShow');
Route::get('/admin/news/edit-form/{id}', 'NewsController@editShow');
Route::post('/admin/news/store', 'NewsController@store');
Route::post('/admin/news/edit', 'NewsController@edit');
Route::get('/admin/news/delete/{id}', 'NewsController@delete');



Route::get('/admin/category/store-form', 'Category@storeShow');
Route::get('/admin/category/edit-form/{id}', 'Category@editShow');
Route::post('/admin/category/store', 'Category@store');
Route::post('/admin/category/edit', 'Category@edit');
Route::get('/admin/category/delete/{id}', 'Category@delete');
Route::post('/orders/register', 'Orders@register');
Route::post('/admin/changeMail', 'Orders@changeMail');

//Route::get('/test', 'Home@test');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

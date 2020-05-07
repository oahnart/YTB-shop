<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('index', [
    'as' => 'trang-chu',
    'uses' => 'PageController@getIndex'
]);

Route::get('loai-san-pham/{type}', [
    'as' => 'loaisanpham',
    'uses' => 'PageController@getLoaiSp'
]);

Route::get('chi-tiet-san-pham/{id}', [
    'as' => 'chitietsanpham',
    'uses' => 'PageController@getChitiet'
]);

Route::get('lien-he', [
    'as' => 'lienhe',
    'uses' => 'PageController@getLienHe'
]);

Route::get('gioi-thieu', [
    'as' => 'gioithieu',
    'uses' => 'PageController@getGioiThieu'
]);

//Route::get('add-to-cart/{id}',[
//    'as'=>'themgiohang',
//    'uses'=> 'PageController@getAddToCart'
//]);

Route::get('login',[
    'as' => 'login',
    'uses'=>'PageController@getLogin'
]);

Route::post('login',[
    'as' => 'login',
    'uses'=>'PageController@postLogin'
]);

Route::get('register',[
    'as' => 'register',
    'uses'=>'PageController@getRegister'
]);

Route::post('signin',[
    'as' => 'signin',
    'uses'=>'PageController@postSignin'
]);

Route::get('logout',[
    'as' => 'logout',
    'uses'=>'PageController@getLogout'
]);

Route::get('search',[
    'as' => 'search',
    'uses'=>'PageController@getSearch'
]);

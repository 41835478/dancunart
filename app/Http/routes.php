<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web'],'prefix' => 'admin'], function () {
//    Route::get('/',function(){
//       dd(config('app.error_no.40001'));
//    });
    /**
	 * 后台路由
	 */
    //后台登录相关路由
    Route::get('login','AdminLoginController@login')->name('adminLogin');
    Route::post('login','AdminLoginController@loginCheck');
    Route::get('loginOut','AdminLoginController@loginOut');

    //后台主页路由
    Route::resource('/','AdminController');
});

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
/**
 * 前台路由
 */

Route::group(['middleware' => ['web']],function(){
    Route::get('userAttention/{status?}/{id?}','AppUserController@attention');
});

/**
 * 后台路由
 */
Route::group(['middleware' => ['web'],'prefix' => 'admin'], function () {
    //后台登录相关路由
    Route::get('login','AdminLoginController@login')->name('adminLogin');
    Route::post('login','AdminLoginController@loginCheck');
    Route::get('loginOut','AdminLoginController@loginOut');

    //上传图片路由
    Route::post('upload','AdminUploadController@upload');

    //网站配置
    Route::resource('siteConfig','AdminSiteConfigController');
    Route::resource('siteFriendlink','AdminSiteFriendlinkController');
    Route::resource('ExpressList','AdminExpressListController');
    Route::resource('CSR','AdminCSRController');

    //后台修改用户信息路由
    Route::resource('auth','AdminAuthController');

    //后台艺术家路由
    Route::resource('artist','AdminArtistController');
    Route::resource('artistclass','AdminArtistClassController');
    //后台拍品路由
    Route::resource('artwork','AdminArtWorkController');
    Route::resource('artworkclass','AdminArtWorkClassController');
    //后台订单路由
    Route::get('order','AdminOrderController@order');
    Route::get('orderAuction','AdminOrderController@auchtion');
    Route::get('orderWithdraw','AdminOrderController@withdraw');
    Route::post('withdraw/{id?}','AdminOrderController@withdrawhandle');
    Route::post('order/{id?}','AdminOrderController@orderhandle');

    Route::get('orderExpress/invalid/{id?}','AdminOrderController@invalid');
    Route::resource('orderExpress','AdminOrderController');

    //用户路由
    Route::get('user/Log','AdminUserController@userlog');
    Route::get('user/accountset/{id?}/{nav?}','AdminUserController@accountset');
    Route::resource('user','AdminUserController');

    //后台主页路由
    Route::resource('/','AdminController');
});

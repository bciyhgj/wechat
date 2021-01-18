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

// 微信
Route::any('/wechat', 'WeChat\WeChatController@serve');

// 拿到用户授权信息
Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料

        dd($user);
    });
});

// $app_id 是微信传过来的公众号或小程序的APPID
// 接收微信推送来的事件和消息
Route::any('receiver/{appid}', 'WeChat\WeChatController@receiver');
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

		// array:1 [▼
		//   "default" => User {#394 ▼
		//     #attributes: array:8 [▼
		//       "id" => "oheQ-s2R2SjoSom6oWxLOcnKPGR8"
		//       "name" => "所有的伟大 源于一个勇敢的开始"
		//       "nickname" => "所有的伟大 源于一个勇敢的开始"
		//       "avatar" => "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJibCJxeF0ibxdCjnWic5yhyBfpE8ERZXr8GPXrKVqyftkBcjbPen2X35SbPcFEPMseQC5wQop0NwAew/132"
		//       "email" => null
		//       "original" => array:9 [▼
		//         "openid" => "oheQ-s2R2SjoSom6oWxLOcnKPGR8"
		//         "nickname" => "所有的伟大 源于一个勇敢的开始"
		//         "sex" => 1
		//         "language" => "zh_CN"
		//         "city" => "杭州"
		//         "province" => "浙江"
		//         "country" => "中国"
		//         "headimgurl" => "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJibCJxeF0ibxdCjnWic5yhyBfpE8ERZXr8GPXrKVqyftkBcjbPen2X35SbPcFEPMseQC5wQop0NwAew/132"
		//         "privilege" => []
		//       ]
		//       "token" => AccessToken {#395 ▼
		//         #attributes: array:5 [▼
		//           "access_token" => "9_go7Ks5AmSHgN4j5_vaSvZOwehVuLfyhsVYKpvPEOkPbGjUaL6MUoy0XRdwDTKtwnVoMfB37N10nc05vLB0thGQ"
		//           "expires_in" => 7200
		//           "refresh_token" => "9_f8cEfPuPpcRzUib0y14gbGpdLi282oRdsEASstjtv3pNULoAA5khi6ZcxofN2O5jrrfCafUkcjr2jbq758qnyw"
		//           "openid" => "oheQ-s2R2SjoSom6oWxLOcnKPGR8"
		//           "scope" => "snsapi_userinfo"
		//         ]
		//       }
		//       "provider" => "WeChat"
		//     ]
		//   }
		// ]


    });
});

// $app_id 是微信传过来的公众号或小程序的APPID
// 接收微信推送来的事件和消息
Route::any('receiver/{appid}', 'WeChat\WeChatController@receiver');
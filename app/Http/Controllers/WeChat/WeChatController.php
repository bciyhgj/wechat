<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Log;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            return "欢迎关注 overtrue！";
        });

        //从项目实例中得到一个服务端应用实例
        $server = $app->server;
        //用户实例，可以通过类似$user->nickname这样的方法拿到用户昵称，openid等等
        $user = $app->user;
        //接收用户发送的消息
        $server->setMessageHandler(function ($message) use ($user) {
            //对用户发送的消息根据不同类型进行区分处理
            switch ($message->MsgType) {
                //事件类型消息（点击菜单、关注、扫码），略
                case 'event':
                    switch ($message->Event) {
                        case 'subscribe':
                            // code...
                            break;

                        default:
                            // code...
                            break;
                    }
                    break;
                //文本信息处理
                case 'text':
                    //获取到用户发送的文本内容
                    $content = $message->Content;
                    //发送到图灵机器人接口
                    $url = "http://www.tuling123.com/openapi/api?key=【图
                   灵机器人API KEY】&info=" . $content;
                    //获取图灵机器人返回的内容
                    $content = file_get_contents($url);
                    //对内容json解码
                    $content = json_decode($content);
                    //把内容发给用户
                    return new Text(['content' => $content->text]);
                    break;
                // 图片信息处理，略
                case 'image':
                    $mediaId = $message->MediaId;
                    return new Image(['media_id' => $mediaId]);
                    break;
                // 声音信息处理，略
                case 'voice':
                    $mediaId = $message->MediaId;
                    return new Voice(['media_id' => $mediaId]);
                    break;
                // 视频信息处理，略
                case 'video':
                    $mediaId = $message->MediaId;
                    return new Video(['media_id' => $mediaId]);
                    break;
                // 坐标信息处理，略
                case 'location':
                    return new Text(['content' => $message->Label]);
                    break;

                // 链接信息处理，略
                case 'link':
                    return new Text(['content' => $message->Description]);
                    break;

                default:
                    break;
            }
        });
        //响应输出
        // $server->serve()->send();

        return $app->server->serve();
    }
}

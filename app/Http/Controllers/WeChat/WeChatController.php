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

        $app    = app('wechat.official_account');

        //用户实例，可以通过类似$user->nickname这样的方法拿到用户昵称，openid等等
        $user = $app->user;
        
        // 接受用户发送的信息
        $app->server->push(function ($message) use ($app, $user) {
            switch ($message['MsgType']) {
                case 'event':
                    if ($message->MsgType == 'event') {
                        $user_openid = $message->FromUserName;
                        if ($message->Event == 'subscribe') {
                            //下面是你点击关注时，进行的操作
                            $user_info['unionid']        = $message->ToUserName;
                            $user_info['openid']         = $user_openid;
                            $userService                 = $app->user;
                            $user                        = $userService->get($user_info['openid']);
                            $user_info['subscribe_time'] = $user['subscribe_time'];
                            $user_info['nickname']       = $user['nickname'];
                            $user_info['avatar']         = $user['headimgurl'];
                            $user_info['sex']            = $user['sex'];
                            $user_info['province']       = $user['province'];
                            $user_info['city']           = $user['city'];
                            $user_info['country']        = $user['country'];
                            $user_info['is_subscribe']   = 1;
                            // if (WxStudent::weixin_attention($user_info)) {
                            //     return '欢迎关注';
                            // } else {
                            //     return '您的信息由于某种原因没有保存，请重新关注';
                            // }
                            return '欢迎关注';
                        } else if ($message->Event == 'unsubscribe') {
                            //取消关注时执行的操作，（注意下面返回的信息用户不会收到，因为你已经取消关注，但别的操作还是会执行的<如：取消关注的时候，要把记录该用户从记录微信用户信息的表中删掉>）
                            // if (WxStudent::weixin_cancel_attention($user_openid)) {
                            // return '已取消关注';
                            // }
                            return '已取消关注';
                        }
                    }
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            return "欢迎关注 overtrue！";
        });

        // 清理接口调用次数
        // $app->base->clearQuota();
        
        // 获取微信服务器 IP (或IP段)
        // $app->base->getValidIps();

        // 从项目实例中得到一个服务端应用实例
        // $server = $app->server;
        // $ref    = new \ReflectionClass(get_class($server));
        // $consts = $ref->getConstants(); //返回所有常量名和值
        // echo "----------------consts:---------------" . '<br />';
        // foreach ($consts as $key => $val) {
        //     echo "$key : $val" . '<br />';
        // }
        // $props = $ref->getDefaultProperties(); //返回类中所有属性
        // echo "--------------------props:--------------" . '<br />';
        // foreach ($props as $key => $val) {
        //     echo "$key : $val" . '<br />'; // 属性名和属性值
        // }
        // $methods = $ref->getMethods(); //返回类中所有方法
        // echo "-----------------methods:---------------" . '<br />';
        // foreach ($methods as $method) {
        //     echo $method->getName() . '<br />';
        // }
        // dd();


        //接收用户发送的消息
        $app->server->getMessage(function ($message) use ($app) {

        });

        // $server->setMessageHandler(function ($message) use ($user) {
        //     //对用户发送的消息根据不同类型进行区分处理
        //     switch ($message->MsgType) {
        //         //事件类型消息（点击菜单、关注、扫码），略
        //         case 'event':
        //             switch ($message->Event) {
        //                 case 'subscribe':
        //                     // code...
        //                     break;

        //                 default:
        //                     // code...
        //                     break;
        //             }
        //             break;
        //         //文本信息处理
        //         case 'text':
        //             //获取到用户发送的文本内容
        //             $content = $message->Content;
        //             //发送到图灵机器人接口
        //             $url = "http://www.tuling123.com/openapi/api?key=【图
        //            灵机器人API KEY】&info=" . $content;
        //             //获取图灵机器人返回的内容
        //             $content = file_get_contents($url);
        //             //对内容json解码
        //             $content = json_decode($content);
        //             //把内容发给用户
        //             return new Text(['content' => $content->text]);
        //             break;
        //         // 图片信息处理，略
        //         case 'image':
        //             $mediaId = $message->MediaId;
        //             return new Image(['media_id' => $mediaId]);
        //             break;
        //         // 声音信息处理，略
        //         case 'voice':
        //             $mediaId = $message->MediaId;
        //             return new Voice(['media_id' => $mediaId]);
        //             break;
        //         // 视频信息处理，略
        //         case 'video':
        //             $mediaId = $message->MediaId;
        //             return new Video(['media_id' => $mediaId]);
        //             break;
        //         // 坐标信息处理，略
        //         case 'location':
        //             return new Text(['content' => $message->Label]);
        //             break;

        //         // 链接信息处理，略
        //         case 'link':
        //             return new Text(['content' => $message->Description]);
        //             break;

        //         default:
        //             break;
        //     }
        // });
        //响应输出
        // $server->serve()->send();

        // $response = $app->server->serve();
        // $response->send();
        // 我们的 $app->server->serve() 就是执行服务端业务了，那么它的返回值是一个 Symfony\Component\HttpFoundation\Response 实例。
        // 我这里是直接调用了它的 send() 方法，它就是直接输出（echo）了，我们在一些框架就不能直接输出了，那你就直接拿到 Response 实例后做相应的操作即可，比如 Laravel 里你就可以直接 return $app->server->serve();

        return $app->server->serve();
    }
}

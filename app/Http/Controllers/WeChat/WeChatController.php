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

        /**
         * 菜单
         */
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        $app->menu->create($buttons);

        //用户实例，可以通过类似$user->nickname这样的方法拿到用户昵称，openid等等
        $user = $app->user;

        // 接受用户发送的信息。这里我们使用 push 传入了一个 闭包（Closure），该闭包接收一个参数 $message 为消息对象（类型取决于你的配置中 response_type）。
        $app->server->push(function ($message) use ($app, $user) {

            // 请求消息基本属性(以下所有消息都有的基本属性)：
            // $message['ToUserName']    接收方帐号（该公众号 ID）
            // $message['FromUserName']  发送方帐号（OpenID, 代表用户的唯一标识）
            // $message['CreateTime']    消息创建时间（时间戳）
            // $message['MsgId']         消息 ID（64位整型）
            
            $toUserName = $message['ToUserName'];
            $userOpenid = $message['FromUserName'];
            $createTime = $message['CreateTime'];
            $msgId = $message['MsgId'];

            switch ($message['MsgType']) {
                case 'event':
                    // 事件：
                    // - Event       事件类型 （如：subscribe(订阅)、unsubscribe(取消订阅) ...， CLICK 等）

                    // # 扫描带参数二维码事件
                    // - EventKey    事件KEY值，比如：qrscene_123123，qrscene_为前缀，后面为二维码的参数值
                    // - Ticket      二维码的 ticket，可用来换取二维码图片

                    // # 上报地理位置事件
                    // - Latitude    23.137466   地理位置纬度
                    // - Longitude   113.352425  地理位置经度
                    // - Precision   119.385040  地理位置精度

                    // # 自定义菜单事件
                    // - EventKey    事件KEY值，与自定义菜单接口中KEY值对应，如：CUSTOM_KEY_001, www.qq.com

                    $user_openid = $message['FromUserName'];
                    if ($message['Event'] == 'subscribe') {
                        //下面是你点击关注时，进行的操作
                        $user_info['unionid']        = $message['ToUserName'];
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
                    } else if ($message['Event'] == 'unsubscribe') {
                        //取消关注时执行的操作，（注意下面返回的信息用户不会收到，因为你已经取消关注，但别的操作还是会执行的<如：取消关注的时候，要把记录该用户从记录微信用户信息的表中删掉>）
                        // if (WxStudent::weixin_cancel_attention($user_openid)) {
                        // return '已取消关注';
                        // }
                        return '已取消关注';
                    }
                    return '收到事件消息';
                    break;
                case 'text':
                    // 文本：
                    // - MsgType  text
                    // - Content  文本消息内容
                    
                    switch ($message['Content']) {
                        case '菜单':
                            # code...
                            break;

                        case '模板':
                            Log::info(implode("\n", $app->template_message->getPrivateTemplates()));
                            // $app->template_message->getPrivateTemplates();

                            // 在推送信息中如果需要换行可以使用\\n(双斜杠n)来实现
                            $app->template_message->send([
                                'touser' => $userOpenid,
                                'template_id' => 'hMaxKs6qJwtMeaWj2rWJzYlxJYr8MADVUdfOH2BIxGE',
                                'url' => 'http://blog.tianwangchong.com/',
                                'data' => [
                                    'name' => ['value' => '田大爷', 'color' => '#f4645f'],
                                ],
                            ]);
                            return '已发送消息模板';
                            break;

                        case 'ip':
                            // 获取微信服务器 IP (或IP段)
                            return implode(",", $app->base->getValidIps());
                            break;

                        default:
                            # code...
                            break;
                    }

                    return '收到文字消息' . ':' . $message['Content'];
                    break;
                case 'image':
                    // 图片：
                    // - MsgType  image
                    // - MediaId        图片消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - PicUrl   图片链接
                    return '收到图片消息' . '-' . 'MediaId' . ':' . $message['MediaId'] . 'PicUrl' . ':' . $message['PicUrl'];
                    break;
                case 'voice':
                    // 语音：
                    // - MsgType        voice
                    // - MediaId        语音消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - Format         语音格式，如 amr，speex 等
                    // - Recognition * 开通语音识别后才有

                    // > 请注意，开通语音识别后，用户每次发送语音给公众号时，微信会在推送的语音消息XML数据包中，增加一个 `Recongnition` 字段
                    return '收到语音消息' . ':' . $message['MediaId'];
                    break;
                case 'video':
                    // 视频：
                    // - MsgType       video
                    // - MediaId       视频消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - ThumbMediaId  视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。
                    return '收到视频消息';
                    break;
                case 'shortvideo':
                    // 小视频：
                    // - MsgType     shortvideo
                    // - MediaId     视频消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - ThumbMediaId    视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。
                    return '收到小视频消息';
                case 'location':
                    // 地理位置：
                    // $message->MsgType     location
                    // $message->Location_X  地理位置纬度
                    // $message->Location_Y  地理位置经度
                    // $message->Scale       地图缩放大小
                    // $message->Label       地理位置信息
                    return '收到坐标消息' . '-' . '地理位置纬度' . ':' . $message['Location_X'] . '地理位置经度' . ':' . $message['Location_Y'] . '地图缩放大小' . ':' . $message['Scale'] . '地理位置信息' . ':' . $message['Label'];
                    break;
                case 'link':
                    // 链接：
                    // $message->MsgType      link
                    // $message->Title        消息标题
                    // $message->Description  消息描述
                    // $message->Url          消息链接
                    return '收到链接消息' . '-' . '消息标题' . ':' . $message['Title'] . '消息描述' . ':' . $message['Description'] . '消息链接' . ':' . $message['Url'];
                    break;
                case 'file':
                    // 文件：
                    // $message->MsgType      file
                    // $message->Title        文件名
                    // $message->Description 文件描述，可能为null
                    // $message->FileKey      文件KEY
                    // $message->FileMd5      文件MD5值
                    // $message->FileTotalLen 文件大小，单位字节
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            return "欢迎关注 田大爷！";
        });

        // 某些情况，我们需要直接使用 $message 参数，那么怎么在 push 的闭包外调用呢？
        // $message = $server->getMessage();

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

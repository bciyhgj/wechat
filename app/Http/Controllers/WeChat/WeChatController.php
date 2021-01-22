<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Log;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat\Kernel\Messages\Video;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        // 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
        Log::info('request arrived.');

        // 创建公众号服务
        // $app = Factory::officialAccount($config);
        $app = app('wechat.official_account');

        /**
         * 自定义菜单
         */
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "TODAY_MUSIC",
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/",
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/",
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key"  => "ZAN",
                    ],
                ],
            ],
        ];
        $app->menu->create($buttons);

        // 接受用户发送的信息。这里我们使用 push 传入了一个 闭包（Closure），该闭包接收一个参数 $message 为消息对象（类型取决于你的配置中 response_type）。
        $app->server->push(function ($message) use ($app) {

            // 请求消息基本属性(以下所有消息都有的基本属性)：
            // $message['ToUserName']    接收方帐号（该公众号 ID）
            // $message['FromUserName']  发送方帐号（OpenID, 代表用户的唯一标识）
            // $message['CreateTime']    消息创建时间（时间戳）
            // $message['MsgId']         消息 ID（64位整型）

            $toUserName = $message['ToUserName'];
            $userOpenid = $message['FromUserName'];
            $createTime = $message['CreateTime'];
            // $msgId = $message['MsgId'];

            /**
             * 用户信息
             */
            // 获取单个用户信息：
            // $user = $app->user->get($message['FromUserName']);
            // Log::info($user);
            // array (
            //   'subscribe' => 1,
            //   'openid' => 'oheQ-s2R2SjoSom6oWxLOcnKPGR8',
            //   'nickname' => '所有的伟大 源于一个勇敢的开始',
            //   'sex' => 1,
            //   'language' => 'zh_CN',
            //   'city' => '杭州',
            //   'province' => '浙江',
            //   'country' => '中国',
            //   'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/cWHVd8XtnlRas7rmhM1hBQIG6ITGSA4Tomzf50fWPjlBFqAnqNjhzxRfDKX6a2GITQicYLuZ3v6n7uicbQxichAbic5N8myDSC6L/132',
            //   'subscribe_time' => 1474560453,
            //   'remark' => '',
            //   'groupid' => 0,
            //   'tagid_list' =>
            //   array (
            //   ),
            //   'subscribe_scene' => 'ADD_SCENE_OTHERS',
            //   'qr_scene' => 0,
            //   'qr_scene_str' => '',
            // )

            // // 获取多个用户信息：
            // $users = $app->user->select(['oheQ-s0msxrE2LF8BJGLVV5GAFio', 'oheQ-s2R2SjoSom6oWxLOcnKPGR8']);
            // Log::info($users);
            
            // // 获取用户列表
            // $users = $app->user->list();
            // Log::info($users);

            // $user = $app->user->get('oheQ-s0msxrE2LF8BJGLVV5GAFio');
            // Log::info($user);

            // // 修改用户备注
            // $app->user->remark('oheQ-s0msxrE2LF8BJGLVV5GAFio', '僵尸粉');

            // $users = $app->user->list();
            // Log::info('用户列表:');
            // Log::info($users);

            // // 拉黑用户
            // $app->user->block('oheQ-s0msxrE2LF8BJGLVV5GAFio');

            // $users = $app->user->list();
            // Log::info('拉黑后-用户列表:');
            // Log::info($users);

            // // 获取黑名单
            // $users = $app->user->blacklist();
            // Log::info('拉黑名单列表:');
            // Log::info($users);

            // // 取消拉黑用户
            // $app->user->unblock('oheQ-s0msxrE2LF8BJGLVV5GAFio');

            // $users = $app->user->list();
            // Log::info('取消拉黑用户后-用户列表:');
            // Log::info($users);

            // // 获取黑名单
            // $users = $app->user->blacklist();
            // Log::info('拉黑名单列表:');
            // Log::info($users);

            /**
             * 用户标签
             */
            // 获取所有标签
            $tags = $app->user_tag->list();
            Log::info('获取所有标签');
            Log::info($tags);

            // 创建标签
            $tag = $app->user_tag->create('测试标签');
            $tag = $app->user_tag->create('测试标签2');
            Log::info('创建标签-标签信息');
            Log::info($tag);

            // 获取所有标签
            $tags = $app->user_tag->list();
            Log::info('获取所有标签');
            Log::info($tags);

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
                    // 事件有点击菜单、关注、取消关注、扫码等
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

                    $responseContent = '';
                    $content         = trim($message['Content']);
                    switch ($content) {
                        case '菜单':
                            $responseContent = '菜单菜单';
                            break;

                        case '模板':
                            // Log::info(implode("\n", $app->template_message->getPrivateTemplates()));
                            // $app->template_message->getPrivateTemplates();

                            // 在推送信息中如果需要换行可以使用\\n(双斜杠n)来实现
                            $app->template_message->send([
                                'touser'      => $userOpenid,
                                'template_id' => 'hMaxKs6qJwtMeaWj2rWJzYlxJYr8MADVUdfOH2BIxGE',
                                'url'         => 'http://baidu.com',
                                'data'        => [
                                    'name' => ['value' => '田大爷', 'color' => '#f4645f'],
                                ],
                            ]);
                            $responseContent = '已发送消息模板';
                            break;

                        case 'ip':
                            // 获取微信服务器 IP (或IP段)
                            $ips = implode(",", $app->base->getValidIps());
                            Log::info($ips);
                            $responseContent = 'ip';
                            break;

                        case 'TODAY_MUSIC':
                            $responseContent = '一首凉凉送给你';
                            break;

                        case 'ZAN':
                            $responseContent = '赞一下';
                            break;

                        case '文本消息群发':
                            Log::info($app->broadcasting->sendText("大家好！我是田大爷", ['oheQ-s0msxrE2LF8BJGLVV5GAFio', 'oheQ-s2R2SjoSom6oWxLOcnKPGR8', $userOpenid]));
                            $app->broadcasting->sendText("大家好！我是田大爷", ['oheQ-s0msxrE2LF8BJGLVV5GAFio', 'oheQ-s2R2SjoSom6oWxLOcnKPGR8', $userOpenid]);
                            $responseContent = '文本消息群发';
                            break;

                        default:
                            # code...
                            break;
                    }
                    if (!empty($responseContent)) {
                        return $responseContent;
                    }

                    // 获取到用户发送的文本内容
                    //发送到图灵机器人接口
                    $url = "http://www.tuling123.com/openapi/api?key=c407416112434017a7e3431bdcf7b417&info=" . $content;
                    // 获取图灵机器人返回的内容
                    $content = file_get_contents($url);
                    // 对内容json解码
                    $content = json_decode($content);

                    // 文本消息
                    // 属性列表：
                    // - content 文本内容
                    return new Text($content->text);

                    // 其他用法
                    // $text = new Text('您好！overtrue。');
                    // // or
                    // $text = new Text();
                    // $text->content = '您好！overtrue。';
                    // // or
                    // $text = new Text();
                    // $text->setAttribute('content', '您好！overtrue。');

                    return '收到文字消息' . ':' . $message['Content'];
                    break;

                case 'image':
                    // 图片：
                    // - MsgType  image
                    // - MediaId        图片消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - PicUrl   图片链接

                    // 图片消息
                    // 属性列表：
                    // - media_id 媒体资源 ID
                    $mediaId = $message['MediaId'];

                    // 图片消息群发
                    $app->broadcasting->sendImage($mediaId, ['oheQ-s0msxrE2LF8BJGLVV5GAFio', 'oheQ-s2R2SjoSom6oWxLOcnKPGR8']);

                    return new Image($mediaId);

                    return '收到图片消息' . '-' . 'MediaId' . ':' . $message['MediaId'] . 'PicUrl' . ':' . $message['PicUrl'];
                    break;

                case 'voice':
                    // 语音：
                    // - MsgType        voice
                    // - MediaId        语音消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - Format         语音格式，如 amr，speex 等
                    // - Recognition * 开通语音识别后才有
                    // > 请注意，开通语音识别后，用户每次发送语音给公众号时，微信会在推送的语音消息XML数据包中，增加一个 `Recongnition` 字段

                    // 声音消息
                    // 属性列表：
                    // - media_id 媒体资源 ID
                    $mediaId = $message['MediaId'];

                    // 语音消息群发
                    $app->broadcasting->sendVoice($mediaId, ['oheQ-s0msxrE2LF8BJGLVV5GAFio', 'oheQ-s2R2SjoSom6oWxLOcnKPGR8']);

                    return new Voice($mediaId);

                    return '收到语音消息' . ':' . $message['MediaId'];
                    break;

                case 'video':
                    // 视频：
                    // - MsgType       video
                    // - MediaId       视频消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - ThumbMediaId  视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。

                    // 视频消息
                    // 属性列表：
                    // - title 标题
                    // - description 描述
                    // - media_id 媒体资源 ID
                    // - thumb_media_id 封面资源 ID
                    $mediaId = $message['MediaId'];

                    // 视频消息群发
                    $app->broadcasting->sendVideo($mediaId);

                    return new Video($mediaId, [
                        'title' => '标题',
                        'description' => '描述',
                        'thumb_media_id' => $message['ThumbMediaId']
                    ]);

                    return '收到视频消息';
                    break;

                case 'shortvideo':
                    // 小视频：
                    // - MsgType     shortvideo
                    // - MediaId     视频消息媒体id，可以调用多媒体文件下载接口拉取数据。
                    // - ThumbMediaId    视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。
                    return '收到小视频消息';
                    break;

                case 'location':
                    // 地理位置：
                    // $message->MsgType     location
                    // $message->Location_X  地理位置纬度
                    // $message->Location_Y  地理位置经度
                    // $message->Scale       地图缩放大小
                    // $message->Label       地理位置信息

                    // 坐标消息
                    // 微信目前不支持回复坐标消息
                    return new Text($message['Label']);

                    return '收到坐标消息' . '-' . '地理位置纬度' . ':' . $message['Location_X'] . '地理位置经度' . ':' . $message['Location_Y'] . '地图缩放大小' . ':' . $message['Scale'] . '地理位置信息' . ':' . $message['Label'];
                    break;

                case 'link':
                    // 链接：
                    // $message->MsgType      link
                    // $message->Title        消息标题
                    // $message->Description  消息描述
                    // $message->Url          消息链接

                    // 链接消息
                    // 微信目前不支持回复链接消息
                    $description = $message['Description'];
                    return new Text($description);

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
                    break;

                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            return "欢迎关注 田大爷！";
            // 上面 return 了一句普通的文本内容，这里只是为了方便大家，实际上最后会有一个隐式转换为 Text 类型的动作。
        });

        // 某些情况，我们需要直接使用 $message 参数，那么怎么在 push 的闭包外调用呢？
        // $message = $server->getMessage();
        
        /**
         * 基础接口
         */
        // 清理接口调用次数
        // $app->base->clearQuota();

        // 获取微信服务器 IP (或IP段)
        // $app->base->getValidIps();

        /**
         * 通过实例得到类名, 通过类名获得常量名和属性和所有方法
         */
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

        /**
         * 其他消息类型
         */
        // 图文消息
        // 图文消息分为 NewsItem 与 News，NewsItem 为图文内容条目。
        // NewsItem 属性：
        // - title 标题
        // - description 描述
        // - image 图片链接
        // - url 链接 URL
        // use EasyWeChat\Kernel\Messages\News;
        // use EasyWeChat\Kernel\Messages\NewsItem;

        // $items = [
        //     new NewsItem([
        //         'title'       => $title,
        //         'description' => '...',
        //         'url'         => $url,
        //         'image'       => $image,
        //         // ...
        //     ]),
        //     new NewsItem([...]),
        //     new NewsItem([...]),
        //     // ...
        // ];
        // $news = new News($items);

        // 文章
        // 属性列表：
        // - title 标题
        // - author 作者
        // - content 具体内容
        // - thumb_media_id 图文消息的封面图片素材id（必须是永久mediaID）
        // - digest 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空
        // - source_url 来源 URL
        // - show_cover 是否显示封面，0 为 false，即不显示，1 为 true，即显示
        // use EasyWeChat\Kernel\Messages\Article;
        // $article = new Article([
        //         'title'   => 'EasyWeChat',
        //         'author'  => 'overtrue',
        //         'content' => 'EasyWeChat 是一个开源的微信 SDK，它... ...',
        //         // ...
        //     ]);

        // // or
        // $article = new Article();
        // $article->title   = 'EasyWeChat';
        // $article->author  = 'overtrue';
        // $article->content = '微信 SDK ...';

        // 素材消息
        // 素材消息用于群发与客服消息时使用。
        // 属性就一个：media_id。
        // 在构造时有两个参数：
        // $type 素材类型，目前只支持：mpnews、 mpvideo、voice、image 等。
        // $mediaId 素材 ID，从接口查询或者上传后得到。
        // use EasyWeChat\Kernel\Messages\Media;
        // $media = new Media($mediaId, 'mpnews');
        // 以上呢，是所有微信支持的基本消息类型。
        // 需要注意的是，你不需要关心微信的消息字段叫啥，因为这里我们使用了更标准的命名，然后最终在中间做了转换，所以你不需要关注。

        // 原始消息
        // 原始消息是一种特殊的消息，它的场景是：你不想使用其它消息类型，你想自己手动拼消息。比如，回复消息时，你想自己拼 XML，那么你就直接用它就可以了：
        // use EasyWeChat\Kernel\Messages\Raw;
        // $message = new Raw('<xml>
        // <ToUserName><![CDATA[toUser]]></ToUserName>
        // <FromUserName><![CDATA[fromUser]]></FromUserName>
        // <CreateTime>12345678</CreateTime>
        // <MsgType><![CDATA[image]]></MsgType>
        // <Image>
        // <MediaId><![CDATA[media_id]]></MediaId>
        // </Image>
        // </xml>');

        // 比如，你要用于客服消息(客服消息是JSON结构)：

        // use EasyWeChat\Kernel\Messages\Raw;
        // $message = new Raw('{
        //     "touser":"OPENID",
        //     "msgtype":"text",
        //     "text":
        //     {
        //          "content":"Hello World"
        //     }
        // }');
        // 总之，就是直接写微信接口要求的格式内容就好，此类型消息在 SDK 中不存在转换行为，所以请注意不要写错格式。

        /**
         * laravel中使用需要注意的
         */
        // $response = $app->server->serve();
        // $response->send();
        // 我们的 $app->server->serve() 就是执行服务端业务了，那么它的返回值是一个 Symfony\Component\HttpFoundation\Response 实例。
        // 我这里是直接调用了它的 send() 方法，它就是直接输出（echo）了，我们在一些框架就不能直接输出了，那你就直接拿到 Response 实例后做相应的操作即可，比如 Laravel 里你就可以直接 return $app->server->serve();

        return $app->server->serve();
    }

    /**
     * [receiver 开放平台全网发布]
     * @param  [type] $app_id [description]
     * @return [type]         [description]
     */
    public function receiver($app_id)
    {
        $this->app_id = $app_id;

        // $official = $this->initOfficialAccount();
        $openPlatform = $this->openPlatform;
        $server       = $openPlatform->server;

        $server->push(EventHandler::class, Message::EVENT); // 检测中，这个是没什么用的

        $msg = $server->getMessage();
        if ($msg['MsgType'] == 'text') {
            if ($msg['Content'] == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
                $curOfficialAccount = $openPlatform->officialAccount($app_id, Redis::get($app_id));
                $curOfficialAccount->customer_service->message($msg['Content'] . '_callback')
                    ->from($msg['ToUserName'])->to($msg['FromUserName'])->send();
                die;
            } elseif (strpos($msg['Content'], 'QUERY_AUTH_CODE') == 0) {
                echo '';
                $code           = substr($msg['Content'], 16);
                $authorizerInfo = $openPlatform->handleAuthorize($code)['authorization_info'];
                Redis::set(
                    $authorizerInfo['authorizer_appid'],
                    $authorizerInfo['authorizer_refresh_token']
                );
                Redis::expire($authorizerInfo['authorizer_appid'], 20);
                $curOfficialAccount = $openPlatform->officialAccount(
                    $authorizerInfo['authorizer_appid'],
                    $authorizerInfo['authorizer_refresh_token']
                );
                $curOfficialAccount->customer_service->message($code . "_from_api")
                    ->from($msg['ToUserName'])->to($msg['FromUserName'])->send();
            }
        } elseif ($msg['MsgType'] == 'event') {
            $curOfficialAccount = $openPlatform->officialAccount($app_id, Redis::get($app_id));
            $curOfficialAccount->customer_service->message($msg['Event'] . 'from_callback')
                ->to($msg['FromUserName'])->from($msg['ToUserName'])->send();
            die;
        }

        return $openPlatform->server->serve();
    }
}

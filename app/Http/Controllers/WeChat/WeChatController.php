<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Voice;
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
        // 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
        Log::info('request arrived.');

        // 创建公众号服务
        // $app = Factory::officialAccount($config);
        $app = app('wechat.official_account');

        /**
         * 语义理解
         */
        // $result = $app->semantic->query('查一下明天从北京到上海的南航机票', "flight,hotel", array('city' => '北京', 'uid' => '123456'));
        // Log::info('语义理解');
        // Log::info($result);

        /**
         * 自动回复
         */
        // 获取当前设置的回复规则
        // Log::info('获取当前设置的回复规则');
        // Log::info($app->auto_reply->current());

        /**
         * 菜单
         */
        // Log::info('删除菜单');
        // Log::info($app->menu->delete());

        // // 添加普通菜单(需要添加普通菜单后才可以创建个性化菜单)
        // $buttons = [
        //     [
        //         "type" => "click",
        //         "name" => "今日歌曲",
        //         "key"  => "TODAY_MUSIC",
        //     ],
        //     [
        //         "name"       => "菜单",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "搜索",
        //                 "url"  => "http://www.soso.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "视频",
        //                 "url"  => "http://v.qq.com/",
        //             ],
        //             [
        //                 "type" => "click",
        //                 "name" => "赞一下我们",
        //                 "key"  => "ZAN",
        //             ],
        //         ],
        //     ],
        // ];
        // Log::info('添加普通菜单');
        // Log::info($app->menu->create($buttons));

        // // 添加个性化菜单
        // $buttons1 = [
        //     [
        //         "name"       => "招投标",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "全部招标",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "我的投标",
        //                 "url"  => "https://www.baidu.com/",
        //             ]
        //         ]
        //     ],
        //     [
        //         "name"       => "投诉与报修",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "我要投诉",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "发起报修",
        //                 "url"  => "https://www.baidu.com/",
        //             ]
        //         ]
        //     ],
        //     [
        //         "name" => "个人中心",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "账户管理",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "消息与通知",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "缴费管理",
        //                 "url"  => "https://www.baidu.com/",
        //             ]
        //         ]
        //     ]
        // ];
        // $buttons2 = [
        //     [
        //         "name"       => "监督管理",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "临时检查单",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "月度巡检表",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "发起整改",
        //                 "url"  => "https://www.baidu.com/",
        //             ]
        //         ]
        //     ],
        //     [
        //         "name"       => "工单管理",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "报修审核工单",
        //                 "url"  => "https://www.baidu.com/",
        //             ]
        //         ]
        //     ],
        //     [
        //         "name" => "个人中心",
        //         "sub_button" => [
        //             [
        //                 "type" => "view",
        //                 "name" => "账户管理",
        //                 "url"  => "https://www.baidu.com/",
        //             ],
        //             [
        //                 "type" => "view",
        //                 "name" => "消息与通知",
        //                 "url"  => "https://www.baidu.com/",
        //             ]
        //         ]
        //     ]
        // ];
        // $matchRule1 = [
        //     "tag_id" => 102
        // ];
        // $matchRule2 = [
        //     "tag_id" => 103
        // ];
        // Log::info('添加个性化菜单');
        // Log::info($app->menu->create($buttons1, $matchRule1));
        // Log::info($app->menu->create($buttons2, $matchRule2));

        // // 读取（查询）已设置菜单
        // $list = $app->menu->list();
        // Log::info('读取（查询）已设置菜单');
        // Log::info($list);

        // // 获取当前菜单
        // $current = $app->menu->current();
        // Log::info('获取当前菜单');
        // Log::info($current);

        // $app->user_tag->create('商户');// 102
        // $app->user_tag->create('运营商');// 103
        // $tags = $app->user_tag->list();
        // Log::info('标签');
        // Log::info($tags);
        // $openIds = ['oheQ-s2R2SjoSom6oWxLOcnKPGR8'];
        // $app->user_tag->tagUsers($openIds, 102);
        // $openIds = ['oheQ-s0msxrE2LF8BJGLVV5GAFio'];
        // $app->user_tag->tagUsers($openIds, 103);
        // Log::info('102标签下的用户');
        // Log::info($app->user_tag->usersOfTag(102, $nextOpenId = ''));
        // Log::info('103标签下的用户');
        // Log::info($app->user_tag->usersOfTag(103, $nextOpenId = ''));

        // 删除菜单
        // $menu = $app->menu->delete(); // 全部
        // // array (
        // //   'errcode' => 0,
        // //   'errmsg' => 'ok',
        // // )
        // Log::info('删除菜单');
        // Log::info($menu);

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
            // // 获取所有标签
            // $tags = $app->user_tag->list();
            // Log::info('获取所有标签');
            // Log::info($tags);

            // // // 创建标签
            // // $tag = $app->user_tag->create('测试标签1');
            // // $tag = $app->user_tag->create('测试标签2');
            // // Log::info('创建标签-标签信息');
            // // Log::info($tag);

            // // 修改标签信息
            // $tag = $app->user_tag->update(100, '测试标签1');
            // Log::info('修改标签后的标签信息');
            // Log::info($tag);
            // // array (
            // //   'errcode' => 0,
            // //   'errmsg' => 'ok',
            // // )

            // // 删除标签
            // $tag = $app->user_tag->delete(101);
            // Log::info('删除标签');
            // Log::info($tag);
            // // array (
            // //   'errcode' => 0,
            // //   'errmsg' => 'ok',
            // // )

            // // 获取所有标签
            // $tags = $app->user_tag->list();
            // Log::info('获取所有标签');
            // Log::info($tags);
            // // array (
            // //   'tags' =>
            // //   array (
            // //     0 =>
            // //     array (
            // //       'id' => 2,
            // //       'name' => '星标组',
            // //       'count' => 0,
            // //     ),
            // //     1 =>
            // //     array (
            // //       'id' => 100,
            // //       'name' => '测试标签1',
            // //       'count' => 0,
            // //     ),
            // //   ),
            // // )

            // // 获取指定 openid 用户所属的标签
            // $userTags = $app->user_tag->userTags('oheQ-s0msxrE2LF8BJGLVV5GAFio');
            // Log::info('获取指定 openid 用户所属的标签');
            // Log::info($userTags);
            // // array (
            // //   'tagid_list' =>
            // //   array (
            // //   ),
            // // )

            // // 获取标签下用户列表
            // $users = $app->user_tag->usersOfTag(2, $nextOpenId = '');
            // Log::info('获取标签(id:2, name => "星标组")下用户列表');
            // Log::info($users);
            // // array (
            // //   'count' => 0,
            // // )

            // // 批量为用户添加标签
            // $tagId = 100;
            // $openIds = ['oheQ-s0msxrE2LF8BJGLVV5GAFio', 'oheQ-s2R2SjoSom6oWxLOcnKPGR8'];
            // $tags1 = 'tags1';
            // $tags1 = $app->user_tag->tagUsers($openIds, $tagId);
            // Log::info('批量为用户添加标签');
            // Log::info($tags1);
            // // array (
            // //   'errcode' => 0,
            // //   'errmsg' => 'ok',
            // // )

            // // 获取指定 openid 用户所属的标签
            // $userTags = $app->user_tag->userTags('oheQ-s0msxrE2LF8BJGLVV5GAFio');
            // Log::info('获取指定 openid 用户所属的标签');
            // Log::info($userTags);
            // // array (
            // //   'tagid_list' =>
            // //   array (
            // //     0 => 100,
            // //   ),
            // // )

            // $users = $app->user_tag->usersOfTag(100, $nextOpenId = '');
            // Log::info('获取标签(id:100)下用户列表');
            // Log::info($users);
            // // array (
            // //   'count' => 2,
            // //   'data' =>
            // //   array (
            // //     'openid' =>
            // //     array (
            // //       0 => 'oheQ-s0msxrE2LF8BJGLVV5GAFio',
            // //       1 => 'oheQ-s2R2SjoSom6oWxLOcnKPGR8',
            // //     ),
            // //   ),
            // //   'next_openid' => 'oheQ-s2R2SjoSom6oWxLOcnKPGR8',
            // // )

            // // 批量为用户移除标签
            // $tags2 = 'tags2';
            // $tags2 = $app->user_tag->untagUsers($openIds, $tagId);
            // Log::info('批量为用户添加标签');
            // Log::info($tags2);
            // // array (
            // //   'errcode' => 0,
            // //   'errmsg' => 'ok',
            // // )

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

                    // 判断是否为彩票
                    $keywords = explode('+', $content);
                    if ($keywords[0] == '彩票') {
                        if (count($keywords) == 1) {
                            $data = [
                                "超级大乐透:dlt",
                                "双色球:ssq",
                                "福彩3d:fc3d",
                                "排列3:pl3",
                                "排列5:pl5",
                                "七乐彩:qlc",
                                "七星彩:qxc",
                                "六场半全场:zcbqc",
                                "四场进球彩:zcjqc",
                                "浙江11选5 - 高频:zj11x5",
                                "浙江快乐十二 - 高频:zjkl12"
                                // <option value="dlt">超级大乐透</option>
                                // <option value="fc3d">福彩3d</option>
                                // <option value="pl3">排列3</option>
                                // <option value="pl5">排列5</option>
                                // <option value="qlc">七乐彩</option>
                                // <option value="qxc">七星彩</option>
                                // <option value="ssq">双色球</option>
                                // <option value="zcbqc">六场半全场</option>
                                // <option value="zcjqc">四场进球彩</option>
                                // <option value="zcsfc">十四场胜负彩(任9)</option>
                                // <option value="ah11x5">安徽11选5 - 高频</option>
                                // <option value="bj11x5">北京11选5 - 高频</option>
                                // <option value="fj11x5">福建11选5 - 高频</option>
                                // <option value="gd11x5">广东11选5 - 高频</option>
                                // <option value="gs11x5">甘肃11选5 - 高频</option>
                                // <option value="gx11x5">广西11选5 - 高频</option>
                                // <option value="gz11x5">贵州11选5 - 高频</option>
                                // <option value="heb11x5">河北11选5 - 高频</option>
                                // <option value="hlj11x5">黑龙江11选5(幸运) - 高频</option>
                                // <option value="hub11x5">湖北11选5 - 高频</option>
                                // <option value="jl11x5">吉林11选5 - 高频</option>
                                // <option value="js11x5">江苏11选5 - 高频</option>
                                // <option value="jx11x5">江西11选5(多乐彩) - 高频</option>
                                // <option value="ln11x5">辽宁11选5 - 高频</option>
                                // <option value="nmg11x5">内蒙古11选5 - 高频</option>
                                // <option value="sd11x5">山东11选5(十一运夺金) - 高频</option>
                                // <option value="sh11x5">上海11选5 - 高频</option>
                                // <option value="sxl11x5">陕西11选5 - 高频</option>
                                // <option value="sxr11x5">山西11选5 - 高频</option>
                                // <option value="tj11x5">天津11选5 - 高频</option>
                                // <option value="xj11x5">新疆11选5 - 高频</option>
                                // <option value="yn11x5">云南11选5 - 高频</option>
                                // <option value="zj11x5">浙江11选5 - 高频</option>
                                // <option value="ahk3">安徽快三 - 高频</option>
                                // <option value="bjk3">北京快三 - 高频</option>
                                // <option value="fjk3">福建快三 - 高频</option>
                                // <option value="gsk3">甘肃快三 - 高频</option>
                                // <option value="gxk3">广西快三(好运) - 高频</option>
                                // <option value="gzk3">贵州快三 - 高频</option>
                                // <option value="hebk3">河北快三 - 高频</option>
                                // <option value="hubk3">湖北快三 - 高频</option>
                                // <option value="jlk3">吉林快三 - 高频</option>
                                // <option value="jsk3">江苏快三 - 高频</option>
                                // <option value="jxk3">江西快三 - 高频</option>
                                // <option value="nmgk3">内蒙古快三 - 高频</option>
                                // <option value="shk3">上海快三 - 高频</option>
                                // <option value="cqklsf">重庆快乐十分(幸运农场) - 高频</option>
                                // <option value="gdklsf">广东快乐十分 - 高频</option>
                                // <option value="gxklsf">广西快乐十分 - 高频</option>
                                // <option value="hljklsf">黑龙江快乐十分 - 高频</option>
                                // <option value="hunklsf">湖南快乐十分(动物总动员) - 高频</option>
                                // <option value="sxlklsf">陕西快乐十分 - 高频</option>
                                // <option value="sxrklsf">山西快乐十分 - 高频</option>
                                // <option value="tjklsf">天津快乐十分 - 高频</option>
                                // <option value="ynklsf">云南快乐十分 - 高频</option>
                                // <option value="lnkl12">辽宁快乐十二 - 高频</option>
                                // <option value="sckl12">四川快乐十二 - 高频</option>
                                // <option value="zjkl12">浙江快乐十二 - 高频</option>
                                // <option value="cqssc">重庆时时彩 - 高频</option>
                                // <option value="hljssc">黑龙江时时彩 - 高频</option>
                                // <option value="tjssc">天津时时彩 - 高频</option>
                                // <option value="xjssc">新疆时时彩 - 高频</option>
                                // <option value="ynssc">云南时时彩 - 高频</option>
                                // <option value="bjkl8">北京快乐8 - 高频</option>
                                // <option value="bjpk10">北京赛车(pk10) - 高频</option>
                                // <option value="bjkzc">北京快中彩 - 高频</option>
                                // <option value="henytdj">河南泳坛夺金(481) - 高频</option>
                                // <option value="hunxysc">湖南幸运赛车 - 高频</option>
                                // <option value="scjql">四川金七乐 - 高频</option>
                                // <option value="sdklpk3">山东快乐扑克3 - 高频</option>
                                // <option value="sdqyh">山东群英会 - 高频</option>
                                // <option value="shssl">上海时时乐 - 高频</option>
                                // <option value="sxrytdj">山西泳坛夺金(481) - 高频</option>
                                // <option value="xjxlc">新疆喜乐彩 - 高频</option>
                                // <option value="inffc5">印尼时时彩(五分彩) - 高频</option>
                                // <option value="viffc5">越南河内时时彩(快5) - 高频</option>
                                // <option value="aukeno">澳洲快乐8(act) - 高频</option>
                                // <option value="cakeno">加拿大卑斯快乐8 - 高频</option>
                                // <option value="cwkeno">加拿大西部快乐8 - 高频</option>
                                // <option value="twbingo">台湾宾果 - 高频</option>
                                // <option value="mlaft">马耳他幸运飞艇 - 高频</option>
                                // <option value="df6j1">七省东方6+1</option>
                                // <option value="fjtc22x5">福建体彩22选5</option>
                                // <option value="fjtc36x7">福建体彩36选7</option>
                                // <option value="gdfc26x5">广东南粤风采26选5</option>
                                // <option value="gdfc36x5">广东南粤风采36选7</option>
                                // <option value="gdfchc1">广东南粤风采好彩1</option>
                                // <option value="gdszfc">广东深圳风采</option>
                                // <option value="gxklsc">广西快乐双彩</option>
                                // <option value="hd15x5">七省华东15选5</option>
                                // <option value="hljfc22x5">黑龙江龙江风彩22选5</option>
                                // <option value="hljtc6j1">黑龙江体彩6+1</option>
                                // <option value="jstc7ws">江苏体彩7位数</option>
                                // <option value="lnfc35x7">辽宁辽宁风采35选7</option>
                                // <option value="shttcx4">上海天天彩选4</option>
                                // <option value="xjfc18x7">新疆新疆风采18选7</option>
                                // <option value="xjfc25x7">新疆新疆风采25选7</option>
                                // <option value="xjfc35x7">新疆新疆风采35选7</option>
                                // <option value="yzfc20x5">河北燕赵风采20选5</option>
                                // <option value="yzfchyc2">河北燕赵风采好运彩2</option>
                                // <option value="yzfchyc3">河北燕赵风采好运彩3</option>
                                // <option value="yzfcpl5">河北燕赵风采排列5</option>
                                // <option value="yzfcpl7">河北燕赵风采排列7</option>
                                // <option value="zyfc22x5">河南中原风采22选5</option>
                            ];

                            $responseContent = "格式为:彩票+彩票编码+条数; 彩票编码详情请看下方; 条数默认为10, 可以不填; 例如:彩票+ssq+10\n\n";

                            $responseContent .= implode("\n", $data);

                            return new Text($responseContent);
                        }

                        $code = 'dlt';
                        $rows = 10;
                        $format = 'json';

                        // 彩种
                        if (isset($keywords[1]) && !empty($keywords[1])) {
                            $code = $keywords[1];
                        }

                        // 行数
                        if (isset($keywords[2]) && !empty($keywords[2])) {
                            $rows = $keywords[2];
                        }

                        // 官网:http://www.opencai.net/apifree/
                        // 接口地址
                        $url = "http://f.apiplus.net/{$code}-{$rows}.{$format}";
                        // 获取图灵机器人返回的内容
                        $data = file_get_contents($url);
                        // 对内容json解码
                        $data = json_decode($data, true);

                        $responseContent = "";

                        foreach ($data['data'] as $key => $value) {
                            $responseContent .= "<strong>期号:" . $value['expect'] . "<strong>\n";
                            $responseContent .= "开奖号码:" . $value['opencode'] . "\n";
                            $responseContent .= "开奖时间:" . $value['opentime'] . "\n";
                            $responseContent .= "\n";
                        }

                        $responseContent = rtrim($responseContent, "\n");

                        // 文本消息
                        // 属性列表：
                        // - content 文本内容
                        return new Text($responseContent);

                        // $now = date('Y-m-d H:i:s');
                        // $src = 'http://f.apiplus.cn/newly.do?code=cqssc&format=json';
                        // //防止GET本地缓存，增加随机数
                        // $src .= (strpos($src, '?') > 0 ? '&' : '?') . '_=' . time();
                        // $html = file_get_contents($src);
                        // $json = json_decode($html, true);

                        // if (isset($json['rows'])) {
                        //     echo "{$now}共采集到{$json['rows']}行开奖数据：<br/>";
                        //     foreach ($json['data'] as $r) {
                        //         $expect   = preg_replace("/^(\d{8})(\d{3})$/", "\\1-\\2", $r['expect']);
                        //         $opencode = $r['opencode'];
                        //         $opentime = $r['opentime']
                        //         echo "开奖期号：{$expect}<br/>";
                        //         echo "开奖号码：{$opencode}<br/>";
                        //         echo "开奖时间：{$opentime}<br/>";
                        //         echo '<br/>';
                        //         // 分析数据、对比数据，并写入数据库
                        //     }
                        // } else {
                        //     echo "采集失败，返回提示：<br/>";
                        //     echo $html;
                        // }
                    }

                    switch ($content) {
                        case '卡券':
                            /**
                             * 卡券
                             */
                            // 获取实例
                            $card = $app->card;
                            // 获取卡券颜色
                            Log::info('获取卡券颜色');
                            Log::info($card->colors());
                            // 卡券开放类目查询
                            Log::info('卡券开放类目查询');
                            Log::info($card->categories());
                            break;

                        case '客服':
                            /**
                             * 客服
                             */
                            // 添加客服
                            Log::info('添加客服');
                            Log::info($app->customer_service->create('foo@test', '客服1'));
                            // 获取所有客服
                            Log::info('获取所有客服');
                            Log::info($app->customer_service->list());
                            // 获取所有在线的客服
                            Log::info('获取所有在线的客服');
                            Log::info($app->customer_service->online());
                            break;

                        case '菜单':
                            // 添加普通菜单(需要添加普通菜单后才可以创建个性化菜单)
                            $buttons = [
                                [
                                    "type" => "view",
                                    "name" => "商城",
                                    "url"  => "http://www.tianwangchong.com/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile",
                                ],
                                [
                                    "name"       => "菜单",
                                    "sub_button" => [
                                        [
                                            "type" => "view",
                                            "name" => "Ip",
                                            "url"  => "http://ip.tianwangchong.com",
                                        ],
                                        [
                                            "type" => "view",
                                            "name" => "博客",
                                            "url"  => "http://blog.tianwangchong.com/",
                                        ],
                                    ],
                                ],
                            ];

                            // 读取（查询）已设置菜单
                            $list = $app->menu->list();
                            Log::info('读取（查询）已设置菜单');
                            Log::info($list);

                            // 获取当前菜单
                            $current = $app->menu->current();
                            Log::info('获取当前菜单');
                            Log::info($current);

                            Log::info('删除菜单');
                            Log::info($app->menu->delete());

                            // 设置新的菜单
                            Log::info('添加普通菜单');
                            Log::info($app->menu->create($buttons));
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
                            $app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。", 102); // $tagId 必须是整型数字

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
                        'title'          => '标题',
                        'description'    => '描述',
                        'thumb_media_id' => $message['ThumbMediaId'],
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

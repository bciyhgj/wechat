<?php

namespace App\Classes;

class Alimama
{
    // 保存cookie的文件
    private $cookieFile;

    // myIp
    private $myIp = "127.0.0.1";

    public function __construct()
    {
        $this->cookieFile = public_path('cookies.txt');
        // self.se = requests.session()
        // self.load_cookies()
        // self.myip = "127.0.0.1"
        // self.start_keep_cookie_thread()
    }

    /**
     * [startKeepCookieThread 保持cookie]
     * @return [type] [description]
     */
    public function startKeepCookieThread()
    {
        // # 启动一个线程，定时访问淘宝联盟主页，防止cookie失效
        //     t = Thread(target=self.visit_main_url, args=())
        //     t.setDaemon(True)
        //     t.start()
    }

    public function visitMainUrl()
    {
        //     url = "https://pub.alimama.com/"
        //     headers = {
        //         'method': 'GET',
        //         'authority': 'pub.alimama.com',
        //         'scheme': 'https',
        //         'path': '/common/getUnionPubContextInfo.json',
        //         'Accept': 'application/json, text/javascript, */*; q=0.01',
        //         'X-Requested-With': 'XMLHttpRequest',
        //         'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
        //         'Referer': 'http://pub.alimama.com/',
        //         'Accept-Encoding': 'gzip, deflate, sdch',
        //         'Accept-Language': 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        //     }
        //     while True:
        //         time.sleep(60 * 5)
        //         try:
        //             self.logger.debug(
        //                 "visit_main_url......,time:{}".format(time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())))
        //             self.get_url(url, headers)
        //             self.logger.debug(self.check_login())
        //             real_url = "https://detail.tmall.com/item.htm?id=42485910384"
        //             res = self.get_detail(real_url)
        //             auctionid = res['auctionId']
        //             self.logger.debug(self.get_tk_link(auctionid))
        //         except Exception as e:
        //             trace = traceback.format_exc()
        //             self.logger.warning("error:{},trace:{}".format(str(e), trace))
    }

    public function loadCookies()
    {
        // if(file_exists($file)) {
        //     echo "当前目录中，文件".$file."存在";
        // } else {
        //      echo "当前目录中，文件".$file."不存在";
        // }

        // if os.path.isfile(cookie_fname):
        //     with open(cookie_fname, 'r') as f:
        //         c_str = f.read().strip()
        //         self.set_cookies(c_str)
    }

    // def set_cookies(self, c_str):
    //     try:
    //         cookies = json.loads(c_str)
    //     except:
    //         return
    //     for c in cookies:
    //         self.se.cookies.set(c[0], c[1])

    /**
     * [checkLogin 检查是否登录]
     * @return [type] [description]
     */
    public function checkLogin()
    {
        /**
         * 打印日志
         */
        echo 'checking login status.....';
        echo "\r\n";

        $url = 'https://pub.alimama.com/common/getUnionPubContextInfo.json';
        $headers = [
            'method' => 'GET',
            'authority' => 'pub.alimama.com',
            'scheme' => 'https',
            'path' => '/common/getUnionPubContextInfo.json',
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'Referer' => 'http://pub.alimama.com/',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];
        $res = curl_get_https($url, $headers);
        $result = json_decode($res, true);
        return $result;
    }

    /**
     * [visitLoginRedirectUrl 访问登录重定向url]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function visitLoginRedirectUrl($url)
    {
        /**
         * 打印日志, 第一次将cookie写入到文件
         */
        echo "visitLoginRedirectUrl:";
        echo $url;
        echo "\r\n";

        $headers = [
            'method' => 'GET',
            'authority' => 'login.taobao.com',
            'scheme' => 'https',
            // 'path' => '/member/loginByIm.do?%s' % url.split('loginByIm.do?')[-1],
            'path' => sprintf("/member/loginByIm.do?%s", explode('loginByIm.do?', $url)[1]),
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'Referer' => 'http://pub.alimama.com/',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];
        $res = curl_get_https($url, $headers, $this->cookieFile);
    }

    /**
     * [getScanQrStatus 获得扫码状态]
     * @param  [type] $loginToken [description]
     * @return [type]             [description]
     */
    public function getScanQrStatus($loginToken)
    {
        $defaultUrl = 'http://login.taobao.com/member/taobaoke/login.htm?is_login=1';
        $url = sprintf("https://qrlogin.taobao.com/qrcodelogin/qrcodeLoginCheck.do?lgToken=%s&defaulturl=%s&_ksTS=%s_30&callback=jsonp31", $loginToken, $defaultUrl, get_millisecond());

        /**
         * 打印日志
         */
        // echo "getScanQrStatus:";
        // echo $url;
        // echo "\r\n";

        $headers = [
            'method' => 'GET',
            'authority' => 'qrlogin.taobao.com',
            'scheme' => 'https',
            'path' => sprintf("/qrcodelogin/qrcodeLoginCheck.do?%s", explode('qrcodeLoginCheck.do?', $url)[1]),
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'accept' => '*/*',
            'referer' => 'https://login.taobao.com/member/login.jhtml?style=mini&newMini2=true&from=alimama&redirectURL=http%3A%2F%2Flogin.taobao.com%2Fmember%2Ftaobaoke%2Flogin.htm%3Fis_login%3d1&full_redirect=true&disableQuickLogin=true',
            'accept-encoding' => 'gzip, deflate, sdch, br',
            'accept-language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];

        $res = curl_get_https($url, $headers);
        $res = str_replace('(function(){jsonp31(', '', $res);
        $res = str_replace(');})();', '', $res);
        $result = json_decode($res, true);

        return $result;
    }

    /**
     * [showQrImage 登录的二维码]
     * @return [type] [description]
     */
    public function showQrImage()
    {
        $url = sprintf("https://qrlogin.taobao.com/qrcodelogin/generateQRCode4Login.do?from=alimama&_ksTS=%s_30&callback=jsonp31", get_millisecond());

        /**
         * 打印日志
         */
        echo "showQrImage:";
        echo $url;
        echo "\r\n";

        // get qr image
        $headers = [
            'method' => 'GET',
            'authority' => 'qrlogin.taobao.com',
            'scheme' => 'https',
            'path' => sprintf("/qrcodelogin/generateQRCode4Login.do?%s", explode('generateQRCode4Login.do?', $url)[1]),
            // 'path': '/qrcodelogin/generateQRCode4Login.do?%s' % url.split('generateQRCode4Login.do?')[-1],
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'accept' => '*/*',
            'referer' => 'https://login.taobao.com/member/login.jhtml?style=mini&newMini2=true&from=alimama&redirectURL=http%3A%2F%2Flogin.taobao.com%2Fmember%2Ftaobaoke%2Flogin.htm%3Fis_login%3d1&full_redirect=true&disableQuickLogin=true',
            'accept-encoding' => 'gzip, deflate, sdch, br',
            'accept-language' => 'zh-CN,zh;q=0.8',
        ];

        $res = curl_get_https($url, $headers);
        $res = str_replace('(function(){jsonp31(', '', $res);
        $res = str_replace(');})();', '', $res);
        $result = json_decode($res, true);

        echo "showQrImage-result:";
        var_dump($result);
        echo "\r\n";

        // 获得token和图片
        $loginToken = $result['lgToken'];
        $url = sprintf("https:%s", $result['url']);

        $headers = [
            'method' => 'GET',
            'authority' => 'img.alicdn.com',
            'scheme' => 'https',
            'path' => sprintf('/tfscom/%s', explode('tfscom/', $url)[1]),
            // 'path' => '/tfscom/%s' % url.split('tfscom/')[-1],
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'accept' => 'image/webp,image/*,*/*;q=0.8',
            'referer' => 'https://login.taobao.com/member/login.jhtml?style=mini&newMini2=true&from=alimama&redirectURL=http%3A%2F%2Flogin.taobao.com%2Fmember%2Ftaobaoke%2Flogin.htm%3Fis_login%3d1&full_redirect=true&disableQuickLogin=true',
            'accept-encoding' => 'gzip, deflate, sdch, br',
            'accept-language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];

        $res = curl_get_https($url, $headers);
        file_put_contents(public_path("/temp.png"), $res);
        asciify_image(public_path("/temp.png"), 3, false, 0, false, false, "high", null);

        /**
         * 打印日志
         */
        echo "请使用淘宝客户端扫码-please use taobao application sacn";
        echo "\r\n";

        return $loginToken;
    }

    /**
     * [doLogin 登录]
     * @return [type] [description]
     */
    public function doLogin()
    {
        // show qr image
        $loginToken = $this->showQrImage();
        $time = get_millisecond();
        while (true) {
            $result = $this->getScanQrStatus($loginToken);
            // 扫码成功会有跳转, 判断key存不存在还可以使用array_key_exists($key, $array)
            if (isset($result['url'])) {
                $this->visitLoginRedirectUrl($result['url']);

                /**
                 * 打印日志
                 */
                echo 'login success';
                echo "\r\n";

                // self.logger.debug(self.se.cookies.items())
                // with open(cookie_fname, 'w') as f:
                //     f.write(json.dumps(self.se.cookies.items()))

                return 'login success';
            }
            // 二维码过一段时间会失效
            if ((get_millisecond() - $time) > 60 * 5 * 1000) {
                /**
                 * 打印日志
                 */
                echo 'scan timeout';
                echo "\r\n";
                return false;
            }
            sleep(0.5);
        }
    }

    /**
     * [login 登录]
     * @return [type] [description]
     */
    public function login()
    {
        try {
            $result = $this->checkLogin();
            $this->myIp = $result['data']['ip'];
            if (isset($result['data']['mmNick'])) {
                /**
                 * 打印日志
                 */
                echo "淘宝已经登录 不需要再次登录";
                echo "\r\n";
                return 'login success';
            } else {
                $rersult = $this->doLogin();
                if ($rersult) {
                    return 'login success';
                } else {
                    return 'login failed';
                }
            }
        } catch (Exception $e) {
            print $e->getMessage();
            return 'login failed';
            exit();
        }
    }

    /**
     * [checkIfIsTbLink 判断是否为淘宝链接]
     * @param  [type] $msg [description]
     * @return [type]      [description]
     */
    public function checkIfIsTbLink($msg)
    {
        // echo '收到的消息:';
        // echo $msg;
        // preg_match('【.*】', $msg);
        // var_dump(preg_match("/【.*】/u", $msg, $match));
        // var_dump($match);
        // var_dump(preg_match("/€.*?€/", $msg, $match));
        // var_dump($match);
        // var_dump(preg_match("/http:\/\/.* \)/", $msg, $match));
        // var_dump($match);
        // $url = str_replace(' )', '', $match[0]);
        // echo $url;

        // $taokoulingUrl = 'http://www.taokouling.com/index.php?m=api&a=taokoulingjm';
        // $taokouling = '';
        // if (preg_match("/€.*?€/", $msg, $match)) {
        //     $taokouling = $match[0];
        // } else {
        //     preg_match("/￥.*?￥/", $msg, $match);
        //     $taokouling = $match[0];
        // }

        // $parms = ['username' => 'tianmac', 'password' => 'tkltianmac', 'text' => $taokouling];
        // // $postdata = http_build_query($parms);
        // $result = curl_post_https($taokoulingUrl, null, $parms);
        // $result = json_decode($result, true);
        // $url = str_replace('https://', 'http://', $result['url']);
        // // dd(explode('/', explode('http://', $url)[1]));
        // dd($url);
        // dd($result);

        if (preg_match("/【.*】/u", $msg, $match) && (strstr($msg, "打开👉手机淘宝👈") || strstr($msg, "打开👉天猫APP👈") || strstr($msg, "打开👉手淘👈") || strstr($msg, "👉淘♂寳♀👈"))) {
            try {
                $url = '';
                $content = '';
                $content = str_replace('【', '', $match[0]);
                $content = str_replace('】', '', $content);
                if (strstr($msg, "打开👉天猫APP👈")) {
                    if (preg_match("/http:\/\/.* \)/", $msg, $match)) {
                        $url = str_replace(' )', '', $match[0]);
                    }
                } else {
                    if (preg_match("/http:\/\/.* /", $msg, $match)) {
                        $url = str_replace(' ', '', $match[0]);
                    }
                }

                // 20170909新版淘宝分享中没有链接， 感谢网友jindx0713（https://github.com/jindx0713）提供代码和思路，现在使用第三方网站 http://www.taokouling.com 根据淘口令获取url
                if (!$url) {
                    $taokoulingUrl = 'http://www.taokouling.com/index.php?m=api&a=taokoulingjm';
                    $taokouling = '';
                    if (preg_match("/€.*?€/", $msg, $match)) {
                        $taokouling = $match[0];
                    } else {
                        preg_match("/￥.*?￥/", $msg, $match);
                        $taokouling = $match[0];
                    }
                    $parms = ['username' => 'wx_tb_fanli', 'password' => 'wx_tb_fanli', 'text' => $taokouling];
                    $result = curl_post_https($taokoulingUrl, null, $parms);
                    $result = json_decode($result, true);
                    if (isset($result['url'])) {
                        $url = str_replace('https://', 'http://', $result['url']);
                    }
                }
            } catch (Exception $e) {

            }
        }
    }

    /**
     * 获取商品详情
     * @param  [type] $q [description]
     * @return [type]    [description]
     */
    public function getDetail($q)
    {
        try {
            $t = get_millisecond();

            $tbToken = '';
            // 将整个文件内容读入到一个字符串中, 读取cookie文件
            $str = file_get_contents($this->cookieFile);
            // 转换字符集（编码）
            $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
            // 转换成数组
            $arr = explode("\r\n", $str_encoding);
            // 去除值中的空格
            foreach ($arr as &$row) {
                $row = trim($row);
                $tempArr = explode("\t", $row);
                if (in_array('_tb_token_', $tempArr)) {
                    $tbToken = $tempArr[6];
                    break;
                }
            }
            unset($row);
            // $myfile = fopen($this->cookieFile, "r") or die("Unable to open file!");
            // echo fread($myfile, filesize($this->cookieFile));
            // fclose($myfile);

            $pvid = sprintf('10_%s_1686_%s', $this->myIp, $t);
            $url = sprintf('http://pub.alimama.com/items/search.json?q=%s&_t=%s&auctionTag=&perPageSize=40&shopTag=&t=%s&_tb_token_=%s&pvid=%s', urlencode(utf8_encode($q)), $t, $t, $tbToken, $pvid);
            $headers = [
                'method' => 'GET',
                'authority' => 'pub.alimama.com',
                'scheme' => 'https',
                // 'path' => '/items/search.json?%s' % url.split('search.json?')[-1],
                'path' => sprintf("/items/search.json?%s", explode('search.json?', $url)[1]),
                'accept' => 'application/json, text/javascript, */*; q=0.01',
                'x-requested-with' => 'XMLHttpRequest',
                'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
                'referer' => 'https://pub.alimama.com',
                'accept-encoding' => 'gzip, deflate, sdch, br',
                'accept-language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
            ];
            $result = curl_get_https($url, $headers);
            $result = json_decode($result, true);

            /**
             * 打印日志
             */
            echo "getDetail url:";
            echo $url;
            echo "get_detail:";
            echo "\r\n";
            var_dump($result);
            echo "\r\n";

            if (isset($result['data']) && isset($result['data']['pageList']) && count($result['data']['pageList']) > 0) {
                return $result['data']['pageList'][0];
            } else {
                return 'no match item';
            }
        } catch (Exception $e) {
            print $e->getMessage();
            return 'no match item';
            exit();
        }
    }

    /**
     * [getRealUrl 获得真实链接]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function getRealUrl($url)
    {
        try {
            $host = explode('http://', $url);
            $host = explode('/', $host[1]);

            $headers = [
                'Host' => $host[0],
                'Upgrade-Insecure-Requests'=> '1',
                'User-Agent'=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, sdch',
                'Accept-Language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
            ];
            $result = curl_get_http($url, $headers);

            /**
             * 打印日志, 商品页面的html
             */
            // var_dump($result);
            // echo "\r\n\r\n\r\n";

            $realUrl = $url;
            if (preg_match("/itemId\":\d+/", $result, $match)) {
                $itemId = str_replace('itemId":', '', $match[0]);
                $realUrl = sprintf("https://detail.tmall.com/item.htm?id=%s", $itemId);
                var_dump($match);
            } else if (preg_match("/var url = '.*';/", $result, $match)) {
                $realUrl = str_replace("var url = '", "", $match[0]);
                $realUrl = str_replace("';", "", $realUrl);
                $realUrl = str_replace('https://', 'http://', $realUrl);
            }

            // // 如果是s.click.taobao.com开头的链接, 暂未做处理
            // if (strstr('s.click.taobao.com', $realUrl)) {
            //     // r_url = self.handle_click_type_url(r_url)
            // } else {
            //     // while ('detail.tmall.com' not in r_url) and ('item.taobao.com' not in r_url) and (
            //     //             'detail.m.tmall.com' not in r_url):
            //     //     headers1 = {
            //     //         'Host': r_url.split('http://')[-1].split('/')[0],
            //     //         'Upgrade-Insecure-Requests': '1',
            //     //         'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            //     //         'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            //     //         'Accept-Encoding': 'gzip, deflate, sdch',
            //     //         'Accept-Language': 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
            //     //     }
            //     //     res2 = self.get_url(r_url, headers1)
            //     //     self.logger.debug("{},{},{}".format(res2.url, res2.status_code, res2.history))
            //     //     r_url = res2.url
            //     //     self.logger.debug(r_url)
            // }

            return $realUrl;
        } catch (Exception $e) {
            print $e->getMessage();
            return $url;
        }
    }

    /**
     * [getTkLink 获取淘宝客链接]
     * @param  [type] $auctionId [description]
     * @return [type]            [description]
     */
    public function getTkLink($auctionId)
    {
        $t = get_millisecond();

        $tbToken = '';
        // 将整个文件内容读入到一个字符串中
        $str = file_get_contents($this->cookieFile);
        // 转换字符集（编码）
        $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
        // 转换成数组
        $arr = explode("\r\n", $str_encoding);
        // 去除值中的空格
        foreach ($arr as &$row) {
            $row = trim($row);
            $tempArr = explode("\t", $row);
            if (in_array('_tb_token_', $tempArr)) {
                $tbToken = $tempArr[6];
                break;
            }
        }
        unset($row);

        $pvid = sprintf('10_%s_1686_%s', $this->myIp, $t);

        echo "getTkLink:";
        echo implode(",", [$auctionId, $tbToken, $pvid]);
        echo "\r\n";

        try {
            list($gcId, $siteId, $adzoneId) = $this->__get_tk_link_s1($auctionId, $tbToken, $pvid);
            $this->__get_tk_link_s2($gcId, $siteId, $adzoneId, $auctionId, $tbToken, $pvid);
            $result = $this->__get_tk_link_s3($auctionId, $adzoneId, $siteId, $tbToken, $pvid);
            return $result;
        } catch (Exception $e) {
            print $e->getMessage();
            return 'error getTkLink';
            exit();
        }
    }

    /**
     * [__get_tk_link_s1 第一步，获取推广位相关信息]
     * @param  [type] $auctionId [description]
     * @param  [type] $tbToken   [description]
     * @param  [type] $pvid      [description]
     * @return [type]            [description]
     */
    public function __get_tk_link_s1($auctionId, $tbToken, $pvid)
    {
        $url = sprintf('http://pub.alimama.com/common/adzone/newSelfAdzone2.json?tag=29&itemId=%s&blockId=&t=%s&_tb_token_=%s&pvid=%s', $auctionId, get_millisecond(), $tbToken, $pvid);
        $headers = [
            'Host' => 'pub.alimama.com',
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'Referer' => 'http://pub.alimama.com/promo/search/index.htm',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];
        $result = curl_get_https($url, $headers);

        /**
         * 打印日志
         */
        echo "__get_tk_link_s1 url:";
        echo $url;
        echo "\r\n";

        echo 'tg获取推广位相关信息:';
        var_dump($result);
        echo "\r\n";

        $result = json_decode($result, true);

        if (isset($result['data']) && isset($result['data']['otherList']) && count($result['data']['otherList']) > 0) {
            $gcId = $result['data']['otherList'][0]['gcid'];
            $siteId = $result['data']['otherList'][0]['siteid'];
            $adzoneId = $result['data']['otherAdzones'][0]['sub'][0]['id'];
        }
        # gcid = rj['data']['otherList'][0]['gcid']
        # siteid = rj['data']['otherList'][0]['siteid']
        # adzoneid = rj['data']['otherAdzones'][0]['sub'][0]['id']

        $gcId  = 0;
        $siteId = 45984637;
        $adzoneId = 736208381;
        return [$gcId, $siteId, $adzoneId];
    }

    /**
     * [__get_tk_link_s2 post数据]
     * @param  [type] $gcId      [description]
     * @param  [type] $siteId    [description]
     * @param  [type] $adzoneId  [description]
     * @param  [type] $auctionId [description]
     * @param  [type] $tbToken   [description]
     * @param  [type] $pvid      [description]
     * @return [type]            [description]
     */
    public function __get_tk_link_s2($gcId, $siteId, $adzoneId, $auctionId, $tbToken, $pvid)
    {
        $url = 'http://pub.alimama.com/common/adzone/selfAdzoneCreate.json';
        $data = [
            'tag' => '29',
            'gcid' => $gcId,
            'siteid' => $siteId,
            'selectact' => 'sel',
            'adzoneid' => $adzoneId,
            't' => get_millisecond(),
            '_tb_token_' => $tbToken,
            'pvid' => $pvid,
        ];
        $headers = [
            'Host' => 'pub.alimama.com',
            // 'Content-Length' => str(len(json.dumps(data))),
            'Content-Length' => strlen(json_encode($data)),
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'Origin' => 'http://pub.alimama.com',
            'X-Requested-With' => 'XMLHttpRequest',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Referer' => 'http://pub.alimama.com/promo/search/index.htm',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];

        $result = curl_post_https($url, $headers, $data);

        /**
         * 打印日志
         */
        echo "__get_tk_link_s2 result:";
        var_dump($result);
        echo "\r\n";

        $result = json_decode($result);
        return $result;
    }

    /**
     * [__get_tk_link_s3 获取口令]
     * @param  [type] $auctionId [description]
     * @param  [type] $adzoneId  [description]
     * @param  [type] $siteId    [description]
     * @param  [type] $tbToken   [description]
     * @param  [type] $pvid      [description]
     * @return [type]            [description]
     */
    public function __get_tk_link_s3($auctionId, $adzoneId, $siteId, $tbToken, $pvid)
    {
        $url = sprintf('http://pub.alimama.com/common/code/getAuctionCode.json?auctionid=%s&adzoneid=%s&siteid=%s&scenes=1&t=%s&_tb_token_=%s&pvid=%s', $auctionId, $adzoneId, $siteId, get_millisecond(), $tbToken, $pvid);
        $headers = [
            'Host' => 'pub.alimama.com',
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
            'Referer' => 'http://pub.alimama.com/promo/search/index.htm',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
        ];
        $result = curl_get_https($url, $headers);

        /**
         * 打印日志
         */
        echo "__get_tk_link_s3 result:";
        var_dump($result);
        echo "\r\n";

        $result = json_decode($result, true);
        if (isset($result['data'])) {
            return $result['data'];
        } else {
            return 'error __get_tk_link_s3';
        }
    }

    // def handle_click_type_url(self, url):
    //     # step 1
    //     headers = {
    //         'method': 'GET',
    //         'authority': 's.click.taobao.com',
    //         'scheme': 'https',
    //         'path': '/t?%s' % url.split('/t?')[-1],
    //         'Upgrade-Insecure-Requests': '1',
    //         'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
    //         'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    //         'Accept-Encoding': 'gzip, deflate, sdch',
    //         'Accept-Language': 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
    //     }
    //     res = self.get_url(url, headers)
    //     self.logger.debug("{},{},{}".format(res.url, res.status_code, res.history))
    //     url2 = res.url

    //     # step 2
    //     headers2 = {
    //         'referer': url,
    //         'method': 'GET',
    //         'authority': 's.click.taobao.com',
    //         'scheme': 'https',
    //         'path': '/t?%s' % url2.split('/t?')[-1],
    //         'Upgrade-Insecure-Requests': '1',
    //         'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
    //         'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    //         'Accept-Encoding': 'gzip, deflate, sdch',
    //         'Accept-Language': 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
    //     }
    //     res2 = self.get_url(url2, headers2)
    //     self.logger.debug("{},{},{}".format(res2.url, res2.status_code, res2.history))
    //     url3 = urllib.unquote(res2.url.split('t_js?tu=')[-1])

    //     # step 3
    //     headers3 = {
    //         'referer': url2,
    //         'method': 'GET',
    //         'authority': 's.click.taobao.com',
    //         'scheme': 'https',
    //         'path': '/t?%s' % url3.split('/t?')[-1],
    //         'Upgrade-Insecure-Requests': '1',
    //         'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
    //         'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    //         'Accept-Encoding': 'gzip, deflate, sdch',
    //         'Accept-Language': 'zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2',
    //     }
    //     res3 = self.get_url(url3, headers3)
    //     self.logger.debug("{},{},{}".format(res3.url, res3.status_code, res3.history))
    //     r_url = res3.url

    //     return r_url
}


// // $alimama = new Alimama();

// // // 登录
// // $alimama->login();

// // // 判断是不是为淘宝链接
// // $msg = '';
// // $taokoulingUrl = 'http://www.taokouling.com/index.php?m=api&a=taokoulingjm';
// // $taokouling = '';
// // if (preg_match("/€.*?€/", $msg, $match)) {
// //     $taokouling = $match[0];
// // } else {
// //     preg_match("/￥.*?￥/", $msg, $match);
// //     $taokouling = $match[0];
// // }

// // $parms = ['username' => 'tianmac', 'password' => 'tkltianmac', 'text' => $taokouling];
// // // $postdata = http_build_query($parms);
// // $result = curl_post_https($taokoulingUrl, $parms);
// // $result = json_decode($result, true);
// // $url = str_replace('https://', 'http://', $result['url']);

// // if (preg_match("/【.*】/u", $msg, $match) && (strstr($msg, "打开👉手机淘宝👈") || strstr($msg, "打开👉天猫APP👈") || strstr($msg, "打开👉手淘👈") || strstr($msg, "👉淘♂寳♀👈"))) {
// //     try {
// //         $url = '';
// //         $content = '';
// //         $content = str_replace('【', '', $match[0]);
// //         $content = str_replace('】', '', $content);
// //         if (strstr($msg, "打开👉天猫APP👈")) {
// //             if (preg_match("/http:\/\/.* \)/", $msg, $match)) {
// //                 $url = str_replace(' )', '', $match[0]);
// //             }
// //         } else {
// //             if (preg_match("/http:\/\/.* /", $msg, $match)) {
// //                 $url = str_replace(' ', '', $match[0]);
// //             }
// //         }

// //         // 20170909新版淘宝分享中没有链接， 感谢网友jindx0713（https://github.com/jindx0713）提供代码和思路，现在使用第三方网站 http://www.taokouling.com 根据淘口令获取url
// //         if (!$url) {
// //             $taokoulingUrl = 'http://www.taokouling.com/index.php?m=api&a=taokoulingjm';
// //             $taokouling = '';
// //             if (preg_match("/€.*?€/", $msg, $match)) {
// //                 $taokouling = $match[0];
// //             } else {
// //                 preg_match("/￥.*?￥/", $msg, $match);
// //                 $taokouling = $match[0];
// //             }
// //             $parms = ['username' => 'wx_tb_fanli', 'password' => 'wx_tb_fanli', 'text' => $taokouling];
// //             $result = curl_post_https($taokoulingUrl, $parms);
// //             $result = json_decode($result, true);
// //             if (isset($result['url'])) {
// //                 $url = str_replace('https://', 'http://', $result['url']);
// //             }
// //         }
// //     } catch (Exception $e) {

// //     }
// // }


// // // 获得真实链接
// // $realUrl = $alimama->getRealUrl($url);

// // // echo "\r\n";
// // // echo "realUrl:";
// // // echo "\r\n";
// // // echo $realUrl;
// // // echo "\r\n";

// // // 获得详情
// // $detail = $alimama->getDetail($realUrl);

// // echo "detail:";
// // var_dump($detail);

// $result = [];
// // 优惠券链接
// $couponLink = '';
// $detail = '';

// // if ($detail != 'no match item') {
// //     $auctionId = $detail['auctionId'];
// //     $couponAmount = $detail['couponAmount'];
// //     $tkRate = $detail['tkRate'];
// //     $price = $detail['zkPrice'];
// //     $fx = ($price - $couponAmount) * $tkRate / 100;

// //     // 获得淘宝客链接
// //     $result = $alimama->getTkLink($auctionId);
// //     $taoToken = $result['taoToken'];
// //     $shortLink = $result['shortLinkUrl'];
// //     $couponLink = $result['couponLink'];
// // }

// // $content = 'contentcontentcontentcontentcontent';
// // $couponLink = '';
// // $fx = '20.5';
// // $couponAmount = 'couponAmountcouponAmountcouponAmount';
// // $taoToken = 'taoTokentaoTokentaoTokentaoToken';
// // $shortLink = 'shortLinkshortLinkshortLink';

// if ($couponLink != '') {
//     $couponToken = $result['couponLinkTaoToken'];
//     $responseText = <<<EOT
// %s
// 【返现】%.2f
// 【优惠券】%s元
// 请复制%s淘口令、打开淘宝APP下单
// -----------------
// 【下单地址】%s
// EOT;
//     $responseText = sprintf($responseText, $content, $fx, $couponAmount, $couponToken, $shortLink);
//     echo $responseText;

// } else {
//     $responseText = <<<EOT
// %s
// 【返现】%.2f元
// 【优惠券】%s元
// 请复制%s淘口令、打开淘宝APP下单
// -----------------
// 【下单地址】%s
// EOT;
//     $responseText = sprintf($responseText, $content, $fx, $couponAmount, $taoToken, $shortLink);
//     echo $responseText;
// }
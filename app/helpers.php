<?php

if (!function_exists('get_millisecond')) {
    /**
     * [get_millisecond 获得带毫秒的时间戳]
     * @return [type] [description]
     */
    function get_millisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        // $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $msectime =  floor((floatval($msec) + floatval($sec)) * 1000);
        return $msectime;
    }
}

if (!function_exists('curl_get_https')) {
    /**
     * [curl_get_https 发送get请求]
     * @param  [type] $url     [description]
     * @param  [type] $headers [description]
     * @return [type]          [description]
     */
    function curl_get_https($url, $headers = null, $cookieJar = null, $cookieFile = null)
    {
        // 启动一个CURL会话
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        // 设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // http头
        if ($headers) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        // 设置Cookie信息保存在指定的文件中
        if ($cookieJar) {
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieJar);
        }

        // 使用获取的cookies
        if ($cookieFile) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        }

        // var_dump($url);
        // var_dump($headers);
        // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // 从证书中检查SSL加密算法是否存在
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        // 官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看
        $info = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        $errno = curl_errno($curl);

        /**
         * 打印日志
         */
        if ($errno) {
            // 捕抓异常
            echo 'Errno' . $errno;
            var_dump($info);
        }

        // 执行命令
        $tmpInfo = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;
    }
}

if (!function_exists('curl_get_http')) {
    /**
     * [curl_get_http 发送get请求, 解决301问题]
     * @param  [type] $url     [description]
     * @param  [type] $headers [description]
     * @return [type]          [description]
     */
    function curl_get_http($url, $headers = null, $cookieJar = null, $cookieFile = null)
    {
        // 启动一个CURL会话
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        // 设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // http头
        if ($headers) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        // 设置Cookie信息保存在指定的文件中
        if ($cookieJar) {
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieJar);
        }

        // 使用获取的cookies
        if ($cookieFile) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        }

        // var_dump($url);
        // var_dump($headers);
        // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // 让curl递归的抓取http头中Location中指明的url。当抓取次数超过CURLOPT_MAXREDIRS时，递归将终止。
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        // 从证书中检查SSL加密算法是否存在
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        // 官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看
        $info = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        $errno = curl_errno($curl);

        /**
         * 打印日志
         */
        if ($errno) {
            // 捕抓异常
            echo 'Errno' . $errno;
            var_dump($info);
        }

        // 执行命令
        $tmpInfo = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;
    }
}

if (!function_exists('curl_post_https')) {
    /**
     * [curl_post_https 发送post请求]
     * @param  [type] $url  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function curl_post_https($url, $headers = null, $data)
    {
        // curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        // 启动一个CURL会话
        $curl = curl_init();
        // 要访问的地址
        curl_setopt($curl, CURLOPT_URL, $url);
        // 对认证证书来源的检查
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        // 从证书中检查SSL加密算法是否存在
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
        // 模拟用户使用的浏览器
        // curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        // 使用自动跳转
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        // 自动设置Referer
        // curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POST, 1);

        // http头
        if ($headers) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        // Post提交的数据包
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 获取的信息以文件流的形式返回, 要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 执行操作
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
            // 捕抓异常
            echo 'Errno'.curl_error($curl);
            $info = curl_getinfo($curl, CURLINFO_HEADER_OUT);
            var_dump($info);
        }
        // 关闭CURL会话
        curl_close($curl);
        return $tmpInfo;
    }
}

if (!function_exists('asciify_image')) {
    /**
     * [asciify_image 图片转字符输出]
     * @param  [type] $img             [description]
     * @param  [type] $asciiscale      [description]
     * @param  [type] $asciicolor      [description]
     * @param  [type] $asciialpha      [description]
     * @param  [type] $asciiblock      [description]
     * @param  [type] $asciiinvert     [description]
     * @param  [type] $asciiresolution [description]
     * @param  [type] $asciichars      [description]
     * @return [type]                  [description]
     */
    function asciify_image($img, $asciiscale, $asciicolor, $asciialpha, $asciiblock, $asciiinvert, $asciiresolution, $asciichars){
        $strChars = "";
        $strFont = "courier new";
        $aDefaultCharList = str_split(" .,:;i1tfLCG08@");
        $aDefaultColorCharList = str_split(" CGO08@");
        $iScale = $asciiscale?$asciiscale:1;
        $bColor = $asciicolor;
        $bAlpha = $asciialpha;
        $bBlock = $asciiblock;
        $bInvert = $asciiinvert;
        $strResolution = $asciiresolution?$asciiresolution:"low";
        $aCharList = $asciichars?$asciichars:($bColor ? $aDefaultColorCharList : $aDefaultCharList);
        $fResolution = 0.5;
        switch ($strResolution) {
            case "low" :     $fResolution = 0.25; break;
            case "medium" : $fResolution = 0.5; break;
            case "high" :     $fResolution = 1; break;
        }
        // $im = imagecreatefromjpeg($img);
        $im = imagecreatefrompng($img);
        $iWidth = ceil(imagesx($im) * $fResolution);
        $iHeight = ceil(imagesy($im) * $fResolution);
        $scale1    = 1; // 30
        $scale2    = 2;
        // echo $iWidth;
        // echo "\r\n";
        // echo $iHeight;
        // echo "\r\n";
        // echo $scale1;
        // echo "\r\n";
        // echo $scale2;
        for($y=0;$y<$iHeight;$y+=$scale2){
            for($x=0;$x<$iWidth;$x+=$scale1){
                $color_index = imagecolorsforindex($im,imagecolorat($im, ceil($x/$fResolution), ceil($y/$fResolution)));
                $iRed = $color_index['red'];
                $iGreen = $color_index['green'];
                $iBlue = $color_index['blue'];
                $iAlpha = $color_index['alpha'];
                if ($iAlpha == 100) {
                    $iCharIdx = 0;
                } else {
                    $fBrightness = (0.3*$iRed + 0.59*$iGreen + 0.11*$iBlue) / 255;
                    // echo $fBrightness;
                    // $fBrightness = (0.8*$iRed + 0.1*$iGreen + 0.1*$iBlue) / 255;
                    $iCharIdx = (count($aCharList)-1) - ceil($fBrightness * (count($aCharList)-1));
                }
                if ($bInvert) {
                    $iCharIdx = (count($aCharList)-1) - $iCharIdx;
                }
                $strThisChar = $aCharList[$iCharIdx];
                if ($strThisChar == " ")
                    $strThisChar = "█";
                else {
                    if ($strThisChar == '@') {
                        $strThisChar = " ";
                    }
                }

                if ($bColor) {
                    $strChars .= "<span style='"
                        . "color:rgb($iRed,$iGreen,$iBlue);"
                        . ($bBlock ? "background-color:rgb($iRed,$iGreen,$iBlue);" : "")
                        . ($bAlpha ? "opacity:" . ($iAlpha/255) . ";" : "")
                        . "'>" . $strThisChar . "</span>";
                } else {
                    $strChars .= $strThisChar;
                }
            }
            $strChars .= "\r\n";
        }
        // $fFontSize = (2/$fResolution)*$iScale;
        // $fLineHeight = (2/$fResolution)*$iScale;
        // $fLetterSpacing = 0;
        // if ($strResolution == "low") {
        //     switch ($iScale) {
        //         case 1 : $fLetterSpacing = -1; break;
        //         case 2 :
        //         case 3 : $fLetterSpacing = -2.1; break;
        //         case 4 : $fLetterSpacing = -3.1; break;
        //         case 5 : $fLetterSpacing = -4.15; break;
        //     }
        // }
        // if ($strResolution == "medium") {
        //     switch ($iScale) {
        //         case 1 : $fLetterSpacing = 0; break;
        //         case 2 : $fLetterSpacing = -1; break;
        //         case 3 : $fLetterSpacing = -1.04; break;
        //         case 4 :
        //         case 5 : $fLetterSpacing = -2.1; break;
        //     }
        // }
        // if ($strResolution == "high") {
        //     switch ($iScale) {
        //         case 1 :
        //         case 2 : $fLetterSpacing = 0; break;
        //         case 3 :
        //         case 4 :
        //         case 5 : $fLetterSpacing = -1; break;
        //     }
        // }
        // $width = ceil($iWidth/$fResolution)*$iScale;
        // $height = ceil($iHeight/$fResolution)*$iScale;
        // $style = "display:inline;width:$width px;height:$height px;white-space:pre;margin:0px;padding:0px;font:$strFont";
        // $style .= "letter-spacing:$fLetterSpacing px;font-size:$fFontSize px;text-align:left;text-decoration:none";
        echo  $strChars;
    }
}
// if( $argc<=1 ){
//     $fs = true;
//     do{
//         if($fs){
//             fwrite(STDOUT,'请输入图片文件名：');
//             $fs = false;
//         }else{
//             fwrite(STDOUT,'抱歉，图片文件名不能为空，请重新输入图片文件名：');
//         }
//         $filename = trim(fgets(STDIN));
//     }while(!$filename);
//     $px            =    1;
// }else{
//     $filename    =    $argv[1];
//     $px            =    isset($argv[2]) ? $argv[2] : 1;
// }
// switch($px){
//     case 1:    $pxval    =    'low';break;
//     case 2: $pxval    =    'medium';break;
//     case 3: $pxval    =    'high';break;
// }

// if (!function_exists('check_if_is_tb_link')) {
//     /**
//      * [curl_get_https 发送get请求]
//      * @param  [type] $url     [description]
//      * @param  [type] $headers [description]
//      * @return [type]          [description]
//      */
//     function check_if_is_tb_link($url, $msg)
//     {
//         // # 检查是否是淘宝链接
//         // def check_if_is_tb_link(msg):
//         //     print('收到的消息:')
//         //     print(msg)
//         //     print('')
//         //     if re.search(r'【.*】', msg['Text']) and (
//         //                         u'打开👉手机淘宝👈' in msg['Text'] or u'打开👉天猫APP👈' in msg['Text'] or u'打开👉手淘👈' in msg['Text'] or u'👉淘♂寳♀👈' in msg['Text']):
//         //         try:
//         //             # logger.debug(msg['Text'])
//         //             q = re.search(r'【.*】', msg['Text']).group().replace(u'【', '').replace(u'】', '')
//         //             if u'打开👉天猫APP👈' in msg['Text']:
//         //                 try:
//         //                     url = re.search(r'http://.* \)', msg['Text']).group().replace(u' )', '')
//         //                 except:
//         //                     url = None

//         //             else:
//         //                 try:
//         //                     #url = re.search(r'http://.* ，', msg['Text']).group().replace(u' ，', '')
//         //                     url = re.search(r'http://.* ', msg['Text']).group().replace(u' ', '')
//         //                 except:
//         //                     url = None
//         //             # 20170909新版淘宝分享中没有链接， 感谢网友jindx0713（https://github.com/jindx0713）提供代码和思路，现在使用第三方网站 http://www.taokouling.com 根据淘口令获取url
//         //             if url is None:
//         //                 taokoulingurl = 'http://www.taokouling.com/index.php?m=api&a=taokoulingjm'
//         //                 # taokouling = re.search(r'￥.*?￥', msg['Text']).group()
//         //                 taokouling = re.search(r'€.*?€', msg['Text']).group()
//         //                 if taokouling:
//         //                     taokouling = taokouling
//         //                 else:
//         //                     taokouling = re.search(r'￥.*?￥', msg['Text']).group()
//         //                 parms = {'username': 'wx_tb_fanli', 'password': 'wx_tb_fanli', 'text': taokouling}
//         //                 res = requests.post(taokoulingurl, data=parms)
//         //                 url = res.json()['url'].replace('https://', 'http://')
//         //                 info = "tkl url: {}".format(url)
//         //                 logger.debug(info)

//         //             # get real url
//         //             real_url = al.get_real_url(url)
//         //             info = "real_url: {}".format(real_url)
//         //             logger.debug(info)

//         //             # get detail
//         //             res = al.get_detail(real_url)
//         //             auctionid = res['auctionId']
//         //             coupon_amount = res['couponAmount']
//         //             tk_rate = res['tkRate']
//         //             price = res['zkPrice']
//         //             fx = (price - coupon_amount) * tk_rate / 100

//         //             # get tk link
//         //             res1 = al.get_tk_link(auctionid)
//         //             tao_token = res1['taoToken']
//         //             short_link = res1['shortLinkUrl']
//         //             coupon_link = res1['couponLink']

//         //             if coupon_link != "":
//         //                 coupon_token = res1['couponLinkTaoToken']
//         //                 res_text = '''
//         // %s
//         // 【返现】%.2f
//         // 【优惠券】%s元
//         // 请复制%s淘口令、打开淘宝APP下单
//         // -----------------
//         // 【下单地址】%s
//         //                 ''' % (q, fx, coupon_amount, coupon_token, short_link)
//         //             # res_text = u'''%s
//         //             # 【优惠券】%s元
//         //             # 请复制%s淘口令、打开淘宝APP下单
//         //             # -----------------
//         //             # 【下单地址】%s
//         //             #             ''' % (q, coupon_amount, coupon_token, short_link)
//         //             else:
//         //                 #                 res_text = u'''%s
//         //                 # 【优惠券】%s元
//         //                 # 请复制%s淘口令、打开淘宝APP下单
//         //                 # -----------------
//         //                 # 【下单地址】%s
//         //                 #                                 ''' % (q, coupon_amount, tao_token, short_link)
//         //                 res_text = '''
//         // %s
//         // 【返现】%.2f元
//         // 【优惠券】%s元
//         // 请复制%s淘口令、打开淘宝APP下单
//         // -----------------
//         // 【下单地址】%s
//         //                                 ''' % (q, fx, coupon_amount, tao_token, short_link)
//         //             msg.user.send(res_text)
//         //         except Exception as e:
//         //             trace = traceback.format_exc()
//         //             logger.warning("error:{},trace:{}".format(str(e), trace))
//         //             info = u'''%s
//         // -----------------
//         // 该宝贝暂时没有找到内部返利通道！亲您可以换个宝贝试试，也可以联系我们群内管理员帮着寻找有返现的类似商品
//         //             ''' % q
//         //             msg.user.send(info)
//     }
// }
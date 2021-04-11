<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\Alimama;
use Log;

class SwooleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:wechat {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * [$server tcp服务端]
     * @var [type]
     */
    private $server;

    /**
     * [$alimama 阿里妈妈对象]
     * @var [type]
     */
    private $alimama;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arg = $this->argument('action');

        switch ($arg) {
            case 'start':
                $this->info('swoole observer started');
                $this->start();
                break;

            case 'stop':
                $this->info('stoped');
                break;
                // 1.执行 ps -aux|grep artisan命令，获取pid（有多个进程，杀第一个即可）
                // 2.执行 kill pid命令，pid是第一步你获取的
                // 3.如果想后台值守，一定加上nohup命令！！！

            case 'restart':
                $this->info('restarted');
                break;

            default:
                # code...
                break;
        }
    }

    public function start()
    {

        // new alimama
        $this->alimama = new Alimama();
        // 登录
        $this->alimama->login();

        $this->server = new \swoole_server("0.0.0.0", config('swoole-wechat.ws_port'));

        $this->server->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode' => true
        ]);

        $this->server->on('start', function ($server) {
            echo "Start\n";
        });

        $this->server->on('connect', function ($server, $fd, $from_id) {
            // $serv->send( $fd, "Hello {$fd}!" );
        });

        $this->server->on('receive', function (swoole_server $server, $fd, $from_id, $data) {
            echo "Get Message From Client {$fd}:{$data}\n";
            // $server->push($request->fd, json_encode([
            //     'message_type'    =>  'qrcode_url',
            //     'url'       =>  $url
            // ]));
        });

        $this->server->on('close', function ($server, $fd, $from_id) {
            echo "Client {$fd} close connection\n";
        });

        $tcpServer = $this->server->addListener('0.0.0.0', config('swoole-wechat.notify_port'), SWOOLE_SOCK_TCP);
        $tcpServer->set([]);
        $tcpServer->on('receive', function ($serv, $fd, $threadId, $data) {
            $data = json_decode($data, true);
            if ($data['type'] == 'taobaoke') {
                $url = $data['url'];

                /**
                 * 淘口令处理
                 */
                // 获得真实链接
                $realUrl = $this->alimama->getRealUrl($url);

                // 打印日志
                echo "realUrl:";
                echo $realUrl;
                echo "\r\n";

                // 获得详情
                $detail = $this->alimama->getDetail($realUrl);

                if ($detail != 'no match item') {
                    $auctionId = $detail['auctionId'];
                    $couponAmount = $detail['couponAmount'];
                    $tkRate = $detail['tkRate'];
                    $price = $detail['zkPrice'];
                    $fx = ($price - $couponAmount) * $tkRate / 100;

                    // 获得淘宝客链接
                    $result = $this->alimama->getTkLink($auctionId);
                    $taoToken = $result['taoToken'];
                    $shortLink = $result['shortLinkUrl'];
                    $couponLink = $result['couponLink'];
                }
                if ($couponLink != '') {
                    $couponToken = $result['couponLinkTaoToken'];
                    $responseText = <<<EOT
%s
【返现】%.2f
【优惠券】%s元
请复制%s淘口令、打开淘宝APP下单
-----------------
【下单地址】%s
EOT;
                    $responseText = sprintf($responseText, $content, $fx, $couponAmount, $couponToken, $shortLink);
                    echo $responseText;

                } else {
                    $responseText = <<<EOT
%s
【返现】%.2f元
【优惠券】%s元
请复制%s淘口令、打开淘宝APP下单
-----------------
【下单地址】%s
EOT;
                    $responseText = sprintf($responseText, $content, $fx, $couponAmount, $taoToken, $shortLink);
                    $responseText;
                }

                $serv->push($fd, json_encode([
                    'message_type'    =>  'taobaoke_conversion_success',
                    'content'  =>  $responseText
                ]));
            }
            // $serv->close($fd);
        });

        $this->server->start();

        // $server = new \swoole_websocket_server("0.0.0.0", config('swoole-wechat.ws_port'));
        // $server->set([
        //     'daemonize' => 1
        // ]);
        // $app = app('wechat.official_account');
        // $server->on('open', function (\swoole_websocket_server $server, $request) use ($app){
        //     // $app = Factory::officialAccount($config['wechat']);
        //     $result = $app->qrcode->temporary($request->fd, 6 * 24 * 3600);
        //     Log::info('result.');
        //     Log::info($result);
        //     $url = $app->qrcode->url($result['ticket']);
        //     $server->push($request->fd, json_encode([
        //         'message_type'    =>  'qrcode_url',
        //         'url'       =>  $url
        //     ]));

        //     echo "server: handshake success with fd{$request->fd}\n";
        // });

        // $server->on('message', function (\swoole_websocket_server $server, $frame) {

        // });

        // $tcp_server = $server->addListener('0.0.0.0', config('swoole-wechat.notify_port'), SWOOLE_SOCK_TCP);
        // $tcp_server->set([]);
        // $tcp_server->on('receive', function ($serv, $fd, $threadId, $data) {
        //     $data = json_decode($data, true);
        //     if ($data['type'] == 'scan'){
        //         $serv->push($data['fd'], json_encode([
        //             'message_type'    =>  'scan_success',
        //             'user'  =>  $data['nickname']
        //         ]));
        //     }
        //     $serv->close($fd);
        // });

        // $server->start();
    }
}

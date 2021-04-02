<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
        $server = new \swoole_websocket_server("0.0.0.0", config('swoole-wechat.ws_port'));
        $server->set([
            'daemonize' => 1
        ]);
        $app = app('wechat.official_account');
        $server->on('open', function (\swoole_websocket_server $server, $request) use ($app){
            // $app = Factory::officialAccount($config['wechat']);
            $result = $app->qrcode->temporary($request->fd, 6 * 24 * 3600);
            Log::info('result.');
            Log::info($result);
            $url = $app->qrcode->url($result['ticket']);
            $server->push($request->fd, json_encode([
                'message_type'    =>  'qrcode_url',
                'url'       =>  $url
            ]));

            echo "server: handshake success with fd{$request->fd}\n";
        });

        $server->on('message', function (\swoole_websocket_server $server, $frame) {

        });

        $tcp_server = $server->addListener('0.0.0.0', config('swoole-wechat.notify_port'), SWOOLE_SOCK_TCP);
        $tcp_server->set([]);
        $tcp_server->on('receive', function ($serv, $fd, $threadId, $data) {
            $data = json_decode($data, true);
            if ($data['type'] == 'scan'){
                $serv->push($data['fd'], json_encode([
                    'message_type'    =>  'scan_success',
                    'user'  =>  $data['nickname']
                ]));
            }
            $serv->close($fd);
        });

        $server->start();
    }
}

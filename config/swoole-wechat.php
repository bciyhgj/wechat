<?php

return [
    'wechat'    =>  [   //微信配置
        'app_id' => 'xxxxxxxxxx',
        'secret' => 'xxxxxxxxx',
        'token'     =>  'xxxxxxxx',
        'response_type' => 'array',
        'log' => [
            'level' => 'debug',
            'file' => __DIR__.'/wechat.log',
        ],
    ],
    'ws_port'    =>  9510,  // websocket 监听端口号
    'ws'    =>  'ws://111.231.67.116:9510',  // websocket连接地址,服务器ip地址
    'notify_port'   =>  9511 // 消息通知端口号
];
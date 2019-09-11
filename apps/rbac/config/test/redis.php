<?php
// +----------------------------------------------------------------------
// | redis设置中心
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

return [
    'cache' => [
        // redis连接， 名字不可改
        'redis' => [
            'type' => 'redis',
            'host' => '192.168.1.91',
            'port' => 6379,
            'password' => '',
            'select' => 3,
            'timeout' => 0,
            'expire' => 0,
            'persistent' => false,
            'prefix' => '',
        ],
    ]
];

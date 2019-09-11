<?php

// +----------------------------------------------------------------------
// | 配置 处理 库
// +----------------------------------------------------------------------
// | COPYRIGHT (C) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | AUTHOR : lamkakyun
// | DATE   : 2019-04-12 09:46:29
// | VERSION：0.0.1
// +----------------------------------------------------------------------

namespace app\common\library;

use think\Config;

class ConfLib
{
    // 静态对象
    protected static $instance = null;

    /**
     * 单例
     * @author lamkakyun
     * @date 2019-04-12 09:47:11
     * @return void
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }


    /**
     * 获取 rbac 管理的系统
     * @author lamkakyun
     * @date 2019-04-12 09:48:26
     * @return void
     */
    public function getAllowSystem()
    {
        return Config::get('site.allowSystem');
    }
}
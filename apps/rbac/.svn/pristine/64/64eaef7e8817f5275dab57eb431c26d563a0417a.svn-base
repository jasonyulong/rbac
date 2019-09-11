<?php

// +----------------------------------------------------------------------
// | 权限处理库
// +----------------------------------------------------------------------
// | COPYRIGHT (C) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | AUTHOR : lamkakyun
// | DATE   : 2019-04-16 17:36:37
// | VERSION：0.0.1
// +----------------------------------------------------------------------
namespace app\common\library;

use think\Config;
use app\common\model\Users;
use app\common\model\UsersJob;
use app\common\model\UsersLabel;

class LabelLib
{
    // 静态对象
    protected static $instance = null;

    /**
     * 单例
     * @author lamkakyun
     * @date 2019-04-16 17:37:13
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
     * 获取所有标签
     * @author lamkakyun
     * @date 2019-04-16 17:38:54
     * @return void
     */
    public function getAllLabels()
    {
        $data = UsersLabel::where(['id' => ['NEQ', 1]])->select()->toArray();

        $tmp = $data;
        $data = [];
        foreach ($tmp as $value)
        {
            $data[$value['id']] = $value;
        }

        return $data;
    }

}
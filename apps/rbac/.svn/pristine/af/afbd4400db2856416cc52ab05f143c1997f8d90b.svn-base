<?php
// +----------------------------------------------------------------------
// | 数据同步任务
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\command;

use app\common\command\Commands;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;

/**
 * 数据同步任务
 */
class Cron extends Commands
{
    protected $name = 'cron';


    /**
     * 执行入口
     * @param Input $input 输入
     * @param Output $output 输出
     * @return int|void|null
     * @throws \think\Exception
     */
    protected function execute(Input $input, Output $output)
    {
        $ns_prefix = "\\" . __NAMESPACE__ . "\\" . $this->name . "\\";
        $class_dir = __DIR__ . DIRECTORY_SEPARATOR . $this->name;
        $this->defaultExecute($input, $output, $class_dir, $ns_prefix);
    }

    /**
     * 执行入口
     * @return void
     */
    protected function configure()
    {
        $desc = __("自动数据同步入口");

        $this->defaultConfigure($this->name, $desc);
        // ------------- 自定义参数 ---------------
        $this->addOption('debug', null, Option::VALUE_OPTIONAL, __('是否测试模式'));

        // 用法介绍
        $usage = "php think sync -m 类 -a 方法 自定义参数";
        $this->addUsage($usage);
    }
}
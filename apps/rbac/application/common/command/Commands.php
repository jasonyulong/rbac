<?php
// +----------------------------------------------------------------------
// | 自动任务基类
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\common\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use think\Exception;

class Commands extends Command
{
    protected $name = null;

    /**
     * 默认的执行操作
     * @param Input $input
     * @param Output $output
     * @param $class_dir
     * @param $ns_prefix
     * @throws Exception
     */
    public function defaultExecute(Input $input, Output $output, $class_dir, $ns_prefix)
    {
        $module = $input->getOption('module') ?: '';
        $action = $input->getOption('action') ?: '';
        $filename = $class_dir . DIRECTORY_SEPARATOR . ucfirst($module) . '.php';
        if (!$module) throw new Exception(__('请填写正确的类名称'));
        if (!$action) throw new Exception(__('请填写正确的方法名称'));
        if (!is_file($filename)) throw new Exception(__('填写的类名称错误'));

        $moduleName = $ns_prefix . ucfirst($module);

        $object = new $moduleName($input, $output);
        if (!method_exists($object, $action)) throw new Exception(__('操作方法不存在'));

        $result = $object->$action($input, $output);
        if ($result) $output->info(__($result));
    }

    /**
     * 默认执行
     * @param $command_name 脚本名称
     * @param string $desc 描述
     */
    protected function defaultConfigure($command_name, $desc = '')
    {
        $this->setName($command_name)
            ->addOption('module', 'm', Option::VALUE_REQUIRED, __('类名称, 对应你要操作的那个类文件'), null)
            ->addOption('action', 'a', Option::VALUE_REQUIRED, __('方法名称, 对应你要操作的类文件里的方法名称'), null)
            ->setDescription($desc);
    }
}


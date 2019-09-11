<?php
// +----------------------------------------------------------------------
// | 用户数据同步
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\command\cron;

use app\common\library\RedisLib;
use app\common\model\erp\OrganizationUser;
use app\common\model\UsersJob;
use app\common\model\UsersJobAccessAlso;
use think\console\Input;
use think\console\Output;
use think\Config;
use think\Log;

class Auth
{
    /**
     * 输入对象
     * @var Input
     */
    private $input;

    /**
     * 输出对象
     * @var Output
     */
    private $output;

    /**
     * 构造函数
     * Orders constructor.
     * @param Input $input 输入对象
     * @param Output $output 输出对象
     */
    public function __construct(Input $input, Output $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * 开始同步用户数据
     */
    public function run()
    {
        $authJobs = UsersJob::where(['auto_account' => 1, 'status' => 1])->column('id');
        if (empty($authJobs)) {
            return $this->output->writeln("nont job data");
        }
        // 针对的系统
        $module_id = 2;
        $keys = 'account';
        $alsoAccess = UsersJobAccessAlso::where([
            'job_id' => ['IN', $authJobs],
            'module_id' => $module_id,
            'keys' => $keys
        ])->column('job_id,id');

        // 所有帐号
        $accounts = RedisLib::instance()->getAllErpAccounts(1);
        $accountIds = array_keys($accounts);
        if (empty($accountIds)) {
            return $this->output->writeln("account empty");
        }

        // 需要同步所有帐号的岗位ID
        foreach ($authJobs as $job_id) {
            // 存在则更新
            if (isset($alsoAccess[$job_id])) {
                UsersJobAccessAlso::update(['values' => implode(',', $accountIds)], ['id' => $alsoAccess[$job_id]]);
            } else {
                UsersJobAccessAlso::create([
                    'job_id' => $job_id,
                    'module_id' => $module_id,
                    'keys' => $keys,
                    'values' => implode(',', $accountIds),
                ]);
            }
            $this->output->writeln(sprintf('%s success', $job_id));
        }
        $this->output->writeln("success");
    }
}
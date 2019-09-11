<?php
// +----------------------------------------------------------------------
// | 用户数据同步
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\command\toerp;

use app\common\library\auth\Access;
use app\common\model\erp\EbayAccount;
use app\common\model\UsersJob;
use think\console\Input;
use think\console\Output;
use think\Config;
use think\Log;

class Users
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
        $start = strtotime("-10 minute");
        $model = new \app\common\model\Users();
        $erpUser = new \app\common\model\erp\EbayUser();

        $users = $model->where('createtime|updatetime', 'EGT', $start)->select();
        if (count($users) <= 0) {
            $this->output->writeln("sync users total:" . count($users));
        }
        // ERP已经存在的用户ID
        $erpUsersId = $erpUser->column('id');
        $jobIds = UsersJob::column('id,title');

        foreach ($users as $user) {
            $allows = $user->allows->toArray() ?? [];
            $module_ids = $allows ? array_column($allows, 'module_id') : [];
            $label_ids = !empty($user->rules_id) ? explode(',', trim($user->rules_id, ',')) : [];

            // 权限获取
            $access = new Access();
            $access->setUsers($user);
            $userPower = $access->getAccess($user->id, 2, $user->job_id, $label_ids);
            // 权限集合
            $userAccess = $access->getUserPowers();
            $vieworder = $userAccess['alsos']['order_status'] ?? '';
            $viewstore = $userAccess['alsos']['store_id'] ?? '';
            $accountIds = $userAccess['alsos']['account'] ?? '';
            $ebayaccounts = '';
            if (!empty($accountIds)) {
                $accountIdsArr = explode(',', $accountIds);
                $ebayaccounts = EbayAccount::where(['id' => ['IN', $accountIdsArr]])->column('ebay_account');
                $ebayaccounts = !empty($ebayaccounts) ? implode(',', $ebayaccounts) : '';
            }
            // 更新数据
            $saveData = [
                'username' => $user->username,
                'password' => $user->password,
                'truename' => $jobIds[$user->job_id] ?? 0,
                'tel' => $user->mobile,
                'mail' => $user->email,
                'regdate' => $user->createtime,
                'user' => 'vipadmin',
                'power' => !empty($userPower) ? implode(',', $userPower) : '',
                'ebayaccounts' => $ebayaccounts,
                'viewstore' => $viewstore,
                'vieworder' => $vieworder,
                'isauth' => $user->maturitytime > time() ? 1 : 0,
                'is_app' => in_array(5, $module_ids) ? 1 : 0,
                'is_count' => in_array(4, $module_ids) ? 1 : 0,
                'is_del' => $user->status == 9 ? 1 : 0,
            ];
            // 开始更新
            if (in_array($user->id, $erpUsersId)) {
                $erpUser->update($saveData, ['id' => $user->id]);
            } else {
                $erpUser->create(array_merge($saveData, ['id' => $user->id]));
            }
            $this->output->writeln($user->id . "success");
        }
    }
}
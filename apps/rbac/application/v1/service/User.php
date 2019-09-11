<?php
// +----------------------------------------------------------------------
// | 用户相关操作服务
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\v1\service;

use app\common\model\Users;
use app\common\model\UsersAllow;
use app\common\model\UsersCount;
use app\common\model\UsersDetail;
use \app\common\model\UsersJob;
use \app\common\model\UsersLabel;
use \app\common\model\Organization;
use app\common\model\UsersNotice;
use \app\v1\service\Department;
use \app\v1\service\Position;
use \app\common\model\UsersLog;
use plugin\Tree;
use think\cache\driver\Redis;
use think\Config;

class User extends Base
{
    /**
     * @var 每页显示的数量
     */
    public $pageSize = 20;

    /**
     * 当前页
     * @var int
     */
    public $current_page = 1;

    /**
     * 需要检测的字段
     * @var string
     */
    public $field = 'a.id,a.token,a.company_id,a.authtime,a.password,a.remarks,a.job_id,a.rules_id,a.allow,a.maturitytime,a.maturityuser,a.logintime,a.loginip,a.status,a.username,a.email,a.mobile,a.org_id,a.job_type,b.pact_type,b.ready_computer,b.room,b.preentrytime,b.proceduretime,b.createuser,a.createtime,b.position';

    /**
     * @name    获取用户的数据
     * @param $params
     * @return array
     * @author  jason
     * @date  2019-04-01 10:39:27
     */
    public function getInfo($params)
    {
        $user = new Users();
        //每页显示的数量
        $page_size = !empty($params['ps']) ? $params['ps'] : $this->pageSize;
        //当前页
        $current_page = (!empty($params['page']) && intval($params['page']) > 0) ? $params['page'] : $this->current_page;
        //分页起始值
        $select_start = $page_size * ($current_page - 1);
        //部门
        if (!empty($params['org_id'])) {
            $departmentService = new Department();
            $id = trim($params['org_id']);
            $org_id = $departmentService->getson($id, $is_my = 1);
            if (!empty($org_id)) $where['a.org_id'] = ['IN', $org_id];
        }
        //岗位
        if (!empty($params['job_id'])) {
            $positionService = new Position();
            $id = $params['job_id'];
            $job_id = $positionService->getson($id, $is_my = 1);
            if (!empty($job_id)) $where['a.job_id'] = ['IN', $job_id];
        }
        //状态
        if (isset($params['status']) && $params['status'] != 100) {
            $where['a.status'] = $params['status'];
        }
        //开始时间
        if (!empty($params['start_time'])) {
            $start_time = strtotime($params['start_time']);
            $start_time = date('Y-m-d 00:00:00', $start_time);
            $start_time = strtotime($start_time);
        }
        //结束时间
        if (!empty($params['end_time'])) {
            $end_time = strtotime($params['end_time']);
            $end_time = date('Y-m-d 23:59:59', $end_time);
            $end_time = strtotime($end_time);
        }
        //如果开始时间跟结束时间不为空
        if (!empty($start_time) && !empty($end_time)) {
            switch ($params['timetype']) {
                case 1:
                    //创建时间
                    $where['a.createtime'] = ['BETWEEN', [$start_time, $end_time]];
                    $order = 'a.createtime desc';
                    break;
                case 2:
                    //入职时间
                    $where['a.entrytime'] = ['BETWEEN', [$start_time, $end_time]];
                    $order = 'a.entrytime desc';
                    break;
                case 3:
                    //手续时间
                    $where['b.proceduretime'] = ['BETWEEN', [$start_time, $end_time]];
                    $order = 'b.proceduretime desc';
                    break;
                case 4:
                    //预计入职时间
                    $where['b.preentrytime'] = ['BETWEEN', [$start_time, $end_time]];
                    $order = 'b.preentrytime desc';
                    break;
            }
        }

        //如果搜索的时候没有选择时间的话默认是创建时间降序
        if (empty($start_time) || empty($end_time)) $order = 'a.createtime desc';
        //协议
        if (isset($params['pact_type']) && $params['pact_type'] != 100) $where['b.pact_type'] = trim($params['pact_type']);
        //是否安排住宿
        if (isset($params['room']) && $params['room'] != 100) $where['b.room'] = trim($params['room']);
        //是否自带电脑
        if (isset($params['ready_computer']) && $params['ready_computer'] != 100) $where['b.ready_computer'] = trim($params['ready_computer']);

        //按字段类型搜索
        if (!empty($params['searchKey']) && !empty($params['searchValue'])) {
            $searchValue = preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/", ',', trim($params['searchValue']));
            $searchValue = explode(',', $searchValue);
            switch ($params['searchKey']) {
                case 1:
                    $searchValue = array_filter($searchValue, function ($par) {
                        return !empty($par);
                    });

                    if (count($searchValue) == 1) {
                        $searchValue = implode(',', $searchValue);
                        $where['username'] = ['like', '%' . $searchValue . '%'];
                    } else {
                        $where['username'] = ['IN', $searchValue];
                    }
                    break;
                case 2:
                    $searchValue = array_filter($searchValue, function ($par) {
                        return !empty($par);
                    });
                    if (count($searchValue) == 1) {
                        $searchValue = implode(',', $searchValue);
                        $where['mobile'] = ['like', '%' . $searchValue . '%'];
                    } else {
                        $where['mobile'] = ['IN', $searchValue];
                    }
                    break;
                case 3:
                    $searchValue = array_filter($searchValue, function ($par) {
                        return !empty($par);
                    });
                    if (count($searchValue) == 1) {
                        $searchValue = implode(',', $searchValue);
                        $where['email'] = ['like', '%' . $searchValue . '%'];
                    } else {
                        $where['email'] = ['IN', $searchValue];
                    }
                    break;
            }
        }

        $where = $where ?? [];
        //查询当前的状态的个数
        $statusTotals = $this->getStatusTotals($where);
        //分页url参数
        $config = [
            'query' => request()->param(),
        ];
        $userInfo = $user->limit($select_start, $page_size)
            ->alias('a')
            ->field($this->field)
            ->join('users_detail b', 'a.id = b.user_id', 'INNER')
            ->order($order)
            ->where($where)
            ->paginate($page_size, false, $config);
        if (isset($params['debug']) && $params['debug'] == 'sql') {
            echo $user->getLastSql();
            die;
        }
        $page = $userInfo->render();
        //将时间整理一下
        $users = $userInfo->toArray()['data'];
        //部门
        $orgIdArr = array_column($users, 'org_id');
        $orgIdArr = array_unique($orgIdArr);
        $orgArr = $this->getOrgLeftOrRight($orgIdArr, 1);
        //岗位
        $jobIdArr = array_column($users, 'job_id');
        $jobIdArr = array_unique($jobIdArr);
        $jobArr = $this->getJobLeftOrRight($jobIdArr);
        if (!empty($users)) {
            //所有的权限标签
            $userLabel = $this->getUsersLabel();
            foreach ($users as $key => $val) {
                //授权时间转换一下
                $users[$key]['preentrytime'] = !empty($val['preentrytime']) ? date('Y-m-d H:i:s', $val['preentrytime']) : '';
                $users[$key]['proceduretime'] = !empty($val['proceduretime']) ? date('Y-m-d H:i:s', $val['proceduretime']) : '';
                $users[$key]['maturitytime'] = !empty($val['maturitytime']) ? date('Y-m-d H:i:s', $val['maturitytime']) : '';
                $users[$key]['logintime'] = !empty($val['logintime']) ? date('Y-m-d H:i:s', $val['logintime']) : '';
                $users[$key]['authtime'] = !empty($val['authtime']) ? date('Y-m-d H:i:s', $val['authtime']) : '';
                if (!empty(strtotime($val['createtime']))) {
                    $retention_time = retentionTimes(strtotime($val['createtime']));
                    $users[$key]['retention_time'] = $retention_time;
                } else {
                    $users[$key]['retention_time'] = '';
                }
                //权限标签处理一下
                if (!empty($val['rules_id'])) {
                    $rule_id = $this->packageRule($val['rules_id'], $userLabel) ?? '';
                } else {
                    $rule_id = '';
                }
                $users[$key]['rules_id'] = $rule_id;

                //获取当前部门的所有的父级，如果已经是顶级就返回自身
                $users[$key]['org_id'] = $orgArr[$val['org_id']] ?? '';
                //获取当前岗位的所有父级，如果已经是顶级就返回自身
                $users[$key]['job_id'] = $jobArr[$val['job_id']] ?? '';
            }
        }
        $return_data = [
            'user' => $users,
            'page' => $page,
            'statusTotals' => $statusTotals
        ];

        return $return_data;
    }

    /**
     * @name    权限标签ID拆分 ，再组装
     * @param $ruleStr
     * @return string
     * @author  jason
     * @date  2019-04-04 06:15:12
     */
    public function packageRule($ruleStr, $userLabel): string
    {
        //如果为空就直接返回空字符串
        if (empty($ruleStr)) {
            return '';
        }
        //拆分，组装
        $ruleArr = explode(',', $ruleStr);
        $arr = [];
        foreach ($ruleArr as $k => $v) {
            if (!empty($userLabel[$v])) {
                $arr[$v] = $userLabel[$v];
            } else {
                $arr = [];
            }
        }
        if (empty($arr)) {
            return '';
        }
        $str = implode('，', $arr);

        return $str;
    }

    /**
     * @name    岗位ID拆分 ，再组装
     * @param $userObj
     * @return string
     * @author  jason
     * @date  2019-04-05 12:44:54
     */
    public function userJob($userObj, $userObjInfo)
    {
        //如果为空就直接返回空数组
        if (empty($userObj)) {
            return '';
        }
        //拆分，组装
        $objArr = explode(',', trim($userObj, ','));
        $arr = [];
        foreach ($objArr as $k => $v) {
            $arr[$v] = $userObjInfo[$v] ?? 0;
        }
        $str = implode(',', $arr);

        return $str;
    }

    /**
     * 编辑用户信息
     * @param $user_id 用户ID
     * @param array $saveData 保存的数据
     * @return array
     */
    public function editUser($user_id, $saveData = [], $addType): array
    {
        $userModel = new Users();
        $userDetail = new UsersDetail();
        $organizationService = new \app\v1\service\Organization();
        $statusNum = Config::get('users.statusNum');
        //所有的部门
        $org_id = $this->getOrgAll();
        //所有角色
        $job_type = Config::get('site.userJobType');
        //所有公司
        $company_id = Config::get('users.company');
        //所有的协议类型
        $pact_type = Config::get('users.pact_type');
        //是否准备电脑
        $ready_computer = Config::get('users.ready_computer');
        //是否安排住宿
        $room = Config::get('users.room');
        //创建时间
        $createtime = time();
        //当前登录用户信息
        $auth = \app\common\library\auth\Token::instance();
        $user = $auth->getUser();
        $user_name = !empty($user) ? $user->username : '未知';
        //检查邮箱
        $email = trim($saveData['email']);
        if (!empty($email) && !preg_match('#[a-z0-9&\-_.]+@[\w\-_]+([\w\-.]+)?\.[\w\-]+#is', $email)) {
            $this->setErrors(0, '请填写正确的邮箱!');

            return [];
        }
        //检查电话
        $mobile = trim($saveData['mobile']);
        if (!empty($mobile) && !preg_match("/^1[345678]{1}\d{9}$/", $mobile)) {
            $this->setErrors(0, '请填写正确的手机号!');

            return [];
        }

        //验证部门
        if (empty(trim($saveData['org_id']))) {
            $this->setErrors(0, '请选择部门!');

            return [];
        }
        //用户主表字段
        $addUser['username'] = trim($saveData['username']);   //用户名
        $addUser['mobile'] = $mobile;   //电话
        $addUser['email'] = $email; //邮箱
        $addUser['org_id'] = trim($saveData['org_id']);   //部门 ID
        $addUser['job_type'] = trim($saveData['job_type']);   //角色ID
        $addUser['company_id'] = trim($saveData['company_id']);   //公司ID
        if ($addType == 'add') {
            $addUser['createtime'] = $createtime;
            $addUser['salt'] = \plugin\Random::alnum();
        }
        //用户详情表字段
        $addDetail['pact_type'] = trim($saveData['pact_type']);    //协议类型
        $addDetail['ready_computer'] = trim($saveData['ready_computer']);    //是否提前准备电脑
        $addDetail['room'] = trim($saveData['room']);    //住宿安排

        //预计入职时间
        if (!empty($saveData['preentrytime'])) {
            $addDetail['preentrytime'] = strtotime($saveData['preentrytime']);
        }
        //办理手续时间
        if (!empty($saveData['proceduretime'])) {
            $addDetail['proceduretime'] = strtotime($saveData['proceduretime']);
        }

        if ($addType == 'add') $addDetail['createtime'] = $createtime;
        if ($addType == 'edit') {
            $addDetail['updatetime'] = $createtime;
            $addUser['updatetime'] = $createtime;
        }

        //职位
        $addDetail['position'] = trim($saveData['position']);
        $userInfo = $userModel->where(['username' => trim($saveData['username'])])->field('id,username,org_id')->find();
        //如果是添加用户
        if ($addType == 'add') {
            $addDetail['createuser'] = $user_name;    //创建人
            //先判断用户名是否存在
            if (empty(trim($saveData['username']))) {
                $this->setErrors(0, '请填写用户!');

                return [];
            }
            //判断用户名是否被重复使用
            if (($userInfo['username'] == trim($saveData['username']))) {
                //有多少个用户已经被使用了
                $w['username'] = ['LIKE', '%' . trim($saveData['username']) . '%'];
                $user_info = $userModel->where($w)->column('username', 'id');
                $user_str = implode(',', $user_info);
                $user_str = trim($user_str, ',');
                $this->setErrors(0, sprintf('【%s】用户名已经重复；已被使用的用户：%s', $userInfo['username'], $user_str));

                return [];
            }
            //开启事务
            $userModel->startTrans();
            $id = $userModel->insertGetId($addUser);
            //用户主表ID
            $addDetail['user_id'] = $id;
            if (!$id) {
                $userModel->rollback();
                $this->setErrors(0, Config::get('app_debug') ? $userDetail->getError() : '更新用户信息错误');

                return [];
            }
            $res = $userDetail->insert($addDetail);
            if (!$res) {
                $userModel->rollback();
                $this->setErrors(0, Config::get('app_debug') ? $userDetail->getError() : '更新用户信息错误');

                return [];
            }

            $after_status = $statusNum[0];     //修改后的状态
            $re2 = $this->userNum($after_status);
            if (empty($re2)) {
                $userModel->rollback();
                $this->setErrors(0, '添加失败!');

                return [];
            }

            $userModel->commit();
            //写入日志
            $title = '添加用户';
            $content = '第一次添加用户';
            $this->addLog($id, $title, $content);
            $this->setErrors(1, '添加用户信息成功!');

            return [];
        }

        //如果是编辑用户
        if (empty($user_id)) {
            $this->setErrors(0, '请填写用户!');

            return [];
        }
        //查询用户表
        $wh['a.id'] = $user_id;
        $info = $userModel
            ->alias('a')
            ->field($this->field)
            ->join('users_detail b', 'a.id = b.user_id', 'INNER')
            ->where($wh)->find();

        if (empty($info)) {
            $this->setErrors(0, '请填写用户!');

            return [];
        }

        //判断用户名是否被重复使用
        if (($userInfo['username'] == trim($saveData['username'])) && ($info['username'] != $saveData['username'])) {
            //有多少个用户已经被使用了
            $w['username'] = ['LIKE', '%' . trim($saveData['username']) . '%'];
            $user_info = $userModel->where($w)->column('username', 'id');
            $user_str = implode(',', $user_info);
            $user_str = trim($user_str, ',');
            $this->setErrors(0, sprintf('【%s】用户名已经重复；已被使用的用户：%s', $userInfo['username'], $user_str));

            return [];
        }
        //日志内容
        $log = '';
        $log .= sprintf('姓名；修改前：%s；修改后：%s;', $info['username'], trim($saveData['username']));
        $log .= sprintf('电话；修改前：%s；修改后：%s;', $info['mobile'], trim($saveData['mobile']));
        $log .= sprintf('邮箱；修改前：%s；修改后：%s;', $info['email'], trim($saveData['email']));
        $log .= sprintf('部门；修改前：%s；修改后：%s;', $org_id[$info['org_id']] ?? '', $org_id[$saveData['org_id']] ?? '');
        $log .= sprintf('角色；修改前：%s；修改后：%s;', $job_type[$info['job_type']] ?? '', $job_type[$saveData['job_type']] ?? '');
        $log .= sprintf('公司；修改前：%s；修改后：%s;', $company_id[$info['company_id']] ?? '', $company_id[$saveData['company_id']] ?? '');
        $log .= sprintf('协议；修改前：%s；修改后：%s;', $pact_type[$info['pact_type']] ?? '', $pact_type[$saveData['pact_type']] ?? '');
        $log .= sprintf('电脑；修改前：%s；修改后：%s;', $ready_computer[$info['ready_computer']] ?? '', $ready_computer[$saveData['ready_computer']] ?? '');
        $log .= sprintf('住宿；修改前：%s；修改后：%s;', $room[$info['room']] ?? '', $room[$saveData['room']] ?? '');
        $log .= sprintf('预计入职时间；修改前：%s；修改后：%s;', !empty($info['preentrytime']) ? date('Y-m-d H:i:s', $info['preentrytime']) : '', !empty($saveData['preentrytime']) ? date('Y-m-d H:i:s', $addDetail['preentrytime']) : '');
        $log .= sprintf('办理手续时间；修改前：%s；修改后：%s;', !empty($info['proceduretime']) ? date('Y-m-d H:i:s', $info['proceduretime']) : '', !empty($saveData['proceduretime']) ? date('Y-m-d H:i:s', $addDetail['proceduretime']) : '');
        //开启事务
        $userModel->startTrans();
        $res = $userModel->where(['id' => $user_id])->update($addUser);
        if (!$res) {
            $userModel->rollback();
            $this->setErrors(0, __('更新用户信息错误'));

            return [];
        }
        //更新时间
        $rest = $userDetail->where(['user_id' => $user_id])->update($addDetail);
        if (!$rest) {
            $userModel->rollback();
            $this->setErrors(0, __('更新用户信息错误'));

            return [];
        }
        //如果当前的用户是已入职的状态就要把用户的组织ID存入到组织架构用户表
        if ($info['status'] == 1) {
            $res2 = $organizationService->update($user_id, $info['org_id'], $addUser['org_id']);
            if (empty($res2)) {
                $this->setErrors(0, __('更新用户信息错误'));

                return [];
            }
        }

        $userModel->commit();
        $title = '编辑用户';
        $content = $log;
        $this->addLog($user_id, $title, $content);
        $this->setErrors(1, __('修改用户信息成功!'));

        return [];
    }

    /**
     * @name    编辑用户权限 ，岗位，可刊登平台
     * @param $params
     * @return array|void
     * @throws \think\Exception
     * @author  jason
     * @date  2019-04-05 01:15:20
     */
    public function editrule($params)
    {
        $userModel = new Users();
        $userDetailModel = new UsersDetail();
        $userAllowModel = new UsersAllow();
        $positionService = new Position();
        $organizationService = new \app\v1\service\Organization();
        //所有岗位
        $allUserObj = $this->getUserObj();
        //所有权限标签
        $userLabel = $this->getUsersLabel();
        //新用户的过期授权时间
        $new_user_auth_time = Config::get('site.new_user_auth_time');
        //所有可刊登的平台
        $allowSystem = Config::get('site.allowSystem');
        $statusNum = Config::get('users.statusNum');
        //将数组的键跟值对调
        $allowSystem = array_flip($allowSystem);

        //用户ID
        $ids = explode(',', $params['ids']);
        if (empty($ids)) {
            $this->setErrors(0, '请选择用户!');

            return [];
        }
        switch ($params['saveType']) {
            case 'job_id':
                //岗位
                if ($params['job_id'] == '') {
                    $this->setErrors(0, '请选择岗位!');

                    return [];
                }
                $job_id = $params['job_id'] ?? '';
                //开启事务
                $userModel->startTrans();
                $log = [];
                foreach ($ids as $user_id) {
                    //现将用户的信息查询出来
                    $userInfo = $userModel->where(['a.id' => $user_id])->alias('a')->join('users_detail b', 'a.id=b.user_id', 'INNER')->field('a.id,a.job_id')->find();
                    $userInfo = $userInfo->toArray();
                    //用户已经不存在了
                    if (empty($userInfo)) {
                        $userModel->rollback();

                        return;
                    }
                    //日志内容
                    $log[$user_id] = sprintf('岗位；修改前：%s；修改后：%s;', $allUserObj[$userInfo['job_id']] ?? '', $allUserObj[$job_id] ?? '');

                    //跟新用户表的岗位ID
                    $res4 = $userModel->where(['id' => $user_id])->update(['job_id' => $job_id]);
                    if (!$res4) {
                        $userModel->rollback();

                        return;
                    }
                    //更新岗位的父级，子级的数量
                    $positionService->updateunder($job_id);
                    //更新修改前的岗位ID
                    if ($job_id != $userInfo['job_id']) {
                        $positionService->updateunder($userInfo['job_id']);
                    }
                }
                //提交事务
                $userModel->commit();
                foreach ($ids as $userId) {
                    $this->addLog($userId, '编辑用户', $log[$userId]);
                    //如果用户的岗位或者权限标签发生编辑的时候，需要清空现有权限，然后用户需要重新登录
                    $this->updateAuth($userId);
                }
                $this->setErrors(1, '修改岗位成功!');
                break;
            case 'rules_id':
                //权限标签
                $rules_id = $params['rules_id'] ?? '';
                if (empty($rules_id)) {
                    $this->setErrors(1, '修改权限标签成功!');

                    return [];
                }
                foreach ($ids as $user_id) {
                    $userInfo = $userModel->where(['a.id' => $user_id])->alias('a')->join('users_detail b', 'a.id=b.user_id', 'INNER')->field('a.id,a.rules_id')->find();
                    $userInfo = $userInfo->toArray();

                    if (empty($userInfo)) {
                        continue;
                    }
                    //日志内容   修改后的权限标签
                    if (!empty($rules_id)) {
                        $rulesStr = $this->packageRule(implode(',', $rules_id), $userLabel) ?? '';
                    } else {
                        $rulesStr = '';
                    }
                    //修改前用户的去权限标签
                    if (!empty($userInfo['rules_id'])) {
                        $beforeStr = $this->packageRule($userInfo['rules_id'], $userLabel) ?? '';
                    } else {
                        $beforeStr = '';
                    }
                    $log = sprintf('权限标签；修改前：%s；修改后：%s;', $beforeStr, $rulesStr);
                    //权限标签
                    $update['rules_id'] = !empty($rules_id) ? implode(',', $rules_id) : '';

                    $res = $userModel->where(['id' => $user_id])->update($update);
                    if (!empty($res)) {
                        $this->addLog($user_id, '编辑用户', $log);
                        //如果用户的岗位或者权限标签发生编辑的时候，需要清空现有权限，然后用户需要重新登录
                        $this->updateAuth($user_id);
                    }
                }
                $this->setErrors(1, '修改权限标签成功!');

                return [];
                break;
            case 'allow':
                //可刊登平台
                $allow = $params['allow'] ?? '';
                $log = [];
                foreach ($ids as $user_id) {
                    $userModel->startTrans();
                    $userInfo = $userModel->where(['a.id' => $user_id])->alias('a')->join('users_detail b', 'a.id=b.user_id', 'INNER')->field('a.id,a.allow')->find();
                    $userInfo = $userInfo->toArray();

                    if (empty($userInfo)) {
                        $userModel->rollback();
                        continue;
                    }
                    //日志内容
                    $log[$user_id] = sprintf('可登录系统；修改前：%s；修改后：%s;', $userInfo['allow'] ?? '', !empty($allow) ? implode(',', $allow) : '');

                    $save['allow'] = !empty($allow) ? implode(',', $allow) : '';
                    //先更新用户表
                    $res = $userModel->where(['id' => $user_id])->update($save);
                    if (empty($res)) {
                        $userModel->rollback();
                        continue;
                    }
                    //开始更新user_allow表数据     先根据用户表没有修改 之前的可登录的系统，去user_allow表中删除数据，h后再添加进去user_allow表
                    if (!empty($userInfo['allow'])) {
                        $allowArr = explode(',', trim($userInfo['allow'], ','));
                        //开始删除
                        foreach ($allowArr as $kk => $vv) {
                            $id = $allowSystem[$vv];
                            $res = $userAllowModel->where(['user_id' => $user_id, 'module_id' => $id])->delete();
                            if (empty($res)) {
                                $userModel->rollback();
                                continue;
                            }
                        }
                    }
                    if (!empty($allow)) {
                        //开始添加到user_allow表中
                        foreach ($allow as $ve) {
                            $allowId = $allowSystem[$ve];
                            $add = [];
                            $add['user_id'] = $user_id;
                            $add['module_id'] = $allowId;
                            $add['module_name'] = $ve;
                            $add['createtime'] = time();
                            $add['updatetime'] = time();
                            $rr = $userAllowModel->insertGetId($add);
                            if (empty($rr)) {
                                $userModel->rollback();
                                continue;
                            }
                        }
                    }
                    //成功了就提交事务
                    $userModel->commit();
                    $this->addLog($user_id, '编辑用户', $log[$user_id]);
                }
                $this->setErrors(1, '修改可登录的系统成功!');

                return [];
                break;
            case 'all':
                //单个编辑
                if ($params['org_id'] == '') {
                    $this->setErrors(0, '请选择部门!');

                    return [];
                }
                if ($params['job_id'] == '') {
                    $this->setErrors(0, '请选择岗位!');

                    return [];
                }

                //用户ID
                $user_id = $params['ids'];
                //部门ID
                $org_id = $params['org_id'];
                //岗位ID
                $job_id = $params['job_id'] ?? '';
                //可登录系统
                $allow = $params['allow'] ?? '';
                //权限标签ID
                $rules_id = $params['rules_id'] ?? '';
                //状态
                $status = $params['status'] ?? '';
                //授权过期时间
                $maturitytime = $params['maturitytime'] ?? '';
                //密码
                $password = trim($params['password']);
                //角色
                $job_type = $params['job_type'] ?? '';
                //当前登录用户信息
                $auth = \app\common\library\auth\Token::instance();
                $user = $auth->getUser();
                $username = !empty($user) ? $user->username : '未知';

                $userInfo = $userModel->where(['a.id' => $user_id])->alias('a')->join('users_detail b', 'a.id=b.user_id', 'INNER')->field('a.id,a.status,a.allow,a.job_id,a.rules_id,a.org_id,a.password,a.maturitytime')->find();
                $userInfo = $userInfo->toArray();
                //日志内容
                //权限标签处理一下
                if (!empty($rules_id)) {
                    $rule_ids = $this->packageRule(implode(',', $rules_id), $userLabel);
                    $rule_ids = $rule_ids ?? '';
                }
                $log = '';
                $log .= sprintf('岗位；修改前：%s；修改后：%s;', $allUserObj[$userInfo['job_id']] ?? '', $allUserObj[$job_id] ?? '');
                $log .= sprintf('可登录系统；修改前：%s；修改后：%s;', $userInfo['allow'] ?? '', !empty($allow) ? implode(',', $allow) : '');
                $log .= sprintf('权限标签；修改前：%s；修改后：%s;', $this->packageRule($userInfo['rules_id'], $userLabel) ?? '', $rule_ids ?? '');
                if (empty($userInfo)) {
                    $this->setErrors(0, '用户不存在!');

                    return [];
                }
                $update = [];
                //如果是修改密码的话需要验证密码是否符合格式
                if (!empty($password)) {
                    if (!preg_match("/^[a-zA-Z\d_]{6,}$/", $password)) {
                        $this->setErrors(0, '密码必须是有字母、数字组成、密码长度大于6!');

                        return [];
                    }
                    $update['password'] = md5(md5($password));   //密码
                }
                //如果授权时间发生修改后就要把授权人，授权时间发生修改
                if($userInfo['maturitytime'] != strtotime($maturitytime)){
                    //授权到期时间
                    $update['maturitytime'] = strtotime($maturitytime);
                    //授权人
                    $update['maturityuser'] = $username;
                    //授权时间
                    $update['authtime'] = time();
                }
                $userModel->startTrans();
                //角色
                if(!empty($job_type)) $update['job_type'] = $job_type;
                //先跟新用户表   1、岗位
                if (!empty($job_id)) $update['job_id'] = $job_id;
                //部门ID
                if (!empty($org_id)) $update['org_id'] = $org_id;
                //2、可登录系统
                $update['allow'] = !empty($allow) ? implode(',', $allow) : '';
                //3、权限标签ID
                $update['rules_id'] = !empty($rules_id) ? implode(',', $rules_id) : '';

                //4、转入在职；这里要干几件事：1、更新用户的授权时间，2、授权到期时间，3、授权人
                if ($status == 1) {
                    //授权时间
                    $update['authtime'] = time();
                    //入职时间
                    $update['entrytime'] = time();
                    //更新时间
                    $update['updatetime'] = time();
                    //授权到期时间     当前授权时间+授权过期的天数
                    $maturTime = time() + ($new_user_auth_time * 86400);
                    $update['maturitytime'] = $maturTime;
                    //授权人
                    $update['maturityuser'] = $username;
                    $update['status'] = 1;
                }

                //更新用户主表
                $res = $userModel->update($update, ['id' => $user_id]);
                if (empty($res)) {
                    $userModel->rollback();
                    $this->setErrors(0, '更新失败!');

                    return [];
                }
                if ($status == 1) {
                    //更新用户子表的更新时间
                    $result = $userDetailModel->update(['updatetime' => time()], ['user_id' => $user_id]);
                    if (empty($result)) {
                        $userModel->rollback();
                        $this->setErrors(0, '更新失败!');

                        return [];
                    }
                    //用户数量
                    $after_status = $statusNum[$status];     //修改后的状态
                    $re2 = $this->userNum($after_status);
                    if (empty($re2)) {
                        $userModel->rollback();
                        $this->setErrors(0, '更新失败44!');

                        return [];
                    }
                }
                //开始更新user_allow表数据     先根据用户表没有修改 之前的可登录的系统，去user_allow表中删除数据，h后再添加进去user_allow表
                if (!empty($userInfo['allow'])) {
                    $allowArr = explode(',', trim($userInfo['allow'], ','));
                    //开始删除
                    foreach ($allowArr as $kk => $vv) {
                        if (!isset($allowSystem[$vv])) continue;
                        $id = $allowSystem[$vv];
                        $ree = $userAllowModel->where(['user_id' => $user_id, 'module_id' => $id])->find();
                        if (empty($ree)) {
                            continue;
                        }
                        $res = $userAllowModel->where(['user_id' => $user_id, 'module_id' => $id])->delete();
                        if (empty($res)) {
                            $userModel->rollback();
                            $this->setErrors(0, '更新失败!');

                            return;
                        }
                    }
                }
                if (!empty($allow)) {
                    //开始添加到user_allow表中
                    foreach ($allow as $ve) {
                        $allowId = $allowSystem[$ve];
                        $add = [];
                        $add['user_id'] = $user_id;
                        $add['module_id'] = $allowId;
                        $add['module_name'] = $ve;
                        $add['createtime'] = time();
                        $add['updatetime'] = time();
                        $rr = $userAllowModel->insertGetId($add);
                        if (empty($rr)) {
                            $userModel->rollback();
                            $this->setErrors(0, '更新失败!');

                            return;
                        }
                    }
                }
                //如果当前的用户是已入职的状态就要把用户的组织ID存入到组织架构用户表
                $res3 = $organizationService->update($user_id, $userInfo['org_id'], $org_id);
                if (empty($res3)) {
                    $userModel->rollback();
                    $this->setErrors(0, '更新用户信息错误');

                    return;
                }
                //更新要修改的岗位的父级，子级的数量
                $positionService->updateunder($job_id);
                //更新修改前的岗位的父级，子级的数量
                if ($job_id != $userInfo['job_id']) {
                    $positionService->updateunder($userInfo['job_id']);
                }
                $userModel->commit();
                $this->addLog($user_id, '编辑用户', $log);
                //如果用户的岗位或者权限标签发生编辑的时候，需要清空现有权限，然后用户需要重新登录
                $this->updateAuth($user_id);
                $this->setErrors(1, '操作成功!');

                return [];
                break;
        }
    }

    /**
     * @name    删除用户
     * @param $status
     * @param $params
     * @return array
     * @author  jason
     * @date  2019-04-02 11:00:01
     */
    public function del($status, $params)
    {
        $userModel = new Users();
        $userDetailModel = new UsersDetail();
        $userIdArr = array_filter($params, function ($par) {
            return !empty($par);
        });
        if (empty($userIdArr)) {
            $this->setErrors(0, '没有要删除的数据!');
        }
        $return_data = [];

        foreach ($userIdArr as $key => $user_id) {
            $userModel->startTrans();
            //已发OFFER跟待入职是真删除
            if ($status == 0 || $status == 2) {
                //已发OFFFER的是真删除
                $wh['a.id'] = $user_id;
                $info = $userModel->alias('a')->join('users_detail b', 'a.id=b.user_id', 'INNER')->where($wh)->field('a.id,a.username')->find();
                //用户不存在
                if (empty($info)) {
                    $return_data[$user_id] = ['success' => false,
                        'msg' => sprintf('用户%s不存在', $info['username'])];
                    continue;
                }
                //开始删除users表的数据
                $re = $userModel->where(['id' => $user_id])->delete();
                if (!$re) {
                    $userModel->rollback();
                    $return_data[$user_id] = ['success' => false,
                        'msg' => Config::get('app_debug') ? $userModel->getError() : '删除用户信息错误'
                    ];
                    continue;
                }
                //开始删除用户详情表的数据
                $re2 = $userDetailModel->where(['user_id' => $user_id])->delete();
                if (!$re2) {
                    $userModel->rollback();
                    $return_data[$user_id] = ['success' => false,
                        'msg' => Config::get('app_debug') ? $userDetailModel->getError() : '删除用户信息错误'
                    ];
                    continue;
                }
                //成功就提交数据
                $userModel->commit();
                $this->addLog($user_id, '删除用户', sprintf('用户%s已被删除', $info['username']));
                $return_data[$user_id] = ['success' => true,
                    'msg' => sprintf('删除用户%s成功', $info['username'])];
            } else {
                //除了已发OFFER跟待入职的，其他的删除就是放入回收站
                $wh['a.id'] = $user_id;
                $info = $userModel->alias('a')->join('users_detail b', 'a.id=b.user_id', 'INNER')->where($wh)->field('a.id,a.username,a.status,a.org_id')->find();
                if (empty($info) || $info['status'] == 9) {
                    $userModel->rollback();
                    $return_data[$user_id] = ['success' => false,
                        'msg' => sprintf('用户%s不存在或者是已经在回收站', $info['username'])];
                    continue;
                }
                //从已入职转回收站要加一个判断，这个用户下有没有绑定的账号
                if(!empty($info['id']) && !empty($info['org_id'])){
                    $result = $this->isExistAccount($info['id'], $info['org_id']);
                    if (!empty($result)) {
                        $return_data[$user_id] = ['success' => false,
                            'msg' => sprintf('请先解绑该用户【%s】的可见账号', $info['username'])];
                        continue;
                    }
                }
                //更新数据
                $result = $userModel->update(['status' => 9, 'updatetime' => time()], ['id' => $user_id]);
                if (!$result) {
                    $userModel->rollback();
                    $return_data[$user_id] = ['success' => false,
                        'msg' => Config::get('app_debug') ? $userDetailModel->getError() : '删除用户信息错误'];
                    continue;
                }
                //更新用户详情表的更新时间
                $result2 = $userDetailModel->update(['updatetime' => time()], ['user_id' => $user_id]);
                if (!$result2) {
                    $userModel->rollback();
                    $return_data[$user_id] = ['success' => false,
                        'msg' => Config::get('app_debug') ? $userDetailModel->getError() : '删除用户信息错误'];
                    continue;
                }
                //成功就提交数据
                $userModel->commit();
                $this->addLog($user_id, '转回收站', sprintf('将用户：%s；转入回收站', $info['username']));
                $return_data[$user_id] = ['success' => true,
                    'msg' => sprintf('%s已成功转入回收站', $info['username'])];
            }
        }

        $this->errors = 1;

        return $return_data;
    }

    /**
     * @name    获取用户信息
     * @param $user_id
     * @return array
     * @author  jason
     * @date  2019-04-01 09:32:08
     */
    public function getUser($user_id)
    {
        $userModel = new Users();
        $wh['a.id'] = $user_id;
        $info = $userModel
            ->alias('a')
            ->field($this->field)
            ->join('users_detail b', 'a.id = b.user_id', 'INNER')
            ->where($wh)->find();
        if (empty($info)) {
            $this->setErrors(0, '用户不存在!');

            return [];
        }
        $userInfo = $info->toArray();

        return $userInfo;
    }

    /**
     * @name    批量改状态
     * @param $params
     * @return array
     * @author  jason
     * @date  2019-04-01 01:42:38
     */
    public function pending($star, $params): array
    {
        $userModel = new Users();
        $userDetailModel = new UsersDetail();
        $userStatus = Config::get('users.status');
        $statusNum = Config::get('users.statusNum');
        $return_data = [];
        //过滤掉为空的数据
        $data = array_filter($params['id'], function ($par) {
            return !empty($par);
        });
        if (!isset($star)) {
            return $return_data[100] = ['success' => false,
                'msg' => '转入的状态有误'];
        }
        $status = trim($star);
        //对应的状态
        $statusMsg = $userStatus[$statusNum[$status]];

        foreach ($data as $k => $userId) {
            $where['a.id'] = $userId;
            $info = $userModel->where($where)->alias('a')->field($this->field)->join('users_detail b', 'a.id=b.user_id', 'INNER')->find();
            //如果当前转入的状态跟用户现在的状态相等，就说明已经转过的，就不用转了
            if ($status == $info['status']) {
                $return_data[$userId] = ['success' => false,
                    'msg' => sprintf('用户%s已经转入%s', $info['username'], $statusMsg)];
                continue;
            }
            //如果是转离职或转回收站的时候就不要验证必填信息
            if ($status == 2) {
                if (empty($info['username']) || empty($info['org_id']) || empty($info['job_type'])) {
                    $return_data[$userId] = ['success' => false,
                        'msg' => sprintf('用户%s的信息填充完毕方可转入%s', $info['username'], $statusMsg)];
                    continue;
                }
            }
            //从在职转离职要加一个判断，这个用户下有没有绑定的账号
            if ($status == 3) {
                $result = $this->isExistAccount($info['id'], $info['org_id']);
                if (!empty($result)) {
                    $return_data[$userId] = ['success' => false,
                        'msg' => sprintf('请先解绑该用户【%s】的可见账号', $info['username'])];
                    continue;
                }
            }
            //开启事务
            $userModel->startTrans();
            //更新用户主表
            $res = $userModel->update(['status' => $status, 'updatetime' => time()], ['id' => $userId]);
            if (!$res) {
                $userModel->rollback();
                $return_data[$userId] = ['success' => false,
                    'msg' => sprintf('将用户%s转入%s失败%s', $info['username'], $statusMsg)];
                continue;
            }
            //更新用户子表的更新时间
            $res2 = $userDetailModel->update(['updatetime' => time()], ['user_id' => $userId]);
            if (!$res2) {
                $userModel->rollback();
                $return_data[$userId] = ['success' => false,
                    'msg' => sprintf('将用户%s转入%s失败%s', $info['username'], $statusMsg)];
                continue;
            }

            //用户数量
            $after_status = $statusNum[$status];     //修改后的状态
            $re2 = $this->userNum($after_status);
            if (empty($re2)) {
                $userModel->rollback();
                $return_data[$userId] = ['success' => false,
                    'msg' => sprintf('将用户%s转入%s失败%s', $info['username'], $statusMsg)];
                continue;
            }

            $userModel->commit();
            $return_data[$userId] = [
                'success' => true,
                'msg' => sprintf('将用户%s成功转入%s', $info['username'], $statusMsg)];
            $title = '修改用户状态';
            $content = sprintf('用户%s修改前状态：%s；修改后状态：%s', $info['username'], $userStatus[$statusNum[$info['status']]], $statusMsg);
            $this->addLog($userId, $title, $content);
        }
        $this->errors = 1;

        return $return_data;

    }

    /**
     * @name:   判断当前用户所绑定的账号
     * @param $userid
     * @param $orgid
     * @return array|false|\PDOStatement|string|\think\Model
     * @author: jason
     * @date: 2019-04-18 06:24:38
     */
    public function isExistAccount($userid, $orgid)
    {
        $userAccountModel = new \app\common\model\OrganizationUserAccount();
        $return_data = $userAccountModel->where(['user_id' => $userid, 'org_id' => $orgid, 'status' => 1])->find();

        return $return_data;
    }

    /**
     * @name    获取所有的标签权限
     * @return array
     * @author  jason
     * @date  2019-04-04 09:40:53
     */
    public function getUsersLabel(): array
    {
        $userLabelModel = new UsersLabel();
        $userLabelInfo = $userLabelModel->where(['status' => 1])->column('name', 'id');

        return $userLabelInfo;
    }

    /**
     * @name    获取部门的树结构
     * @return array
     * @author  jason
     * @date  2019-03-31 04:47:19
     */
    public function getOrg(): array
    {
        $organization = new Organization();
        // 必须将结果集转换为数组
        $list = collection($organization->order('weigh', 'desc')->where(['status' => 1])->select())->toArray();
        Tree::instance()->init($list);
        $list = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');

        return $list;
    }

    /**
     * @name    所有的部门
     * @return array
     * @author  jason
     * @date  2019-04-08 09:45:40
     */
    public function getOrgAll(): array
    {
        $orgModel = new Organization();
        $orgInfo = $orgModel->where(['status' => 1])->column('title', 'id');

        return $orgInfo;
    }

    /**
     * @name    获得岗位信息
     * @return array
     * @author  jason
     * @date  2019-04-02 04:36:49
     */
    public function getUserObj()
    {
        $userObj = new UsersJob();
        $userInfo = $userObj->where(['status' => 1])->column('title', 'id');

        return $userInfo;
    }

    /**
     * 根据用户状态返回数量
     * @param array $statusNum
     * @return array
     */
    public function getStatusTotals($where = []): array
    {
        if (isset($where['a.status'])) unset($where['a.status']);
        $statusNum = Config::get('users.statusNum');
        $user = new Users();
        $info = $user->alias('a')
            ->join('users_detail b', 'a.id=b.user_id', 'INNER')
            ->group('a.status')->where($where)->column('count(a.id)', 'a.status');
        //几种状态之和
        $count = array_sum($info);
        //每种状态对应的数量
        $statusArr = [];
        foreach ($statusNum as $k => $v) {
            if (isset($info[$k])) {
                $statusArr[$v] = $info[$k];
            } else {
                $statusArr[$v] = 0;
            }
        }
        //将全部的数量放入数组中
        $all_status['index'] = $count;
        $arr = array_merge($statusArr, $all_status);

        return $arr;
    }

    /**
     * @name    编辑备注
     * @param $params
     * @return array
     * @author  jason
     * @date  2019-04-09 10:46:05
     */
    public function saveNote($params)
    {
        $userModel = new Users();
        $note = trim($params['note']);
        //用户是否存在
        $res = $userModel->where(['id' => trim($params['id'])])->find();
        if (empty($res)) {
            $this->setErrors(0, '用户不存在!');

            return [];
        }
        if (empty($note)) {
            $this->setErrors(1, '修改备注成功!');

            return [];
        }
        $result = $userModel->where(['id' => trim($params['id'])])->update(['remarks' => $note]);
        if (!$result) {
            $this->setErrors(0, '修改备注成功!');

            return [];
        }
        //写入日志
        $title = '修改备注';
        $content = sprintf('修改用户：%s；的备注', $res['username']);
        $this->addLog($params['id'], $title, $content);
        $this->setErrors(1, '修改备注成功!');

        return [];
    }

    /**
     * @name:   写入日志
     * @param $addLog
     * @author: jason
     * @date: 2019-04-10 12:53:03
     */
    public function addLog($user_id, $title, $content)
    {
        $auth = \app\common\library\auth\Token::instance();
        $user = $auth->getUser();
        $username = !empty($user) ? $user->username : '未知';
        $addLog['createuser'] = $username;
        $addLog['createtime'] = time();
        $addLog['user_id'] = $user_id;
        $addLog['title'] = $title;
        $addLog['content'] = $content;
        $userLogModel = new UsersLog();
        $userLogModel->insert($addLog);
    }

    /**
     * @name    用户日志列表
     * @param $params
     * @return array
     * @author  jason
     * @date  2019-04-09 12:52:11
     */
    public function showlog($params)
    {
        $userLogModel = new UsersLog();
        $id = $params['id'];
        $info['id'] = $id;
        $page_size = 15;
        //分页url参数
        $config = [
            'query' => request()->param(),
        ];
        $logInfo = $userLogModel->where(['user_id' => $id])
            ->order('createtime desc')
            ->paginate($page_size, false, $config);
        if (isset($params['debug']) && $params['debug'] == 'sql') {
            echo $userLogModel->getLastSql();
            die;
        }
        $page = $logInfo->render();
        $log = $logInfo->toArray()['data'];
        $return_data = [
            'info' => $log,
            'page' => $page
        ];

        return $return_data;
    }

    /**
     * @name:   获取部门的所有的上级
     * @param $org_id
     * @param int $is_parent
     * @return string
     * @throws \think\Exception
     * @author: jason
     * @date: 2019-04-13 04:33:55
     */
    public function getOrgLeftOrRight($org_id = [], $is_parent = 1): array
    {
        //没有传值或传的是空值直接返回空字符串
        if (empty($org_id)) {
            return [];
        }
        $organization = new Organization();
        $whe['id'] = ['IN', $org_id];
        $org_info = $organization->where($whe)->field('id,tid,lid,rid,title')->select();
        if (empty($org_info)) return [];
        $org_info = $org_info->toArray();

        //获取当前部门的所有上级
        if ($is_parent == 1) {
            $orgAll = [];
            foreach ($org_info as $kk => $vv) {
                $wh['tid'] = $vv['tid'];
                $wh['lid'] = ['LT', $vv['lid']];
                $wh['rid'] = ['GT', $vv['rid']];
                $orgInfo = $organization->where($wh)->order('rank', 'asc')->column('title', 'id');
                if (empty($orgInfo)) {
                    $orgAll[$vv['id']] = $vv['title'];
                } else {
                    array_push($orgInfo, $vv['title']);
                    $orgAll[$vv['id']] = implode('>', $orgInfo);
                }
            }

            return $orgAll;
        }
    }

    /**
     * @name:   获取岗位的所有的上级
     * @param string $job_id
     * @param int $is_parent
     * @return string
     * @throws \think\Exception
     * @author: jason
     * @date: 2019-04-13 04:47:42
     */
    public function getJobLeftOrRight($job_id = [], $is_parent = 0)
    {
        //没有传值或传的是空值直接返回空字符串
        if (empty($job_id)) {
            return '';
        }
        $userJobModel = new UsersJob();
        $whe['id'] = ['IN', $job_id];
        $userJobInfo = $userJobModel->where($whe)->field('id,tid,lid,rid,title')->select();
        if (empty($userJobInfo)) {
            return [];
        }
        $userJobInfo = $userJobInfo->toArray();
        if ($is_parent == 1) {
            $userAll = [];
            foreach ($userJobInfo as $k => $v) {
                $wh['tid'] = $v['tid'];
                $wh['lid'] = ['LT', $v['lid']];
                $wh['rid'] = ['GT', $v['rid']];
                $userInfo = $userJobModel->where($wh)->order('rank', 'asc')->column('title', 'id');
                if (empty($userInfo)) {
                    $userAll[$v['id']] = $v['title'];
                } else {
                    array_push($userInfo, $v['title']);
                    $userAll[$v['id']] = implode('>', $userInfo);
                }
            }

            return $userAll;
        }
        // 直接获取岗位名称
        $userAll = [];
        foreach ($userJobInfo as $k => $v) {
            $userAll[$v['id']] = $v['title'];
        }
        return $userAll;
    }

    /**
     * @name:   更新用户数
     * @param $before_status
     * @param $after_status
     * @return bool|int|true
     * @author: jason
     * @date: 2019-04-16 04:30:10
     */
    public function userNum($after_status)
    {
        $userCountModel = new UsersCount();
        //如果两个字段有一个没传就直接return true
        if (empty($after_status)) {
            return true;
        }
        $wh['year'] = date('Y');
        $wh['month'] = date('m');
        $wh['days'] = date('d');
        //修改前的用户数
        $countInfo = $userCountModel->where($wh)->find();
        if (!empty($countInfo)) {
            $res = $userCountModel->where($wh)->setInc($after_status);
        } else {
            $res = $userCountModel->insert([$after_status => 1, 'year' => date('Y'), 'month' => date('m'), 'days' => date('d'), 'datetime' => time()]);
        }

        return $res;
    }

    /**
     * 获取用户统计数据
     * @param $year 年
     * @param $month 月
     * @param $days 日
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getUserCount($year, $month, $days)
    {
        $userCountModel = new UsersCount();
        $where['year'] = $year;
        $where['month'] = $month;
        //$where['days'] = $days;
        $return_data = $userCountModel->where($where)->field('sum(offer) as offer, sum(`wait`) as `wait`, sum(`work`) as `work`, sum(`leave`) as `leave`')->find();

        return $return_data;
    }

    /**
     * 用户发生岗位或者标签变更时，调用次方法刷新权限
     * @param $user_id 用户ID
     * @return bool
     */
    public function updateAuth($user_id)
    {
        $redis = new Redis(Config::get('cache.redis'));
        // 将权限移除
        \app\common\library\auth\Drive::instance()->clearAuth($user_id);
        // 清空用户TOKEN
        //Users::update(['token' => ''], ['id' => $user_id]);
        // 清楚redis
        //$redis->handler()->hdel(Config::get('redis.user_token'), $user_id);

        return true;
    }

    /**
     * 获取用户未读通知列表
     * @param $user_id 用户ID
     * @return false|static[]
     */
    public function getNotice($user_id)
    {
        return UsersNotice::all(['user_id' => ['IN', [0, $user_id]], 'status' => 0]);
    }
}
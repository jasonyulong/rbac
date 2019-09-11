<?php
// +----------------------------------------------------------------------
// | 用户管理控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\v1\controller\users;

use app\common\controller\AuthController as Controller;
use app\v1\service\Position;
use think\Config;

/**
 * 用户管理
 * Class Index
 * @package app\v1\controller\users
 */
class Index extends Controller
{
    /**
     * @var array 用户状态
     */
    private $userStatus = [];
    /**
     * @var 状态字符串对应的数字
     */
    private $statusNum = [];
    /**
     * @var null 用户服务
     */
    private $userService = null;

    /**
     * 所有角色
     */
    private $userJob = [];
    /*
     * 所有部门
     */
    private $getOrg = [];

    /**
     * 协议类型
     * @var array
     */
    private $pact_type = [];

    /**
     * 是否安排住宿
     * @var array
     */
    private $room = [];

    /**
     * 是否自备电脑
     * @var array
     */
    private $ready_computer = [];
    /**
     * 搜索字段
     * @var array
     */
    private $searchKey = [];

    /**
     * 权限标签
     * @var array
     */
    private $usersLabel = [];
    /**
     * 时间搜索类型
     * @var array
     */
    private $timetype = [];
    /*
     * 搜索状态
     */
    private $searchStatus = [];

    /**
     * @name    初始化
     * @author  jason
     * @date  2019-04-03 08:38:19
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->userService = new \app\v1\service\User();

        $this->userStatus = Config::get('users.status');
        $this->statusNum = Config::get('users.statusNum');
        $this->pact_type = Config::get('users.pact_type');
        $this->room = Config::get('users.room');
        $this->ready_computer = Config::get('users.ready_computer');
        $this->searchKey = Config::get('users.searchKey');
        $this->company = Config::get('users.company');
        $this->userJob = Config::get('site.userJobType');           //角色
        $this->allowSystem = Config::get('site.allowSystem');       //可登录的系统
        $this->timetype = Config::get('users.timetype');            //滞留时间配置
        $this->getUserObj = $this->userService->getUserObj();       //岗位
        $this->usersLabel = $this->userService->getUsersLabel();    //权限标签
        $this->getOrg = $this->userService->getOrg();               //部门
        $this->searchStatus = Config::get('users.searchStatus');

        $this->assign('searchStatus', $this->searchStatus);
        $this->assign('timetype', $this->timetype);
        $this->assign('usersLabel', $this->usersLabel);             //权限标签
        $this->assign('getUserObj', $this->getUserObj);             //岗位
        $this->assign('allowSystem', $this->allowSystem);           //允许登录系统
        $this->assign('company', $this->company);
        $this->assign('searchKey', $this->searchKey);
        $this->assign('userStatus', $this->userStatus);
        $this->assign('statusNum', $this->statusNum);
        $this->assign('pact_type', $this->pact_type);
        $this->assign('room', $this->room);                         //是否住宿
        $this->assign('ready_computer', $this->ready_computer);     //是否带电脑
        $this->assign('curJobType', $this->auth->jobType);          //角色
        $this->assign('userJobInfo', $this->userJob);
        $this->assign('orgInfo', $this->getOrg);
        //搜索条件
        $param2 = array_merge(input('get.'), input('post.'));
        if (!isset($param2['searchKey'])){
            $searchKey = 1;
        }else{
            $searchKey = $param2['searchKey'];
        }
        if (!isset($param2['searchValue'])){
            $searchValue = '';
        }else{
            $searchValue = $param2['searchValue'];
        }
        $this->assign('search_key',$searchKey);
        $this->assign('search_value',$searchValue);
    }

    /**
     * @name 全部
     * @author  jason
     * @date  2019-03-28 05:58:56
     * @return string
     * @throws \Exception
     */
    public function index() : string
    {
        $params = array_merge(input('get.'), input('post.'));
        $timetypes = Config::get('users.timetypes');
        //有些字段需要默认
        if (!isset($params['status'])) $params['status'] = 100;
        if (!isset($params['org_id'])) $params['org_id'] = '';
        if (!isset($params['job_id'])) $params['job_id'] = '';
        if (!isset($params['searchKey'])) $params['searchKey'] = 1;
        if (!isset($params['searchValue'])) $params['searchValue'] = '';
        if (!isset($params['start_time'])) $params['start_time'] = '';
        if (!isset($params['end_time'])) $params['end_time'] = '';
        if (!isset($params['timetype'])) $params['timetype'] = 1;
        
        //读取数据
        $data = $this->userService->getInfo($params);
        $statusNum = $this->statusNum;
        $statusTotals = $data['statusTotals'];
        //如果当前搜索的那个状态是在全部那里显示那个状态的数量，否则就显示全部的数量
        if($params['status'] != 100){
            foreach($statusTotals as $k=>$v){
                if($k == 'index'){
                    $statusTotals[$k] = $statusTotals[$statusNum[$params['status']]];
                }
            }
        }
        //搜索状态

        $this->assign('userslist', $data['user']);
        $this->assign('pages', $data['page']);
        $this->assign('statusTotals', $statusTotals);
        $this->assign('params', $params);
        $this->assign('timetypes',$timetypes);
        $this->assign('allOrg', $this->userService->getOrgAll());
        return parent::fetchAuto();
    }

    /**
     * 已发offer
     * @return string
     * @throws \Exception
     */
    public function offer() : string
    {
        $positionService = new Position();
        $params = array_merge(input('get.'), input('post.'));
        $timetypes = Config::get('users.timetypes');
        //有些字段需要默认
        if (!isset($params['status'])) $params['status'] = '';
        if (!isset($params['org_id'])) $params['org_id'] = '';
        if (!isset($params['job_id'])) $params['job_id'] = '';
        if (!isset($params['pact_type'])) $params['pact_type'] = 100;
        if (!isset($params['room'])) $params['room'] = 100;
        if (!isset($params['ready_computer'])) $params['ready_computer'] = 100;
        if (!isset($params['searchKey'])) $params['searchKey'] = 1;
        if (!isset($params['searchValue'])) $params['searchValue'] = '';
        if (!isset($params['start_time'])) $params['start_time'] = '';
        if (!isset($params['end_time'])) $params['end_time'] = '';
        if (!isset($params['timetype'])) $params['timetype'] = 1;
        $data = $this->userService->getInfo($params);

        $userJobInfo = $positionService->position();
        $this->assign('userJobInfos',$userJobInfo);
        $this->assign('timetypes',$timetypes);
        $this->assign('userInfo', $data['user']);
        $this->assign('pages', $data['page']);
        $this->assign('params', $params);
        $this->assign('statusTotals', $data['statusTotals']);
        $this->assign('allOrg', $this->userService->getOrgAll());
        return parent::fetchAuto();
    }

    /**
     * 待入职
     * @return string
     * @throws \Exception
     */
    public function wait() : string
    {
        $positionService = new Position();
        $params = array_merge(input('get.'), input('post.'));
        $timetypes = Config::get('users.timetypes');
        //有些字段需要默认
        if (!isset($params['org_id'])) $params['org_id'] = '';
        if (!isset($params['job_id'])) $params['job_id'] = '';
        if (!isset($params['pact_type'])) $params['pact_type'] = 100;
        if (!isset($params['room'])) $params['room'] = 100;
        if (!isset($params['ready_computer'])) $params['ready_computer'] = 100;
        if (!isset($params['searchKey'])) $params['searchKey'] = 1;
        if (!isset($params['searchValue'])) $params['searchValue'] = '';
        if (!isset($params['start_time'])) $params['start_time'] = '';
        if (!isset($params['end_time'])) $params['end_time'] = '';
        if (!isset($params['timetype'])) $params['timetype'] = 1;
        $params['status'] = 2;
        $data = $this->userService->getInfo($params);
        //滞留时间
        foreach($data['user'] as $key=>$value){
            $preentrytime = strtotime($value['preentrytime']);
            if(!empty($preentrytime)){
                $data['user'][$key]['retention_time'] = retentionTimes($preentrytime);
            }else{
                $data['user'][$key]['retention_time'] = '';
            }
        }
        $userJobInfo = $positionService->position();
        $this->assign('userJobInfos',$userJobInfo);
        $this->assign('timetypes',$timetypes);
        $this->assign('userInfo', $data['user']);
        $this->assign('pages', $data['page']);
        $this->assign('params', $params);
        $this->assign('statusTotals', $data['statusTotals']);
        $this->assign('allOrg', $this->userService->getOrgAll());
        return parent::fetchAuto();
    }

    /**
     * 已入职
     * @return string
     * @throws \Exception
     */
    public function work() : string
    {
        $positionService = new Position();
        $params = array_merge(input('get.'), input('post.'));
        //有些字段需要默认
        if (!isset($params['org_id'])) $params['org_id'] = '';
        if (!isset($params['job_id'])) $params['job_id'] = '';
        if (!isset($params['pact_type'])) $params['pact_type'] = 100;
        if (!isset($params['room'])) $params['room'] = 100;
        if (!isset($params['ready_computer'])) $params['ready_computer'] = 100;
        if (!isset($params['searchKey'])) $params['searchKey'] = 1;
        if (!isset($params['searchValue'])) $params['searchValue'] = '';
        if (!isset($params['start_time'])) $params['start_time'] = '';
        if (!isset($params['end_time'])) $params['end_time'] = '';
        if (!isset($params['timetype'])) $params['timetype'] = 1;
        $params['status'] = 1;
        $data = $this->userService->getInfo($params);

        $userJobInfo = $positionService->position();
        $this->assign('userJobInfos',$userJobInfo);
        $this->assign('userInfo', $data['user']);
        $this->assign('pages', $data['page']);
        $this->assign('params', $params);
        $this->assign('statusTotals', $data['statusTotals']);
        $this->assign('allOrg', $this->userService->getOrgAll());
        return parent::fetchAuto();
    }

    /**
     * 离职
     * @return string
     * @throws \Exception
     */
    public function leave() : string
    {
        $positionService = new Position();
        $params = array_merge(input('get.'), input('post.'));
        //有些字段需要默认
        if (!isset($params['status'])) $params['status'] = 3;
        if (!isset($params['org_id'])) $params['org_id'] = '';
        if (!isset($params['job_id'])) $params['job_id'] = '';
        if (!isset($params['pact_type'])) $params['pact_type'] = 100;
        if (!isset($params['room'])) $params['room'] = 100;
        if (!isset($params['ready_computer'])) $params['ready_computer'] = 100;
        if (!isset($params['searchKey'])) $params['searchKey'] = 1;
        if (!isset($params['searchValue'])) $params['searchValue'] = '';
        $data = $this->userService->getInfo($params);
        $userJobInfo = $positionService->position();
        $this->assign('userJobInfos',$userJobInfo);
        $this->assign('userInfo', $data['user']);
        $this->assign('pages', $data['page']);
        $this->assign('params', $params);
        $this->assign('statusTotals', $data['statusTotals']);
        $this->assign('allOrg', $this->userService->getOrgAll());
        return parent::fetchAuto();
    }

    /**
     * @name    回收站
     * @author  jason
     * @date  2019-03-28 08:40:29
     * @return string
     * @throws \Exception
     */
    public function recycle() : string
    {
        $positionService = new Position();
        $params = array_merge(input('get.'), input('post.'));
        //有些字段需要默认
        if (!isset($params['status'])) $params['status'] = 9;
        if (!isset($params['org_id'])) $params['org_id'] = '';
        if (!isset($params['job_id'])) $params['job_id'] = '';
        if (!isset($params['pact_type'])) $params['pact_type'] = 100;
        if (!isset($params['room'])) $params['room'] = 100;
        if (!isset($params['ready_computer'])) $params['ready_computer'] = 100;
        if (!isset($params['searchKey'])) $params['searchKey'] = 1;
        if (!isset($params['searchValue'])) $params['searchValue'] = '';
        $data = $this->userService->getInfo($params);

        $userJobInfo = $positionService->position();
        $this->assign('userJobInfos',$userJobInfo);
        $this->assign('userInfo', $data['user']);
        $this->assign('pages', $data['page']);
        $this->assign('params', $params);
        $this->assign('statusTotals', $data['statusTotals']);
        $this->assign('allOrg', $this->userService->getOrgAll());
        return parent::fetchAuto();
    }

    /**
     * 添加
     * @return string
     */
    public function add() : string
    {
        $room = $this->room;
        $pact_type = $this->pact_type;
        $ready_computer = $this->ready_computer;
        unset($ready_computer[100]);
        unset($pact_type[100]);
        unset($room[100]);
        $this->assign('rooms', $room);
        $this->assign('pact_types', $pact_type);
        $this->assign('ready_computers', $ready_computer);
        return parent::fetchAuto();
    }

    /**
     * @name 添加或编辑用户
     * @author  jason
     * @date  2019-03-28 05:58:24
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function edit():string
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $par = $this->request->get();
            $addType = $par['addType'];
            $id = $par['id'] ?? '';
            return $this->result($this->userService->editUser($id, $this->request->post(), $addType),
                $this->userService->getCodes(),
                $this->userService->getErrors());
        }
        $par = $this->request->get();
        $id = $par['id'];
        $info = $this->userService->getUser($id);
        $info['preentrytime'] = !empty($info['preentrytime']) ? date('Y-m-d H:i:s', $info['preentrytime']) : '';
        $info['proceduretime'] = !empty($info['proceduretime']) ? date('Y-m-d H:i:s', $info['proceduretime']) : '';
        $room = $this->room;
        $pact_type = $this->pact_type;
        $ready_computer = $this->ready_computer;
        unset($ready_computer[100]);
        unset($pact_type[100]);
        unset($room[100]);
        $this->assign('rooms', $room);
        $this->assign('pact_types', $pact_type);
        $this->assign('ready_computers', $ready_computer);
        $this->assign('userInfo', $info);
        return parent::fetchAuto();
    }

    /**
     * @name    编辑用户 ，权限标签，权限的相关的数据
     * @author  jason
     * @date  2019-04-02 09:10:47
     * @return string|void
     * @throws \Exception
     */
    public function editrule()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {

            return $this->result($this->userService->editrule($this->request->post()),
                $this->userService->getCodes(),
                $this->userService->getErrors());
        }
        $positionService = new Position();
        $userJobInfo = $positionService->position();
        $par = $this->request->get();
        $saveType = $par['saveType'];
        $ids = $par['ids'];
        $this->assign('ids', $ids);
        //如果是单个编辑的话
        if ($saveType == 'all') {
            $userInfo = $this->userService->getUser($ids);
            $status = $par['status'] ?? '';
            //权限标签
            $urles_id = explode(',', trim($userInfo['rules_id'], ','));
            $userInfo['rules_id'] = $urles_id;
            //可登录系统
            $userInfo['allow'] = explode(',', $userInfo['allow']);
            $userInfo['status_value'] = $status;
            //新用户的过期授权时间
            $new_user_auth_time = Config::get('site.new_user_auth_time');
            //授权过期天数
            $auth_day = $new_user_auth_time * 86400;
            //(当前的时间 - 授权时间）
            $authtime = $userInfo['authtime'];
            $curtime = time();
            //之前授权的时间到现在已经是多少天了
            $times = $curtime-$authtime;
            if($auth_day < $times){
                $time_type = 1;
            }else{
                $time_type = 0;
            }

            $userInfo['time_type'] = $time_type;
            $this->assign('userInfo', $userInfo);
        }
        $this->assign('userJobInfos',$userJobInfo);
        $this->assign('saveType', $saveType);
        return parent::fetchAuto();
    }

    /**
     * @name    批量 转待处理
     * @author  jason
     * @date  2019-04-01 10:39:06
     */
    public function pending()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $par = $this->request->get();
            $statusValue = $par['statusValue'];
            return $this->result($this->userService->pending($statusValue, $this->request->post()),
                $this->userService->getCodes(),
                $this->userService->getErrors());
        }
        $this->error(__('Request Error'));
    }

    /**
     * @name:删除
     * @author: jason
     * @date: 2019-03-28 04:35:01
     */
    public function del()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $par = $this->request->get();
            $pa = $this->request->post();
            $status = $par['status'];
            $ids = $pa['ids'];
            return $this->result($this->userService->del($status, $ids),
                $this->userService->getCodes(),
                $this->userService->getErrors());
        }
        $this->error(__('Request Error'));
    }

    public function savenote()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            return $this->result($this->userService->saveNote($this->request->post()),
                $this->userService->getCodes(),
                $this->userService->getErrors());
        }
        $this->error(__('Request Error'));
    }

    /**
     * @name    登录日志
     * @author  jason
     * @date  2019-04-09 08:47:39
     * @return string
     * @throws \Exception
     */
    public function showlog()
    {
        $logInfo = $this->userService->showlog($this->request->get());
        $this->assign('list', $logInfo['info']);
        $this->assign('page', $logInfo['page']);
        return parent::fetchAuto();
    }
}

<?php
/**
 * @Copyright (C), ZhuoShi.
 * @Author: 杨能文
 * @Name: Organization.php
 * @Date: 2019/4/8
 * @Time: 9:45
 * @Description
 */

namespace app\v1\controller\group;

use app\common\controller\AuthController as Controller;
use app\v1\service\Department;
use app\v1\service\Tag;
use think\Request;

/**
 * 成员管理
 * Class Organization
 * @package app\v1\controller\group
 */
class Organization extends Controller
{

    /**
     * @var null 成员服务层
     */
    private $organizationService = null;

    /**
     * @var null 部门服务层
     */
    private $departmentService = null;

    /**
     * @var null 权限标签服务层
     */
    private $tagService = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->organizationService = new \app\v1\service\Organization();
        $this->departmentService = new Department();
        $this->tagService = new Tag();
    }

    /**
     * @desc 组织架构列表
     * @author 杨能文
     * @date 2019/4/8 9:46
     * @access public
     * @return string
     */
    public function index():string
    {
        $params = input('param.');
        $params['org_id'] = isset($params['org_id']) ? $params['org_id'] : 0;
        $params['status'] = isset($params['status']) ? $params['status'] : 1;
        $params['binding'] = isset($params['binding']) ? $params['binding'] : '';
        $params['user_name'] = isset($params['user_name']) ? $params['user_name'] : '';
        $params['account'] = isset($params['account']) ? $params['account'] : '';

        $organizationService = $this->organizationService;
        $data = $organizationService->list($params);
        $this->assign('data', $data['list']['data']);
        $this->assign('page', $data['page']);

        $this->assign('orgleft', $this->organizationService->orglists($params['org_id']));
        $this->assign('adaptive', '');
        $this->assign('params', $params);
        $this->assign('url', url('index'));

        return parent::fetchAuto();
    }

    /**
     * @desc 添加组织架构成员
     * @author 杨能文
     * @date 2019/4/9 14:26
     * @access public
     * @return string
     * @throws \Exception
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $organizationService = $this->organizationService;
            if ($organizationService->add($this->request->post())) {
                $this->success(__('新增成员成功'));
            }
            $this->error($organizationService->errorsMessages);
        } else {
            $departmentService = $this->departmentService;
            $this->assign('saleUser', $departmentService->alluser());
            $this->assign('org_id', input('param.org_id'));

            return $this->view->fetch();
        }
    }


    /**
     * @desc 编辑成员(帐号绑定)
     * @author 杨能文
     * @date 2019/4/10 17:37
     * @access public
     * @return string
     * @throws \Exception
     */
    public function edit()
    {
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->edit($this->request->post())) {
                $this->success(__('编辑成员成功'));
            }
            $this->error($organizationService->errorsMessages);
        } else {
            $id = input('param.id');
            $info = $organizationService->getinfo($id);
            $this->assign('info',$info);
            $this->assign('org_id', $info['org_id'] ?? 0);
            $this->assign('accountInfo',$organizationService->useraccount($info['org_id'],$info['user_id'])); //绑定的帐号
            return $this->view->fetch();
        }
    }

    /**
     * @desc 新增帐号
     * @author 杨能文
     * @date 2019/4/26 9:47
     * @access public
     * @return string
     * @throws \Exception
     */
    public function addaccount(){
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->addAccount($this->request->post())) {
                $this->success(__('新增帐号成功'));
            }
            $this->error($organizationService->errorsMessages);
        } else {
            $departmentService = $this->departmentService;
            $this->assign('storeArr',$organizationService->getAllStore()); //所有仓库
            $this->assign('locationArr',$organizationService->getAllLocation()); //所有的location
            $this->assign('saleArr',$departmentService->saleuser()); //所有的销售标签
            $this->assign('platformAccountArr',$organizationService->getPlatformAccount());
            $this->assign('bindAccount',$organizationService->getAllBindAccount());
            $this->assign('params',input('param.'));
            return $this->view->fetch('add_account');
        }
    }

    /**
     * @desc 批量新增帐号
     * @author 杨能文
     * @date 2019/4/27 9:22
     * @access public
     * @return string
     * @throws \Exception
     */
    public function batchaccount(){
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->addAccount($this->request->post())) {
                $this->success(__('新增帐号成功'));
            }
            $this->error($organizationService->errorsMessages);
        } else {
            $this->assign('platformAccountArr',$organizationService->getPlatformAccount());
            $this->assign('params',input('param.'));
            return $this->view->fetch('batch_account');
        }
    }

    /**
     * @desc 编辑帐号
     * @author 杨能文
     * @date 2019/4/26 9:47
     * @access public
     * @return string
     * @throws \Exception
     */
    public function editaccount(){
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->editAccount($this->request->post())) {
                $this->success(__('编辑帐号成功'));
            }
            $this->error($organizationService->errorsMessages);
        }else{
            $accountId  = input('param.id');
            $accountInfo= $organizationService->getAccountById($accountId);
            $departmentService = $this->departmentService;
            $this->assign('storeArr',$organizationService->getAllStore()); //所有仓库
            $this->assign('locationArr',$organizationService->getAllLocation()); //所有的location
            $this->assign('saleArr',$departmentService->saleuser()); //所有的销售标签
            $this->assign('platformAccountArr',$organizationService->getPlatformAccount());
            $this->assign('accountArr',$organizationService->getAccount($accountInfo['platform']));
            $this->assign('bindAccount',$organizationService->getAllBindAccount($accountInfo['platform_account']));
            $this->assign('accountInfo',$accountInfo);
            return $this->view->fetch('edit_account');
        }
    }

    /**
     * @desc 移除帐号
     * @author 杨能文
     * @date 2019/4/26 16:12
     * @access public
     */
    public function moveaccount(){
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->moveAccount($this->request->post())) {
                $this->success(__('移除帐号成功'));
            }
            $this->error($organizationService->errorsMessages);
        }
    }

    /**
     * @desc 查看成员帐号
     * @author 杨能文
     * @date 2019/4/25 10:15
     * @access public
     * @return string
     * @throws \Exception
     */
    public function cat(){
        $id = input('param.id');
        $organizationService = $this->organizationService;
        $info = $organizationService->getinfo($id);
        $this->assign('info',$info);
        $this->assign('accountInfo',$organizationService->useraccount($info['org_id'],$info['user_id']));
        $this->assign('org_id', $info['org_id'] ?? 0);
        return $this->view->fetch();
    }

    /**
     * @desc 复制组织架构成员
     * @author 杨能文
     * @date 2019/4/10 17:37
     * @access public
     * @return string
     * @throws \Exception
     */
    public function copy()
    {
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->copy($this->request->post())) {
                $this->success(__('复制成员成功'));
            }
            $this->error($organizationService->errorsMessages);
        } else {
            $id = input('param.id');
            $departmentService = $this->departmentService;
            $this->assign('info', $organizationService->getinfo($id));
            $this->assign('saleUser', $departmentService->alluser());
            $this->assign('org_id', input('param.org_id'));

            return $this->view->fetch();
        }
    }

    /**
     * @desc 禁用成员
     * @author 杨能文
     * @date 2019/4/11 14:59
     * @access public
     */
    public function forbid()
    {
        $organizationService = $this->organizationService;
        if (Request::instance()->isPost()) {
            if ($organizationService->forbid($this->request->post())) {
                $this->success(__('禁用成员成功'));
            }
            $this->error($organizationService->errorsMessages);
        }
    }

    /**
     * @desc 查看location
     * @author 杨能文
     * @date 2019/4/17 13:35
     * @access public
     */
    public function catlocation(){
        $location = input('param.location');
        $location = array_chunk(explode('*',$location),2);
        $this->assign('location',$location);
        return $this->view->fetch('location');
    }

    /**
     * @desc 查看销售标签
     * @author 杨能文
     * @date 2019/4/25 9:46
     * @access public
     * @return string
     * @throws \Exception
     */
    public function catlabel(){
        $label = input('param.label');
        $label = array_chunk(explode(',',$label),4);
        $this->assign('label',$label);
        return $this->view->fetch('label');
    }
}
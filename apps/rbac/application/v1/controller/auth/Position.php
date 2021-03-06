<?php
/**
 * @Copyright (C), ZhuoShi.
 * @Author: 杨能文
 * @Name: Position.php
 * @Date: 2019/3/29
 * @Time: 15:47
 * @Description
 */

namespace app\v1\controller\auth;

use app\common\controller\AuthController as Controller;
use think\Request;

/**
 * 岗位管理
 * Class Position
 * @package app\v1\controller\auth
 */
class Position extends Controller
{
    /**
     * @var null 岗位服务层
     */
    private $positionService = null;

    /**
     * @var null 部门服务层
     */
    private $departmentService = null;
    
    public function _initialize()
    {
        parent::_initialize();
        $this->positionService = new \app\v1\service\Position();
        $this->departmentService = new \app\v1\service\Department();
    }

    /**
     * @desc 岗位管理
     * @return string
     * @throws \Exception
     * @author 杨能文
     * @date 2019/3/30 13:01
     * @access public
     */
    public function index(): string
    {
        $positionService = $this->positionService;
        $this->assign('data', $positionService->position());
        return parent::fetchAuto();
    }

    /**
     * @desc 添加岗位
     * @return mixed
     * @throws \Exception
     * @author 杨能文
     * @date 2019/4/1 9:42
     * @access public
     */
    public function add()
    {
        $positionService = $this->positionService;
        // 提交请求
        if ($this->request->isPost()) {
            if ($positionService->add($this->request->post())) {
                $this->success(__("添加岗位成功"));
            }
            $this->error($positionService->errorsMessages);
        }

        $data = $positionService->position();
        $departmentService = $this->departmentService;
        $user = $departmentService->alluser();
        $bindUserId = $positionService->getBindPosId();
        $this->assign('bindUserId', $bindUserId);
        $this->assign('user', $user);
        $this->assign('positionArr', $data);

        return parent::fetchAuto();
    }

    /**
     * @desc 编辑岗位
     * @return string
     * @throws \Exception
     * @author 杨能文
     * @date 2019/3/30 12:57
     * @access public
     */
    public function edit()
    {
        $positionService = $this->positionService;
        if (Request::instance()->isAjax()) {
            if ($positionService->edit($this->request->post())) {
                $this->success(__("编辑岗位成功"));
            }
            $this->error($positionService->errorsMessages);
        } else {
            $id = input('param.id');
            $data = $positionService->position();
            $info = $positionService->positioninfo($id);
            $idArr = $positionService->getson($id, 1);
            $userIdArr = $positionService->getPosUserId($id);
            $info['userId'] = $userIdArr;
            $departmentService = $this->departmentService;
            $user = $departmentService->alluser();
            $this->assign('user', $user);
            $this->assign('idArr', $idArr);
            $this->assign('info', $info);
            $this->assign('positionArr', $data);

            $bindUserId = $positionService->getBindPosId();
            $this->assign('bindUserId', $bindUserId);
            return parent::fetchAuto();
        }
    }

    /**
     * @desc 负责岗位
     * @return string
     * @throws \Exception
     * @author 杨能文
     * @date 2019/3/30 13:01
     * @access public
     */
    public function copy()
    {
        $positionService = $this->positionService;
        if (Request::instance()->isPost()) {
            if ($positionService->copy($this->request->post())) {
                $this->success(__("复制岗位成功"));
            }
            $this->error($positionService->errorsMessages);
        }
        $id = input('param.id');
        $data = $positionService->position();
        $info = $positionService->positioninfo($id);
        $this->assign('info', $info);
        $this->assign('positionArr', $data);

        return parent::fetchAuto();
    }

    /**
     * @desc 批量删除岗位
     * @author 杨能文
     * @date 2019/4/2 11:40
     * @access public
     */
    public function delete()
    {
        if (Request::instance()->isAjax()) {
            $positionService = $this->positionService;
            if ($positionService->delete($this->request->post())) {
                $this->success(__("批量删除岗位成功"));
            }
            $this->error($positionService->errorsMessages);
        }
    }


    /**
     * @desc 查看用户
     * @return string
     * @throws \Exception
     * @author 杨能文
     * @date 2019/4/2 14:53
     * @access public
     */
    public function cat(): string
    {
        $positionService = $this->positionService;
        $params = input('param.');
        $params['username'] = isset($params['username']) ? trim($params['username']) : '';
        $data = $positionService->cat($params);

        $this->assign('page', $data['page']);
        $this->assign('list', $data['list']);
        $this->assign('params', $params);

        return parent::fetchAuto();
    }

    /**
     * @desc 移除用户
     * @author 杨能文
     * @date 2019/4/2 17:24
     * @access public
     */
    public function move()
    {
        if (Request::instance()->isAjax()) {
            $positionService = $this->positionService;
            $params = input('param.');
            if ($positionService->move($params)) {
                $this->success(__("移除用户成功"));
            }
            $this->error($positionService->errorsMessages);
        }
    }
}
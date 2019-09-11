<?php

/**
 * 菜单控制器
 * User: wcd
 * Date: 2019/3/29
 * Time: 16:21
 */

namespace app\v1\controller\menus;

use app\common\controller\AuthController as Controller;
use think\Config;
use \app\v1\service\Menu;
use \app\v1\service\MenuDetail;
use \app\v1\service\Position;

/**
 * 菜单管理
 * Class Index
 * @package app\v1\controller\menus
 */
class Index extends Controller
{
    private $_menuService = null;
    private $_menuDedailService = null;
    /**
     * 所有系统(系统id => 名称）
     * @var array
     */
    private $_allowSystem = [];

    /**
     * 初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->_allowSystem = Config::get('site.allowSystem');
        $this->_menuService = new Menu();
        $this->_menuDedailService = new MenuDetail();
        $this->assign('menuFields', $this->_menuService->alowFields());
    }

    /**
     * 列表
     * @return string|void
     */
    public function index()
    {
        if ($this->request->isPost() || $this->request->isGet()) {
            $params = $this->request->param();
            if (!isset($params['module_id']) || empty($params['module_id'])) $params['module_id'] = 1;
            $menusTotals = $this->_menuService->getAllsystemMenus();
            $result = $this->_menuService->getMenuTree($params['module_id']);
            $this->assign('allowSystem', $this->_allowSystem);
            $this->assign('module_id', $params['module_id']);
            $this->assign('menusTotals', $menusTotals);
            $this->assign('menus', $result);

            return parent::fetchAuto('index');
        }

        return $this->error('页面找不到。', 'index/index');
    }

    /**
     * 查看菜单节点页面
     * @return string
     * @author wcd
     */
    public function detail()
    {
        $menu_id = $this->request->get('id');
        $detail = $this->_menuDedailService->getDetail(['menu_id' => $menu_id]);
        $this->assign('menuid', $menu_id);
        $this->assign('menudetail', $detail);

        return parent::fetchAuto('menudetail');
    }

    /**
     * 添加、编辑订单详情页面和编辑接口
     * @return array|string
     * @author wcd
     */
    public function editdetail()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $postData = $this->request->post();
            $result = $this->_menuDedailService->saveDetail($postData);
            if (!$result) {
                $this->error($this->_menuDedailService->getErrors());
            }
            $this->success(__('保存成功'));
        }
        $menuid = $this->request->get('menuid');
        $detailid = $this->request->get('id');
        $positionObj = new Position();
        $userJob = $positionObj->position();
        $detailInfo = $this->_menuDedailService->getOneDetail(['id' => $detailid], '', $detailid);
        $this->assign('userJob', $userJob);
        $this->assign('detailInfo', $detailInfo);
        $this->assign('detailid', $detailid);
        $this->assign('menuid', $menuid);

        return parent::fetchAuto('editdetail');
    }

    /**
     * 添加、编辑菜单页面和接口
     * @return array|string
     * @author wcd
     */
    public function edit()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {
            $post = $this->request->post();
            if ($this->_menuService->saveMenu($post)) {
                $this->success('保存成功');
            } else {
                $this->error($this->_menuService->getErrors());
            }
        }
        $positionService = new Position();
        $moduleid = $this->request->get('module_id');
        if (!array_key_exists($moduleid, $this->_allowSystem)) exit('系统出错请重试。');
        $id = $this->request->get('id');
        $where = [];
        if ($id) {
            $where['id'] = $id;
        }
        $userJob = $positionService->position();
        $parentMenu = $this->_menuService->getMenuTree($moduleid);
        $granChild = array_merge([$id], $this->_menuService->getAllGranChild($moduleid));
        $menuInfo = $this->_menuService->getOneMenu($where);
        $this->assign('granChild', $granChild);
        $this->assign('userJob', $userJob);
        $this->assign('moduleid', $moduleid);
        $this->assign('menuInfo', $menuInfo);
        $this->assign('menuid', $id);
        $this->assign('parentMenu', $parentMenu);
        $this->assign('allowSystem', $this->_allowSystem);

        return parent::fetchAuto('add');
    }

    /**
     * 删除菜单
     * @return array
     * @author wcd
     */
    public function del()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {

            $postid = $this->request->post('id');
            if ($this->_menuService->delMenuByid($postid)) {
                $this->success(__('删除成功'));
            }
            $this->error($this->_menuService->getErrors());
        }
    }

    /**
     * 删除菜单详情
     * @return array
     * @author wcd
     */
    public function deldetail()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {
            $postid = $this->request->post('id');
            $result = $this->_menuDedailService->del(['id' => $postid]);
            if ($result) {
                $this->success(__('删除成功'));
            }
            $this->error($this->_menuDedailService->getErrors());
        }
    }

}
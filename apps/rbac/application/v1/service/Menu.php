<?php
/**
 * 菜单应用服务
 * User: wcd
 * Date: 2019/4/1
 * Time: 9:38
 */

namespace app\v1\service;

use app\common\model\Menus;
use app\common\model\Users;
use app\common\model\UsersJobAccess;
use app\common\model\UsersLabelAccess;
use app\common\model\UsersNotice;
use plugin\Tree;
use app\common\model\MenusDetail;
use think\Cache;
use \app\common\model\UsersJob;
use think\cache\driver\Redis;
use think\Config;
use think\Session;

class Menu extends Base
{
    private $_menusModel = null;
    private $_pageSize = 100;
    private $_treeKey = 'menu_tree';

    /**
     * Menu constructor.
     */
    public function __construct()
    {
        $this->_menusModel = new Menus();
    }

    /**
     * 字段说明
     * @return array
     */
    public static function alowFields()
    {
        return [
            'type' => [
                __('普通菜单'),
                __('特殊菜单'),
                __('节点'),
            ],
            'status' => [
                __('禁用'),
                __('正常'),
            ]
        ];
    }

    /**
     * 获取树状菜单
     * @param $moduleid
     * @return array|mixed
     */
    public function getMenuTree($moduleid)
    {
        $key = $this->_treeKey . $moduleid;
        $treeList = Cache::get($key);
        if (!$treeList) {
            $dataList = collection($this->_menusModel->where(['module_id'=> $moduleid])->order('weigh', 'desc')->select())->toArray();
            Tree::instance()->init($dataList);
            $treeList = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
            Cache::set($key, $treeList, 600);
        }
        return $treeList;
    }

    /**
     * 查询每个系统的菜单总数
     * @return array
     * @author wcd
     * @time 2019-4-8 13:21:01
     */
    public function getAllsystemMenus()
    {
        $sysTotal = $this->_menusModel->field("module_id,count('id') AS total")->group('module_id')->select()->toArray();
        if (!$sysTotal) return [];
        $result = [];
        foreach ($sysTotal as $value) {
            $result[$value['module_id']] = $value['total'];
        }
        return $result;
    }

    /**
     * 保存一条菜单数据
     * @param $params
     * @return mixed
     * @author wcd
     * @time 2019-4-1 18:28:47
     */
    public function saveMenu($params)
    {
        $icon = isset($params['icon']) ? $this->setIcon(trim($params['icon'])) : '';
        $save = [
            'module_id' => isset($params['module']) ? $params['module'] : 0,
            'type' => isset($params['type']) ? $params['type'] : 0,
            'pid' => isset($params['parentMenu']) ? $params['parentMenu'] : 0,
            'title' => isset($params['title']) ? $params['title'] : '',
            'url' => isset($params['url']) ? trim(trim($params['url']), '/') : '',
            'icon' => $icon,
            'remark' => isset($params['remark']) ? trim($params['remark']) : '',
            'weigh' => isset($params['weight']) ? (int)trim($params['weight']) : 0,
            'status' => isset($params['status']) ? $params['status'] : 0,
        ];
        $jobid = isset($params['send_job']) ? $params['send_job'] : '';
        $noticid = true;
        $this->_menusModel->startTrans();
        if (isset($params['menu_id']) && $params['menu_id']) {
            $menuid = (int)trim($params['menu_id']);
            $contentTip = '修改';
            if ($save['pid'] > 0) {
                $haschild = $this->_menusModel->getAllColums(['pid' => $menuid], 'id');
                if ($haschild) {
                    if (in_array($save['pid'], $haschild)) {
                        $this->setErrors(0, '所选父类已是该菜单子类，不能选。');
                        return false;
                    }
                    $hasGrandchild = $this->_menusModel->getAllColums(['pid' => ['in', $haschild]], 'id');
                    if (in_array($save['pid'], $hasGrandchild)) {
                        $this->setErrors(0, '所选父类已是该菜单孙子类，不能选。');
                        return false;
                    }
                }
            }
            // 顶级菜单禁止设为特殊菜单
            if ($save['pid'] == 0 && $save['type'] == 1) {
                $this->setErrors(0, '最顶级菜单不能设为特殊菜单');
                return false;
            }
            // 菜单类型发生变更
            $this->updateMenuType($menuid, $save['type']);

            $save['updatetime'] = time();
            $where['id'] = $menuid;
            $resid = $this->_menusModel->update($save, $where);
        } else {
            $contentTip = '添加';
            $save['createtime'] = time();
            $resid = $this->_menusModel->save($save);
        }
        if ($jobid) {
            $noticeModel = new UsersNotice();
            $userModel = new Users();
            $userSession = json_decode(\plugin\Crypt::decrypt(Session::get('users')), true);
            $users = $userModel->where(['job_id' => $jobid, 'status' => 1])->select()->toArray();//在职人员
            if (!empty($users)) {
                foreach ($users as $val) {
                    $notice = [
                        'user_id' => $val['id'],
                        'username' => $val['username'],
                        'content' => "{$contentTip}了菜单【{$save['title']}】." . (trim($params['remark']) ?? '请关注此菜单的授权情况'),
                        'createuser' => $userSession['username'],
                        'createtime' => time()
                    ];
                    $noticid = $noticeModel->insert($notice);
                    if (!$noticid) break;
                }
            }
        }
        if ($resid && $noticid) {
            $this->_menusModel->commit();
            Cache::rm($this->_treeKey . $save['module_id']);
            return true;
        } else {
            $this->_menusModel->rollback();
            $this->setErrors(0, '保存失败。');
            return false;
        }
    }

    /**
     * 当菜单的类型发生变化时，调用此方法
     * @param $menu_id 菜单ID
     * @param $type 菜单类型
     * @return bool
     * @throws \think\exception\DbException
     */
    public function updateMenuType($menu_id, $type)
    {
        $menuData = Menus::get(['id' => $menu_id]);
        if (empty($menuData)) return false;
        // 没有发生变更
        if ($menuData->type == $type) return true;

        $tagService = new Tag();
        $tagUsers = $tagService->getTagUsers();
        // 从非特殊菜单转到特殊菜单, 回收这个菜单权限
        if ($menuData->type != 1 && $type == 1) {
            // 菜单下级全部变成特殊
            $subIds = $this->getSubMenuId($menuData->id);
            if (!empty($subIds)) {
                Menus::update(['type' => $type], ['id' => ['IN', $subIds]]);
            }

            // 岗位权限
            $jobAccess = UsersJobAccess::where(['module_id' => $menuData->module_id, 'menu_id' => $menuData->id])->column('id,job_id');
            $jobAccessIds = $jobIds = $userIds = [];
            if (empty($jobAccess)) {
                $jobAccessIds = array_keys($jobAccess);
                $jobIds = array_unique(array_values($jobAccess));
                if (!empty($jobIds)) {
                    $userIds = Users::where(['job_id' => ['IN', $jobIds]])->column('id');
                }
            }
            // 标签权限
            $labelAccess = UsersLabelAccess::where(['module_id' => $menuData->module_id, 'menu_id' => $menuData->id])->column('id,label_id');
            $labelAccessIds = $labelIds = [];
            if (empty($jobAccess)) {
                $labelAccessIds = array_keys($labelAccess);
                $labelIds = array_unique(array_values($labelAccess));
                if (!empty($labelIds)) {
                    foreach ($labelIds as $labelid) {
                        if (isset($tagUsers[$labelid])) {
                            $userIds = array_merge($userIds, $tagUsers[$labelid]);
                        }
                    }
                }
            }

            // 岗位权限回收
            if (count($jobAccessIds) > 0) {
                UsersJobAccess::where(['id' => ['IN', $jobAccessIds]])->delete();
            }
            // 标签权限回收
            if (count($labelAccessIds) > 0) {
                UsersLabelAccess::where(['id' => ['IN', $labelAccessIds]])->delete();
            }
            // 用户权限回收
            if (count($userIds) > 0) {
                foreach ($userIds as $user_id) {
                    // 将权限移除
                    \app\common\library\auth\Drive::instance()->clearAuth($user_id);
                }
            }
            return true;
        }
        // 从特殊菜单转到非特殊菜单
        if ($menuData->type == 1 && $type != 1) {
            // 菜单下级全部变成非特殊菜单
            $subIds = $this->getSubMenuId($menuData->id);
            if (!empty($subIds)) {
                Menus::update(['type' => $type], ['id' => ['IN', $subIds]]);
            }
        }
        return true;
    }

    /**
     * 查找下级菜单ID
     * @param $menu_id 菜单ID
     * @return array
     */
    private function getSubMenuId($menu_id)
    {
        $subIds = Menus::where(['pid' => $menu_id])->column('id');
        if (empty($subIds)) return [];
        // 继续查找一级
        if (!empty($subIds)) {
            $subMenu = Menus::where(['pid' => ['IN', $subIds]])->column('id');
            if (!empty($subMenu)) $subIds = array_merge($subIds, $subMenu);
        }
        return array_unique($subIds);
    }

    /**
     * 图标处理 fa fa******。
     * @param $getIcon
     * @return string
     */
    private function setIcon($getIcon)
    {
        $subNum = substr_count($getIcon, 'fa ');
        if ($subNum == 0) {
            $getIcon = 'fa ' . $getIcon;
        } elseif ($subNum > 2) {
            $getIcon = trim(substr($getIcon, 2, strlen($getIcon) - 2));
        }
        return $getIcon;
    }

    /**
     * 编辑菜单
     * @param $where
     * @param $params
     * @return $this
     * @author wcd
     */
    public function editMenus($where, $params)
    {
        return $this->_menusModel->where($where)->update($params);
    }

    /**
     * 前端页面获取一条菜单
     * @param array $where
     * @param string $field
     * @return array
     * @author wcd
     */
    public function getOneMenu($where = [], $field = '*')
    {
        if (empty($where)) {
            return [
                'id'  => '',
                'module_id' => '',
                'type' => '',
                'pid' => '',
                'title' => '',
                'url' => '',
                'icon' => '',
                'remark' => '',
                'weigh' => '',
                'status' => '',
                'updatetime' => ''
            ];
        };
        return $this->_menusModel->where($where)->field($field)->find()->toArray();
    }

    /**
     * 根据菜单id删除菜单
     * @param $id
     * @return array
     * @author wcd
     */
    public function delMenuByid($id)
    {
        $menus = $this->_menusModel->getOne(['id' => $id]);
        if (!$menus) {
            $this->setErrors(0, '不存在该菜单。');
            return false;
        }
        $grandChild = [];
        $hasChild = $this->_menusModel->where(['pid' => $id])->column('id');//子
        if (!empty($hasChild)) {
            $grandChild = $this->_menusModel->whereIn('pid', $hasChild)->column('id');//孙
        }
        $delIdArr = array_merge([$id], $hasChild, $grandChild);//一家三代
        $menuDetail = new MenusDetail();
        $this->_menusModel->startTrans();
        $resid = $this->_menusModel->delByWhere(['id' => ['in', $delIdArr]]);
        if (!$resid) {
            $this->_menusModel->rollback();
            $this->setErrors(0, '删除失败。');
            return false;
        }
        $resid = $menuDetail->where(['menu_id' => ['in', $delIdArr]])->delete();
        if ($resid === false) {
            $this->_menusModel->rollback();
            $this->setErrors(0, '删除菜单详情失败。');
            return false;
        }
        $this->_menusModel->commit();
        Cache::rm($this->_treeKey . $menus['module_id']);
        return true;
    }

    /**
     * 所有三级菜单
     * @param $moduleid
     * @return array
     */
    public function getAllGranChild($moduleid)
    {
        $granChild = [];
        $childid = $this->_menusModel->where(['pid' => ['gt', 0],'module_id'=> $moduleid])->column('id');
        if($childid){
            $granChild = $this->_menusModel->where(['pid' => ['in', $childid],'module_id'=> $moduleid])->column('id');
        }
        return $granChild;
    }
}
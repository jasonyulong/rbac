<?php
/**
 * Created by PhpStorm.
 * User: wcd
 * Date: 2019/4/2
 * Time: 19:28
 */

namespace app\v1\service;

use app\common\model\MenusDetail;
use app\common\model\Menus;
use app\common\model\UsersNotice;
use app\common\model\Users;
use think\Session;

class MenuDetail extends Base
{
    private $_menuDetailModel = null;

    /**
     * MenuDetail constructor.
     */
    public function __construct()
    {
        $this->_menuDetailModel = new MenusDetail();
    }

    /**
     * @param array $where
     * @return array
     */
    public function getDetail($where = [])
    {
        if (empty($where)) return [];
        return $this->_menuDetailModel->getDetail($where);
    }

    /**
     * 前端页面获取一条节点数据
     * @param array $where
     * @param string $field
     * @param string $isdetail
     * @return array
     * @author wcd
     */
    public function getOneDetail($where = [], $field = '*', $isdetail = '')
    {
        if (empty($where) || !$isdetail) {
            return [
                'id' => '',
                'module_id' => '',
                'title' => '',
                'type' => '',
                'menu_id' => '',
                'url' => '',
                'condition' => '',
                'weigh' => '',
                'status' => '',
                'createtime' => 0,
                'updatetime' => 0,
                'is_special' => 0
            ];
        }
        return $this->_menuDetailModel->getOne($where, $field);
    }

    /**
     * 新增和更新菜单详情
     * @param $params
     * @return false|int
     * @author wcd
     */
    public function saveDetail($params)
    {
        $menu_id = trim($params['menuid']);
        if (empty($menu_id)) return false;
        $saveData = [
            'title' => trim($params['title']),
            'type' => $params['type'],
            'url' => trim(trim($params['url']), '/'),
            'condition' => trim($params['condition']),
            'weigh' => $params['weight'],
            'status' => $params['status'],
            'is_special' => $params['special']
        ];
        $jobid = isset($params['send_job']) ? $params['send_job'] : '';
        if ($saveData['type'] == 1) {
            $saveData['url'] = '';
        } else {
            $saveData['condition'] = '';
        }
        $menusModel = new Menus();
        $menu = $menusModel->getOne(['id' => intval($menu_id)], 'id,module_id,title');
        $noticid = true;
        $this->_menuDetailModel->startTrans();
        if (!isset($params['detailid']) || !$params['detailid']) {
            $contentTip = '添加';
            $saveData['module_id'] = $menu['module_id'];
            $saveData['menu_id'] = (int)$menu_id;
            $saveData['createtime'] = time();
            $resid = $this->_menuDetailModel->save($saveData);
        } else {
            $contentTip = '修改';
            $where['id'] = (int)$params['detailid'];
            $saveData['updatetime'] = time();

            $resid = $this->_menuDetailModel->editDetail($where, $saveData);
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
                        'content' => "在菜单[{$menu['title']}] 中{$contentTip}了节点菜单：{$saveData['title']}",
                        'createuser' => $userSession['username'],
                        'createtime' => time()
                    ];
                    $noticid = $noticeModel->insert($notice);
                    if (!$noticid) break;
                }
            }
        }
        if ($resid && $noticid) {
            $this->_menuDetailModel->commit();
            return true;
        } else {
            $this->_menuDetailModel->rollback();
            $this->setErrors(0, '保存失败');
            return false;
        }
    }

    /**
     * 删除操作
     * @param array $where
     * @return bool|int
     */
    public function del($where = [])
    {
        if (empty($where)) {
            $this->setErrors(0, '请选择条件删除。');
            return false;
        };
        $resid = $this->_menuDetailModel->where($where)->delete();
        if (!$resid) {
            $this->setErrors(0, '删除失败。');
            return false;
        }
        return true;
    }
}
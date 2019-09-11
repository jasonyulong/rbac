<?php
// +----------------------------------------------------------------------
// | 用户管理控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\v1\controller\system;

use app\common\controller\AuthController as Controller;

class Index extends Controller
{
    /**
     * 查看
     * @return string
     */
    public function index()
    {
        // $this->assignconfig(['jsname' => '']);
        return parent::fetchAuto();
    }

    /**
     * 添加
     * @return string
     */
    public function add()
    {
        return parent::fetchAuto();
    }

    /**
     * 编辑
     * @param $ids 编辑ID
     * @return string
     */
    public function edit($ids = null)
    {
        if (!$ids) {
            $this->error(__("Request Error"));
        }

        return parent::fetchAuto();
    }

    /**
     * 删除
     * @return string
     */
    public function del()
    {
        $ids = $this->request->post('id');
        if (!$ids || !$this->request->isPost()) {
            $this->error(__("Request Error"));
        }

        return parent::fetchAuto();
    }
}

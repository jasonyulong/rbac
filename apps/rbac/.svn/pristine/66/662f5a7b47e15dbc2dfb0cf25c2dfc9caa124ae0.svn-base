<?php
// +----------------------------------------------------------------------
// | 1.0版本
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\api\controller\v1;

use think\Config;
use think\Cookie;
use app\common\controller\ApiController;

/**
 * 首页接口
 * Class Index
 * @package app\api\controller
 */
class Index extends ApiController
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     */
    public function index()
    {
        $this->success('Success', ['version' => '1.0', 'name' => 'rbac']);
    }
}

<?php
// +----------------------------------------------------------------------
// | 登录退出控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\v1\controller;

use app\common\controller\PublicController as Controller;

class Ajax extends Controller
{
    protected $noNeedLogin = ['lang'];
    protected $noNeedRight = ['*'];
    protected $layout = '';

    /**
     * 初始化
     */
    public function _initialize()
    {
        parent::_initialize();

        //设置过滤方法
        $this->request->filter(['strip_tags', 'htmlspecialchars']);
    }

    /**
     * 加载语言包
     * @return \think\response\Jsonp
     */
    public function lang()
    {
        header('Content-Type: application/javascript');
        $controllername = input("controllername");
        //默认只加载了控制器对应的语言名，你还根据控制器名来加载额外的语言包
        $this->loadlang($controllername);
        return jsonp(Lang::get(), 200, [], ['json_encode_param' => JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE]);
    }
}

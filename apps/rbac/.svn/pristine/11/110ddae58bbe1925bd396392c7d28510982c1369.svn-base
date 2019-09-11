<?php
// +----------------------------------------------------------------------
// | 环境设置文件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

// 版本判断
if (PHP_VERSION < 7) {
    exit('PHP版本过低，请升级PHP版本. (http://www.php.net/downloads.php)') . PHP_EOL;
}

// +----------------------------------------------------------------------
// | 环境设置  开发环境=development    测试环境=test    生产环境=production
// +----------------------------------------------------------------------

//开发环境
define('ENVIRONMENT', 'development');

//测试环境
//define('ENVIRONMENT', 'test');

//生产环境
//define('ENVIRONMENT', 'production');

// 配置文件目录
define('CONFIG_PATH', __DIR__ . '/config/' . ENVIRONMENT . '/');

// 应用常量配置文件
require_once sprintf("%sconstant.php", CONFIG_PATH);
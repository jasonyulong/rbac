<?php
// +----------------------------------------------------------------------
// | 路由中心
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------
// $Id$

if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
    return false;
} else {
    if (!isset($_SERVER['PATH_INFO'])) {
        $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
    }
    require __DIR__ . "/index.php";
}

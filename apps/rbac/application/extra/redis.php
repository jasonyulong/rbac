<?php
// +----------------------------------------------------------------------
// | redis 键名配置
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

return [
    /**
     * 新进系统的订单存储 hash, 分平台存储，如：erp:orderpull:ebay:201809
     * 数据格式：array(['order' => {订单数据}, 'detail' => {订单SKU详情数据}])
     */
    'ordes_pull' => 'erp:orderpull:%s:%s',
    /**
     * API用户登录TOKEN, hset
     * 数据格式：用户ID 用户Token
     */
    'user_token' => 'rbac:user:token',
    'user_login' => 'rbac:user:login',
    'user_power' => 'rbac:user:power',
    /**
     * 用户所有权限, 临时存储 哈希格式 分系统存储
     */
    'user_power_all' => 'rbac:user:powers:all:%s',

    // 订单状态
    'erp_topmenu' => 'rbac:erptopmenu',

    // 简单的用户信息
    'all_erp_users' => 'erp:users:all',
    'all_erp_accounts' => 'erp:accounts:all',
    'all_erp_stores' => 'erp:stores:all',
    'all_erp_store_kv' => 'erp:store:kv',
    'all_erp_location' => 'erp:store:location',
    'all_erp_platform_account' => 'erp:platform:account',
];

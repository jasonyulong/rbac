<?php
// +----------------------------------------------------------------------
// | Token授权中心
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\common\library\auth;

use plugin\Crypt;
use think\Config;
use think\Env;

/**
 * 通过token授权
 * Class Token
 * @package app\common\library\auth
 */
class Token extends Drive
{
    private $accessService = null;

    /**
     * 设置TOKEN执行登录
     * @param $token Token
     * @return bool
     */
    public function setToken($token)
    {
        if ($this->_logined) {
            return true;
        }

        $users = $this->decodeToken($token);
        if (empty($users)) return false;

        $tokenRedis = $this->redis->handler()->hget(Config::get('redis.user_token'), $users['id']);
        // 判断token是否存在
        if (!$tokenRedis || $tokenRedis != $token) {
            $this->logout();
            $this->setError('您的账户已重新登录, 您被强迫下线');

            return false;
        }
        $users = (object)$users;
        if ($users->expiretime < time()) {
            return false;
        }

        return $this->setUserLogin($users);
    }

    /**
     * 白名单校验
     * @return bool
     */
    public function forbiddenip()
    {
        if (Env::get('app.debug', true)) return true;

        $forbiddenips = explode("\n", Config::get('config.forbiddenip'));
        if (empty($forbiddenips)) {
            return true;
        }
        $ip = request()->ip();
        foreach ($forbiddenips as $ips) {
            if ($ip == trim($ips) || '*' == trim($ips)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 授权校验
     * @param $module_id 系统
     * @param $path 路径
     * @return bool
     * @throws \think\exception\DbException
     */
    public function check($module_id, $path)
    {
        // 岗位ID
        $jobId = $this->jobId;
        // 权限标签ID
        $rulesId = $this->getRulesId();
        // 超级管理员标签不校验权限
        if ($jobId == 1 || in_array(1, $rulesId)) {
            return true;
        }
        // 权限获取
        if (is_null($this->accessService)) {
            $this->accessService = new Access();
        }
        // 获取内存权限
        $userPowers = $this->accessService->getUserPowers();
        if (!empty($userPowers) && isset($userPowers['module_auth']['power'])) {
            return $userPowers['module_auth']['power'];
        }
        // 重新获取权限
        $access = $this->accessService->getAccess($this->id, $module_id, $jobId, $rulesId);
        if (empty($access)) return false;

        return in_array($path, $access);
    }
}
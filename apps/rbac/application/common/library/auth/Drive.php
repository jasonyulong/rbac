<?php
// +----------------------------------------------------------------------
// | 权限驱动
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace app\common\library\auth;

use app\common\model\Users;
use app\common\model\UsersLog;
use plugin\Crypt;
use think\cache\driver\Redis;
use think\Config;
use think\Cookie;
use think\Session;

class Drive
{
    // 静态对象
    protected static $instance = null;

    // 默认配置
    public $config = [];

    // 用户对象
    public $users = null;

    // 用户ID
    public $id = 0;

    // 用户姓名
    public $username = null;

    // 用户详细资料
    public $userinfo = [];

    //Token默认有效时长
    public $keeptime = 2592000;

    //当前请求uri
    public $requestUri = '';

    // 当前token
    public $token = null;

    // 当前是否登录状态
    public $_logined = false;

    // 组织架构ID
    public $orgId = 0;

    // 岗位ID
    public $jobId = 0;

    // 岗位属性
    public $jobType = 10;

    // 标签ID
    public $rulesId = [];

    // 错误提示
    protected $errorMessages = null;

    // redis句柄
    protected $redis = null;

    /**
     * 构造函数
     * @param array $options 参数
     */
    public function __construct($options = [])
    {
        if ($config = Config::get('user')) {
            $this->options = array_merge($this->config, $config);
        }
        $this->options = array_merge($this->config, $options);

        // 如果参数中有token，则直接赋值
        $token = $this->options['token'] ?? null;
        if (!empty($token)) {
            $this->setToken($token);
        }
        // 当前是否登录状态
        $this->_logined = $this->getUserInfo() ? true : false;
        $this->redis = new Redis(Config::get('cache.redis'));
    }

    /**
     * 静态入口
     * @param array $options 参数
     * @return Auth
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }

        return self::$instance;
    }

    /**
     * 魔术方法
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return $this->users->$name ?? null;
    }

    /**
     * 检测当前控制器和方法是否匹配传递的数组
     * @param array $arr 需要验证权限的数组
     * @return boolean
     */
    public function match($arr = []): bool
    {
        $request = \think\Request::instance();

        // 需要验证权限的数组
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr) {
            return false;
        }
        // 将数组所有值都转小写
        $arr = array_map('strtolower', $arr);
        // 是否存在
        if (in_array(strtolower($request->action()), $arr) || in_array('*', $arr)) {
            return true;
        }

        // 没找到匹配
        return false;
    }

    /**
     * 设置当前请求的URI
     * @param string $uri
     */
    public function setRequestUri($uri)
    {
        $this->requestUri = $uri;
    }

    /**
     * 判断是否登录
     * @return boolean
     */
    public function isLogin(): bool
    {
        if ($this->_logined) {
            return true;
        }
        $users = Session::get('users');
        if ($users) {
            $users = json_decode(Crypt::decrypt($users));
            if ($this->autologin($users)) {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * 帐号密码登录
     * @param $username 姓名
     * @param $password 密码
     * @param $keeptime 登录时长
     * @return bool
     */
    public function login($username, $password, $keeptime): bool
    {
        if (is_numeric($username)) {
            $users = Users::get(['id' => intval($username)]);
        } else {
            $users = Users::get(['username' => trim($username)]);
        }
        if (!$users) {
            $this->setError('账号输入错误,请重新输入');

            return false;
        }
        if ($users->status != 1) {
            $this->setError('此账号禁止登录,请联系账号组');

            return false;
        }
        $allows = [];
        if (!empty($users->allows)) {
            $allows = array_column($users->allows->toArray(), 'module_id');
        }
        //if ($users->username != 'vipadmin' && !in_array(Config::get('app.system_id'), $allows)) {
        //    $this->setError('此账号禁止登录此系统, 请联系账号组授权');
        //
        //    return false;
        //}
        if ($users->org_id <= 0 && $users->job_id <= 0) {
            $this->setError('此账号禁止登录,请联系上级完善组织架构信息');

            return false;
        }
        if ($users->maturitytime < time()) {
            $this->setError('此账号授权已过期, 请联系上级授权');

            return false;
        }
        $loginfailure = intval(Config::get('site.loginfailure'));
        if ($users->loginfailure >= $loginfailure && time() - strtotime($users->updatetime) < 86400) {
            $this->setError("登录失败超过{$loginfailure}次,请联系上级申请解绑");

            return false;
        }
        // 验证是否是老密码登录
        $oldPassLogin = false;
        //if ($users->password != $users->encryptPassword($password, $users->salt)) {
        //    $users->loginfailure++;
        //    $users->save();
        //    $this->setError('请输入正确的密码');
        //
        //    return false;
        //}

        // 用户token标识
        $token = $this->getToken($users, $keeptime);

        // 开始更新登录数据
        if ($oldPassLogin) {
            //$users->password = $users->encryptPassword($password, $users->salt);
        }
        $users->loginfailure = 0;
        $users->logintime = time();
        $users->loginip = \request()->ip();
        $users->token = $token;
        $users->save();

        // 写入登录日志
        $this->setLoginLog($users);

        return $this->setUserLogin($users);
    }

    /**
     * 执行登录，写入SESSION
     * @param $users 用户数据
     * @param null $keeptime 登录时长
     * @return bool
     */
    public function setUserLogin($users, $keeptime = null)
    {
        $this->users = $users;
        $this->username = $users->username;
        $this->id = $users->id;
        $this->jobId = $users->job_id;
        $this->orgId = $users->org_id;
        $this->jobType = $users->job_type;
        $this->token = $users->token;
        $this->rulesId = !empty($users->rules_id) ? explode(',', $users->rules_id) : $this->rulesId;
        $this->_logined = true;

        // 写入Session
        Session::set("users", \plugin\Crypt::encrypt([
            'id' => $users->id,
            'username' => $users->username,
            'token' => $users->token,
            'org_id' => $users->org_id,
            'job_id' => $users->job_id,
            'job_type' => $users->job_type,
            'rules_id' => $users->rules_id,
        ]));
        if (is_null($keeptime)) {
            $keeptime = Config::get('site.logintime');
        }

        Session::set('accesstime', time());
        Cookie::set('token', $users->token);
        Cookie::set('mustlogin', false);
        $this->keeplogin($keeptime);
        // 写入redis
        $this->redis->handler()->hset(Config::get('redis.user_token'), $users->id, $users->token);

        return true;
    }

    /**
     * 自动登录
     * @param $users 用户数据
     * @return bool
     */
    public function autologin($users = null)
    {
        $keeplogin = Cookie::get('keeplogin');
        if (!$keeplogin) {
            return false;
        }
        if (empty($users)) {
            $getUsers = Session::get('users');
            if (empty($getUsers)) return false;
            $users = json_decode(Crypt::decrypt($getUsers));
        }
        $token = $this->redis->handler()->hget(Config::get('redis.user_token'), $users->id);
        // 判断token是否存在
        if (!$token || $token != $users->token) {
            $this->logout();
            $this->setError('您的账户已重新登录, 您被强迫下线');

            return false;
        }

        list($id, $keeptime, $expiretime, $key) = explode('|', $keeplogin);
        if ($id && $keeptime && $expiretime && $key && $expiretime > time()) {
            //token有变更
            if ($key != md5(md5($id) . md5($keeptime) . md5($expiretime) . $users->token)) {
                return false;
            }
            $this->users = $users;
            $this->username = $users->username;
            $this->id = $users->id;
            $this->jobId = $users->job_id;
            $this->orgId = $users->org_id;
            $this->jobType = $users->job_type;
            $this->token = $users->token;
            $this->rulesId = !empty($users->rules_id) ? explode(',', $users->rules_id) : $this->rulesId;
            $this->_logined = true;

            return true;
        }

        return false;
    }

    /**
     * 退出登录
     * @return bool
     */
    public function logout()
    {
        if ($this->id > 0) {
            Users::update(['token' => ''], ['id' => $this->id]);
            $this->redis->handler()->hdel(Config::get('redis.user_token'), $this->id);
            // 清除用户缓存权限
            $this->clearAuth($this->id);
        }

        //设置登录标识
        $this->_logined = false;
        $this->users = null;
        $this->username = null;
        $this->id = 0;
        $this->jobId = 0;
        $this->orgId = 0;
        $this->jobType = 0;
        $this->token = '';
        $this->rulesId = [];

        Session::delete('users');
        Cookie::delete('token');
        Cookie::set('mustlogin', false);

        return true;
    }

    /**
     * 清除用户权限
     * @param $user_id 用户ID
     * @return bool
     */
    public function clearAuth($user_id)
    {
        $this->redis->handler()->hdel(Config::get('redis.user_power'), $user_id);

        $module_ids = \think\Config::get('site.allowSystem');
        foreach ($module_ids as $module_id => $module_name) {
            $this->redis->handler()->hdel(sprintf(Config::get('redis.user_power_all'), $module_id), $user_id);
        }
        return true;
    }

    /**
     * 刷新保持登录的Cookie
     * @param int $keeptime
     * @return bool
     */
    protected function keeplogin($keeptime = 0)
    {
        if ($keeptime) {
            $expiretime = time() + $keeptime;

            $key = md5(md5($this->id) . md5($keeptime) . md5($expiretime) . $this->token);
            $data = [$this->id, $keeptime, $expiretime, $key];
            $keeplogin = implode('|', $data);
            // 写入cookie
            Cookie::set('keeplogin', $keeplogin, 86400 * 30);

            return true;
        }

        return false;
    }

    /**
     * 标签ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRulesId()
    {
        if (!empty($this->rulesId)) {
            return $this->rulesId;
        }
        if (!$this->id) return [];

        $users = Users::where(['id' => $this->id])->field('id,username,rules_id')->find();
        if (empty($users)) return [];

        $this->rulesId = explode(',', $users->rules_id);

        return $this->rulesId;
    }

    /**
     * 获取登录用户信息
     * @return boolean
     */
    public function getUserInfo()
    {
        return (array)$this->users ?? [];
    }

    /**
     * 获取登录用户对象
     */
    public function getUser()
    {
        return $this->users ?? null;
    }

    /**
     * 设置错误信息
     * @param $messages
     */
    protected function setError($messages)
    {
        $this->errorMessages = $messages;
    }

    /**
     * 获取用户token
     * @param null $user 用户
     * @param $loginTime 登录时长
     * @return string
     */
    public function getToken($user = null, $loginTime)
    {
        if (empty($user)) {
            return '';
        }
        $accessToken = [
            $user->id,
            $user->username,
            $user->org_id,
            $user->job_id,
            $user->job_type,
            $user->rules_id,
            time(),
            strtotime("+{$loginTime} minute"),
            \plugin\Random::uuid()
        ];
        $keeplogin = implode("|", $accessToken);
        $token = Crypt::encrypt($keeplogin);

        return $token;
    }

    /**
     * 解析token
     * @param $token token
     * @return array|bool
     */
    public function decodeToken($token)
    {
        if (empty($token)) return [];

        $this->token = $token;

        $tokenStr = Crypt::decrypt($token);
        $tokenArr = explode('|', $tokenStr);
        if (empty($tokenArr) || count($tokenArr) < 9) return [];
        list($user_id, $username, $org_id, $job_id, $job_type, $rules_id, $logintime, $expiretime) = $tokenArr;

        return [
            'id' => $user_id,
            'username' => $username,
            'org_id' => $org_id,
            'job_id' => $job_id,
            'job_type' => $job_type,
            'rules_id' => $rules_id,
            'logintime' => $logintime,
            'expiretime' => $expiretime,
            'token' => $token,
        ];
    }

    /**
     * 设置登录日志
     * @return UsersLog
     */
    protected function setLoginLog($users = null)
    {
        return UsersLog::create([
            'user_id' => $users->id,
            'title' => __('登录'),
            'content' => __('在RBAC系统登录'),
            'createuser' => $users->username,
            'createtime' => time(),
        ]);
    }

    /**
     * 返回错误提示
     * @return mixed
     */
    public function getError()
    {
        return $this->errorMessages;
    }
}
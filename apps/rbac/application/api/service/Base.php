<?php
/**
 * 数据服务器层 基类
 * @copyright Copyright (c) 2018
 * @license   
 * @version   Beta 1.0
 * @author    mina
 * @date      2018-04-08
 */
namespace app\api\service;

use think\Config;
use plugin\Crypt;
use think\Cache;
use plugin\Tree;

use app\common\model\Users;
use app\common\library\auth\Drive;

/**
 * @desc 接口数据服务器层 基类
 * Class User
 * @package app\api\service
 */
class Base
{
	/**
	 * @desc  是否实例化
	 * @var   boolen
	 */
	protected static $instance;

	/**
	 * @desc  用户模型
	 * @var   object
	 */
	public $userModel;

	/**
	 * @desc  token 包含的用户信息
	 * @var 
	 */
	protected $user;

	/**
     * @desc  redis 对象
     * @var   object
     */
    protected $_redis;

	/**
	 * @desc  分页数量
	 * @var   int
	 */
	protected $pageSize = 50;

	/**
	 * @desc  
	 * @var 
	 */
	protected $drive;

	/**
	 * @desc  树形对象
	 * @var   object
	 */
	protected $tree;	

	/**
	 * @desc  
	 * @author mina
	 * @param  
	 * @return
	 */
	public function __construct()
	{
		$this->tree  = new Tree();
		$this->drive = new Drive();
		$this->userModel = new Users();
		$this->_redis = Cache::init(Config::get('cache.redis'));
		$this->user = $this->drive->decodeToken(\think\Request::instance()->header('token'));
		$this->user['rules_id'] = isset($this->user['rules_id']) ? explode(',', $this->user['rules_id']) : [];
	}

	/**
     * @desc   静态实例化
     * @author mina
     * @param  void
     * @return object
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof Base) {
            self::$instance = new Base();
        }

        return self::$instance;
    }

	/**
	 * @desc   检查token是否过期
	 * @author mina
	 * @param  string $token 当前token
	 * @return array
	 */
	public function cktoken($token) : array
	{
		$user = $this->drive->decodeToken($token);
		if(empty($user) || empty($user['id']))
		{
			return $this->_back(0, 'TOKEN错误。');
		}
		if(time() > $user['expiretime'])
		{
			return $this->_back(110, 'TOKEN超时。');
		}
		$userToken = $this->_redis->handler()->hget(Config::get('redis.user_token'), $this->user['id']);
		if($userToken != $token)
		{
			return $this->_back(110, 'TOKEN已过期。');
		}
		$this->user = $user;
		return $this->_back(1);
	}

	/**
	 * @desc   返回数据格式
	 * @author mina
	 * @param  int $status 状态 0失败  1成功
	 * @param  string $msg 提示语
	 * @param  array  $data 数据
	 * @return array
	 */
	protected function _back($status = 1, $msg = '', $data = []) : array
	{
		$retData = [
			'status'  => $status,
			'message' => $msg,
			'data'    => $data,
		];
		return $retData;
	}

	/**
	 * @desc   用户登录生成token
	 * @author mina
	 * @param  array $user 用户信息
	 * @return string
	 */
	protected function _setToken($user) : string
	{
		$timeOut = Config::get('site.logintime');
		$loginTime = $timeOut ? $timeOut * 60 : 86400;
		$accessToken = [
            $user['id'], $user['username'], $user['org_id'], $user['job_id'], time(), strtotime("+{$loginTime} minute"), \plugin\Random::uuid()
        ];
        $keeplogin = implode("|", $accessToken);
        $token = Crypt::encrypt($keeplogin);
        return $token;
	}

	/**
	 * @desc   token解密
	 * @author mina
	 * @param  string $token 用户token
	 * @return array
	 */
	protected function _getToken($token = '') : array
	{
		$token = $token ? $token : \think\Request::instance()->header('token');
		$tokenStr = Crypt::decrypt($token);
		if(empty($tokenStr)) return [];
		list($id,  $username, $org_id, $job_id, $logintime, $login_out_time, $uuid) = explode('|', $tokenStr);
		return [
			'id' => $id,
			'username' => $username,
			'org_id'   => $org_id,
			'job_id'   => $job_id,
			'logintime' => $logintime,
			'expri_time' => $login_out_time,
			'uuid'     => $uuid,
			'token'    => $token,
		];
	}
}
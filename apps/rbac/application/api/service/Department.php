<?php
/**
 * 用户权限 数据服务器层
 * @copyright Copyright (c) 2018
 * @license   
 * @version   Beta 1.0
 * @author    mina
 * @date      2018-04-08
 */
namespace app\api\service;

use think\Config;
use app\common\model\Organization;
use app\common\model\OrganizationUser;
use app\common\model\UsersJob;
use app\common\model\OrganizationUserAccount;

/**
 * @desc 部门 数据服务器层
 * Class Department
 * @package app\api\service
 */
class Department extends Base
{
	/**
	 * @desc   静态实例化
	 * @author mina
	 * @param  void
	 * @return object
	 */
	public static function getInstance()
	{
		if(!self::$instance instanceof Department)
        {
            self::$instance = new Department();
        }
        return self::$instance;
	}

	/**
	 * @desc   构造函数
	 * @author mina
	 * @param  
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @desc   部门管理
	 * @author mina
	 * @param  array $param 请求参数
	 * @return array
	 */
	public function list($param) : array
	{
		if(empty($this->user['org_id']))
		{
			return $this->_back(0, "TOKEN ERROR");
		}
		$where = [];
		if(!in_array(1, $this->user['rules_id']))
		{
			// 根据用户token查询用户所属部门
			$parent  = Organization::get(['id' => $this->user['org_id']]);
			// 查询用户负责的部门
			
			$where = "(tid={$parent['tid']} AND lid<={$parent['lid']} AND rid>={$parent['rid']})";
			$where .= " OR (tid={$parent['tid']} AND lid>={$parent['lid']} AND rid<={$parent['rid']})";
			$manage = Organization::all(['manage_uid' => $this->user['id']]);
			if(!empty($manage))
			{
				foreach ($manage as $key => $value)
				{
					$where .= " OR (tid={$value['tid']} AND lid<={$value['lid']} AND rid>={$value['rid']})";
					$where .= " OR (tid={$value['tid']} AND lid>={$value['lid']} AND rid<={$value['rid']})";
				}
			}
		}
		$model = new Organization();
		$treeData = $model->getColumn($where, 'id,pid,title,manage');
		if(empty($treeData))
		{
			return $this->_back(1);
		}
		$orgId = array_column($treeData, 'id');
		$orgData = array_column($treeData, 'title', 'id');
		$treeArr = $this->tree->getTreeCate($treeData);
		// 查询下属部门的所有用户
		$user_where = [
			'join' => [['organization_user b', 'a.id=b.user_id']],
			'a.org_id' => $this->user['org_id'],
			'b.status' => 1,
		];
		$count = $this->userModel->getCount($user_where);
		if($count == 0)
		{
			return $this->_back(1);
		}
		$page = 1;
		if(isset($param['page']) && $page['page'] > 1)
		{
			$page = $param['page'];
		}
		$pageCount = ceil($count / $this->pageSize);
		$field = "a.id,username,a.org_id,job_id,job_type, rules_id";
		$userList = $this->userModel->getAll($user_where, $field, $page, $this->pageSize)->toArray();
		// 查询用户所在的岗位名称
		$jobId = array_column($userList, 'job_id');
		$jobList = UsersJob::all(['id' => ['in', $jobId]])->toArray();
		$jobData = array_column($jobList, 'title', 'id');
		$retData = [
			'count' => $count,
			'pageCount' => $pageCount,
			'page'  => $page,
			'userList' => $userList,
			'orgData'  => $orgData,
			'orgTree'  => $treeArr,
			'jobData'  => $jobData,
			'is_administrator' => in_array(1, $this->user['rules_id']) ? 1 : 0,
		];
		return $this->_back(1, '', $retData);
	}

	/**
	 * @desc   禁用成员
	 * @author mina
	 * @param  array $param 参数
	 * @return array
	 */
	public function forbidden($param) : array
	{
		$doCheck = $this->_checkForbidden($param);
		if($doCheck['status'] != 1)
		{
			return $doCheck;
		}
		$userIdArr = array_filter(array_unique(explode(',', $param['userId'])));
		if(empty($userIdArr))
		{
			return $this->_back(0, '用户ID不能为空。');
		}
		$retData = [];
		foreach ($userIdArr as $key => $value)
		{
			$where = [
				'user_id' => $value,
				'org_id'  => $param['orgId'],
				'status'  => 1,
			];
			$orgUser = OrganizationUser::get($where);
			if(empty($orgUser))
			{
				$retData[$value] = $this->_back(0, '部门成员不存在');
				continue;
			}
			$row = OrganizationUserAccount::get($where);
			if(!empty($row) && $param['status'] == 0)
			{
				$retData[$value] = $this->_back(0, "用户已绑定账号，不能禁用。");
				continue;
			}
			$status = Config::get('users.orgStatus');
			if($orgUser['status'] == $param['status'])
			{
				$retData[$value] = $this->_back(0, "用户已{$status[$param['status']]}");
				continue;
			}
			if($param['status'] == 1)
			{
				$retData[$value] = $this->_back(0, "暂不支持启用功能。");
			}
			unset($where['status']);
			$isSave = OrganizationUser::update(['status' => $param['status']], $where);
			if($isSave === false)
			{
				$retData[$value] = $this->_back(0, "{$status[$param['status']]}失败。");
			}
			else
			{
				$service = new \app\v1\service\Organization();
				$service->updateunder($param['orgId']);
				$retData[$value] = $this->_back(1, "");
			}
		}
		if(count($userIdArr) == 1)
		{
			if(isset($retData[$userIdArr[0]]))
			{
				return $retData[$userIdArr[0]];
			}
			else
			{
				return $this->_back(0, '操作失败', $retData);
			}
		}
		if(count($userIdArr) == count($retData))
		{
			return $this->_back(0, '操作失败', $retData);
		}
		else
		{
			return $this->_back(1, '操作成功', $retData);
		}
	}

	/**
	 * @desc   添加、编辑成员
	 * @author mina
	 * @param  array $param 参数
	 * @return array
	 */
	public function edit($param) : array
	{
		if(empty($this->user['org_id']))
		{
			$this->_back(0, 'TOKEN ERROR');
		}
		$doCheck = $this->_checkEdit($param);
		if($doCheck['status'] != 1)
		{
			return $doCheck;
		}
		if($param['account'] == '') $param['account'] = [];
		$user = $this->userModel->getOne(['id' => $param['userId']]);
		if(empty($user))
		{
			return $this->_back(0, '用户不存在。');
		}
		$where = [
			'org_id'  => $param['orgId'],
			'user_id' => $param['userId'],
		];
		$orgUser = OrganizationUser::get($where);
		$service = new \app\v1\service\Organization();
		// 部门成员不存在时、添加成员
		if(empty($orgUser))
		{
			$addData = [
				'org_id' => $param['orgId'],
				'user_id' => $param['userId'],
				'user_name' => $user['username'],
				'status'  => 1,
				'createuser' => $this->user['username'],
			];
			$orgUser = OrganizationUser::create($addData);
			if(!$orgUser->id)
			{
				return $this->_back(0, '添加失败。');
			}
			
			$service->updateunder($param['orgId']);
			$service->updateUserOrg($param['userId'], $param['orgId']);
		}
		// 成员绑定账号
		$where = [
			'user_id' => $user['id'],
			'org_id'  => $param['orgId'],
		];
		$exAccount = [];
		$nowOrg    = [];
		$oldAccount = [];
		$rows = OrganizationUserAccount::all($where);
		if(!empty($rows))
		{
			foreach ($rows as $key => $value)
			{
				$k = "{$value['platform']}|{$value['platform_account']}";
				$v = $value['status'];
				$exAccount[$k] = $v;
				$nowOrg[$k] = $value['org_id'];
				$oldAccount[] = $k;
				if(count($param['account']) == 0)
				{
					$value->status = 0;
					$value->save();
				}
			}
		}
		if(count($param['account']) == 0)
		{
			$orgUser->binding = 0;
			$orgUser->save();
			return $this->_back();
		}
		$isSuccess = false;
		$newAccount = [];
		$fail    = [];
		$occupy = [];
		foreach ($param['account'] as $key => $value)
		{
			$saveData = [
				'org_id' => $param['orgId'],
				'user_id' => $user['id'],
				'user_name' => $user['username'],
				'platform'  => $value['platform'],
				'platform_account' => $value['account'],
				'platform_account_id' => $value['account_id'],
				'store_id' => isset($value['store_id']) ? $value['store_id'] : '',
				'locations' => isset($value['locations']) ? $value['locations'] : '',
				'sales_label' => isset($value['sales_label']) ? $value['sales_label'] : '',
				'status' => 1,
			];
			$k = "{$value['platform']}|{$value['account']}";
			$newAccount[] = $k;
			$refresh = '';
			if(array_key_exists($k, $exAccount))
			{
				if($exAccount[$k] == 1 && $nowOrg[$k] != $param['orgId'])
				{
					$occupy[] = join('|', [$value['platform'],$value['account']]);
				}
				else if($nowOrg[$k] == $param['orgId'] && $exAccount[$k] == 0)
				{
					$refresh = 'update';
				}
				else if($exAccount[$k] == 0)
				{
					$refresh = "add";
				}
			}
			else
			{
				$refresh = "add";
			}
			if($refresh == '') continue;
			if($refresh == 'update')
			{
				$update_where = [
					'user_id' => $param['userId'],
					'org_id'  => $param['orgId'],
					'platform'  => $value['platform'],
					'platform_account' => $value['account'],
				];
				$state = OrganizationUserAccount::update($saveData, $update_where);
			}
			else if($refresh == 'add')
			{
				$state = OrganizationUserAccount::create($saveData);
			}
			else
			{
				$state = false;
			}
			if(!$state || (isset($state->id) && !$state->id))
			{
				$fail[] = join('|', [$value['platform'],$value['account']]);
			}
			else
			{
				$isSuccess = true;
			}
		}
		if($isSuccess)
		{
			$orgUser->binding = 1;
			$orgUser->save();
		}
		# 需要禁用的账号
		$del_account = array_diff($oldAccount, $newAccount);
		if(!empty($del_account))
		{
			foreach ($del_account as $key => $value)
			{
				$arr = explode("|", $value);
				$update_where = [
					'user_id' => $param['userId'],
					'org_id'  => $param['orgId'],
					'platform' => $arr[0],
					'platform_account' => $arr[1],
				];
				OrganizationUserAccount::update(['status' => 0], $update_where);
			}
		}
		$retData = [];
		if(!empty($fail))
		{
			foreach ($fail as $key => $value)
			{
				$arr = explode("|", $value);
				$retData[] = [
					'platform' => $arr[0],
					'account' => $arr[1],
					'err_message' => '绑定失败',
				];
			}
		}
		if(!empty($occupy))
		{
			foreach ($occupy as $key => $value)
			{
				$arr = explode("|", $value);
				$retData[] = [
					'platform' => $arr[0],
					'account' => $arr[1],
					'err_message' => '账号已绑定其他成员。',
				];
			}
		}
		$service->updateOrgTime($param['orgId']);
		return $this->_back(1, '', $retData);
	}

	/**
	 * @desc   一键清空账号
	 * @author mina
	 * @param  array $param 参数
	 * @return array
	 */
	public function clearAccount($param)
	{
		if(empty($param['userId']))
		{
			return $this->_back(0, '用户ID不能为空。');
		}
		if(empty($param['orgId']))
		{
			return $this->_back(0, '用户岗位ID不能为空。');
		}
		$where = [
			'user_id' => $param['userId'],
			'org_id'  => $param['orgId'],
			'status'  => 1,
		];
		$row = OrganizationUserAccount::get($where);
		if(empty($row))
		{
			return $this->_back(0, '用户未绑定账号。');
		}
		$model = new OrganizationUserAccount();
		$model->startTrans();
		try
		{
			unset($where['status']);
			$result = $model->save(['status' => 0], $where);
			$orgUserModel = new OrganizationUser();
			$result1 = $orgUserModel->save(['binding' => 0], $where);
			if($result !== false && $result1 !== false)
			{
				$model->commit();
				return $this->_back(1);
			}
			else
			{
				$err_message = '操作失败。';
				if($result === false)
				{
					$err_message .= $model->getError();
				}
				if($result1 === false)
				{
					$err_message .= $orgUserModel->getError();
				}
				$model->rollback();
				return $this->_back(0, $err_message);
			}
		}
		catch(\Exception $e)
		{
			$model->rollback();
			return $this->_back(0, Config::get('app_debug') ? $e->getMessage() : '操作失败。');
		}
	}

	/**
	 * @desc   检查设置账号入参是否合法
	 * @author mina
	 * @param  array $param 入参
	 * @return array
	 */
	public function _checkEdit($param) : array
	{
		if(empty($param['userId']))
		{
			return $this->_back(0, '用户ID不能为空。');
		}
		if(empty($param['orgId']))
		{
			return $this->_back(0, '用户部门ID不能为空。');
		}
		if(isset($param['username']) && $param['username'] == '')
		{
			return $this->_back(0, '用户姓名不能为空。');
		}
		if(!isset($param['account']))
		{
			return $this->_back(0, '账号参数缺失。');
		}
		$error = '';
		if(is_array($param['account']) && count($param['account']) > 0)
		{	
			foreach ($param['account'] as $key => $value)
			{
				if(!isset($value['account']) || empty($value['account']))
				{
					$error .= "平台账号不能为空。";
					continue;
				}
				if(!isset($value['platform']) || empty($value['platform']))
				{
					$error .= "{$value['account']} 平台名称不能为空。";
				}
				if(!isset($value['account_id']) || empty($value['account_id']))
				{
					$error .= "{$value['account']} 账号ID不能为空。";
				}
				if($value['platform'] == 'ebay' 
					&& !(empty($value['store_id']) && empty($value['sales_label']) && empty($value['locations']))
					&& !(!empty($value['store_id']) && !empty($value['sales_label']) && !empty($value['locations']))
				)
				{
					$error .= "{$value['account']} ebay平台仅支持帐号单独绑定与全信息绑定。";
				}
				$where = [
					'platform' => $value['platform'],
					'platform_account_id' => $value['account_id'],
					'status' => 1,
					'user_id' => ['neq', $param['userId']],
				];
				if($value['platform'] == 'ebay')
				{
					$where['store_id'] = '';
					$where['locations'] = '';
					$where['sales_label'] = '';
				}
				$row = OrganizationUserAccount::get($where);
				if((!empty($row) || isset($row->id)))
				{
					if($value['platform'] == 'ebay' && (!empty($value['store_id']) || !empty($value['sales_label']) || !empty($value['locations'])))
					{
						continue;
					}
					$error .= "{$value['account']} 账号已经绑定成员。";
				}
			}
		}
		if($error != '')
		{
			return $this->_back(0, $error);
		}
		return $this->_back(1);
	}

	/**
	 * @desc   检查禁用、启用状态操作入参
	 * @author mina
	 * @param  array $param 参数
	 * @return array
	 */
	private function _checkForbidden($param)
	{
		if(empty($param['userId']))
		{
			return $this->_back(0, '用户ID不能为空。');
		}
		if(empty($param['orgId']))
		{
			return $this->_back(0, '用户部门ID不能为空。');
		}
		if($param['status'] == '')
		{
			return $this->_back(0, '操作状态不能为空。');
		}
		if(!array_key_exists($param['status'], Config::get('users.orgStatus')))
		{
			return $this->_back(0, '状态错误。');
		}
		return $this->_back(1);
	}
}
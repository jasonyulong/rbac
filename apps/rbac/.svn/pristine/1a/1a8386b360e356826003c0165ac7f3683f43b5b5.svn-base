<?php

namespace app\common\model;

use think\Model;

class OrganizationUser extends Model
{
    // 连接句柄
    //public $connection = 'database';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * @desc   查询条件
     * @author mina
     * @param  array $where 查询条件
     * @return int
     */
    public function getCount($where)
    {
    	return $this->alias('u')
    	            ->join('organization o', 'o.id=u.org_id')
    	            ->where($where)
    	            ->count();
    }

    /**
     * @desc   查询多条数据
     * @author mina
     * @param  array $where 查询条件
     * @param  string $field 字段
     * @param  string $page 查询条数
     * @param  string $grouoBy 排序
     * @return object
     */
    public function getAll($where, $field = '*', $page = '', $pageSize = 50, $order = '')
    {
    	$query = $this->alias('u')
    	              ->join('organization o', 'o.id=u.org_id')
    	              ->where($where)
    	              ->field($field);
    	if($page != '')
    	{
    		$query = $query->page($page, $pageSize);
    	}
    	if($order != '')
    	{
    		$query = $query->order($order);
    	}
    	$list = $query->select();
    	return $list;
    }
}

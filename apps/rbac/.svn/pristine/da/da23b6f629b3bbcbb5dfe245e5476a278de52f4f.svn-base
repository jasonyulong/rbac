<?php

namespace app\common\model;

use think\Model;

class UsersJobAccess extends Model
{
    // 连接句柄
    //public $connection = 'database';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * @desc   查询多条数据
     * @author mina
     * @param  array $where 查询条件
     * @param  string $field 查询字段
     * @return array
     */
    public function getAll($where, $field = "*")
    {
    	return $this->where($where)->field($field)->select();
    }
}

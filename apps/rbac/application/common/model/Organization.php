<?php

namespace app\common\model;

use think\Model;

class Organization extends Model
{
    // 连接句柄
    //public $connection = 'database';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * @desc   查询某一列的值
     * @author mina
     * @param  string $field 查询字段
     * @param  string $primaryKey 返回的键名字段
     * @return array
     */
    public function getColumn($where, $field = 'id, title')
    {
        return $this->where($where)->order('weigh desc')->column($field);
    }

    /**
     * 关联成员表
     * @return \think\model\relation\HasMany
     */
    public function orgusers()
    {
        return $this->hasMany('OrganizationUser', 'org_id', 'id');
    }

    /**
     * 关联成员表
     * @return \think\model\relation\HasMany
     */
    public function orguserAccounts()
    {
        return $this->hasMany('OrganizationUserAccount', 'org_id', 'id');
    }
}

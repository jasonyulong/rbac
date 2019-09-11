<?php

namespace app\common\model\erp;

use think\Model;

class Organization extends Model
{
    // 连接句柄
    public $connection = 'erp';

    // 表名
    protected $table = 'sys_organization';

    /**
     * 关联成员表
     * @return \think\model\relation\HasMany
     */
    public function orgusers()
    {
        return $this->hasMany('OrganizationUser', 'organize_id', 'id');
    }

    /**
     * 关联账号表
     * @return \think\model\relation\HasMany
     */
    public function orgproperty()
    {
        return $this->hasMany('OrganizationProperty', 'organize_id', 'id');
    }

    /**
     * 关联ebay账号表
     * @return \think\model\relation\HasMany
     */
    public function orgebay()
    {
        return $this->hasMany('OrganizationEbay', 'organize_id', 'id');
    }
}
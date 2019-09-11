<?php

namespace app\common\model\erp;

use think\Model;

class OrganizationUser extends Model
{
    // 连接句柄
    public $connection = 'erp';

    // 表名
    protected $table = 'sys_organization_user';
}
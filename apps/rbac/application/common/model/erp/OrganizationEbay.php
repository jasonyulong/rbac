<?php

namespace app\common\model\erp;

use think\Model;

class OrganizationEbay extends Model
{
    // 连接句柄
    public $connection = 'erp';

    // 表名
    protected $table = 'sys_organization_ebay';
}
<?php

namespace app\common\model;

use think\Model;

class UsersJobAccessAlso extends Model
{
	/**
	 * @desc  创建时间字段
	 * @var 
	 */
    protected $createTime = 'createtime';

    /**
     * @desc  更新时间字段
     * @var 
     */
    protected $updateTime = 'updatetime';

    /**
     * @desc  表名
     * @var 
     */
    protected $table = 'users_job_access_also';
}

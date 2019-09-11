<?php

namespace app\common\model;

use think\Model;

class MenusDetail extends Model
{
    // 连接句柄
    //public $connection = 'database';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    /**
     * 根据条件查询菜单详情
     * 查询以字段为键名的多条数据
     * @author wcd
     * @param $where
     * @param string $field 返回的字段
     * @param string $keyField 以此字段为键名的数组默认为id
     * @return array
     */
    public function getDetail($where = [], $field = '*', $keyField = 'id'):array
    {
        if(empty($where)) return [];
        $rr = $this->where($where)->order('weigh desc')->column($field, $keyField);
        return $rr;
    }

    /**
     * 更新菜单详情
     * @author wcd
     * @param $where
     * @param $params
     * @return $this
     */
    public function editDetail($where, $params)
    {
        return $this->where($where)->update($params);
    }

    /**
     * 获取一条菜单详情数据
     * @author wcd
     * @param array $where
     * @param string $field
     * @return array
     */
    public function getOne($where = [], $field = '')
    {
        return $this->where($where)->field($field)->find()->toArray();
    }

    /**
     * 删除操作
     * @param array $where
     * @return bool|int
     */
    public function delByWhere($where = [])
    {
        if(empty($where)) return false;
        return $this->where($where)->delete();
    }
}

<?php

namespace app\common\model;

use think\Model;
use think\Db;
class Menus extends Model
{
    // 连接句柄
    //public $connection = 'database';
    protected $table = 'menus';
    protected $createTime = '';
    // 更新时间字段
    protected $updateTime = '';
    public static $readInstance = null;

    /**
     * 返回对象
     * @return Menus|null
     */
    public static function getReadInstance()
    {
        if(!self::$readInstance) self::$readInstance = new self('', '', '');
        return self::$readInstance;
    }
    /**
     * 查询以字段为键名的多条数据
     * @author wcd
     * @param $where
     * @param string $field 返回的字段
     * @param string $keyField 以此字段为键名的数组默认为id
     * @return array
     */
    public function selectMore($where, $field = '', $keyField = 'id'):array
    {
        $field = $field == '' ? '*' : $field;
        return $this->where($where)->order('weigh desc')->column($field, $keyField);
    }

    /**
     * 查询一条数据
     * @author wcd
     * @param $where
     * @param string $field
     * @return array
     */
    public function getOne($where, $field= ''):array
    {
        $result = $this->where($where)->field($field)->find()->toArray();
        if(!$result) return [];
        return $result;
    }

    /**
     * 获取某个字段所有值
     * @param $where
     * @param $field
     * @return mixed
     */
    public function getAllColums($where, $field):array
    {
        return $this->where($where)->order('weigh desc')->column($field);
    }

    /**
     * 获取系统下的菜单
     * @param $moduleid int 系统id
     * @param string $field
     * @return array
     */
    public function getParentMenu($where, $field = '')
    {
        $where['status'] = 1;
        $field = $field ? $field : '*';
        $res= $this->where($where)->field($field)->select();

        return collection($res)->toArray();
    }
    /**
     * 删除操作
     * @param array $where
     * @return int
     */
    public function delByWhere($where = [])
    {
        return $this->where($where)->delete();
    }
}
<?php
// +----------------------------------------------------------------------
// | 无限分类处理类
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------

namespace plugin;

use think\Config;

class TreeClass
{
    protected static $instance;

    /**
     * 自定义参数
     * @var array
     */
    public $model = null;

    /**
     * @var string 树ID字段
     */
    private $tidFields = 'tid';
    /**
     * @var string 左值
     */
    private $lidFields = 'lid';
    /**
     * @var string 右值
     */
    private $ridFields = 'rid';
    /**
     * @var string 上级
     */
    private $pidFields = 'pid';
    /**
     * @var string 层级
     */
    private $rankFields = 'rank';

    /**
     * 构造方法
     * @param array $model 参数
     */
    public function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return TreeClass
     */
    public static function instance($model)
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($model);
        }

        return self::$instance;
    }

    /**
     * 新增元素
     * @param integer $pid
     * @return void
     */
    public function add($pid = 0)
    {
        // 增加顶级分类时
        if ($pid == 0) {
            $default = [
                $this->pidFields => $pid,
                $this->lidFields => 1,
                $this->ridFields => 2,
            ];
            return $default;
        }
        // 上级
        $parent = $this->model->where(['id' => $pid])->find();
        if (empty($parent)) return false;

        $rid = $parent->{$this->lidFields} + 2;
        $lid = $parent->{$this->lidFields} + 1;
        $tid = $parent->{$this->tidFields};

        // 更新左值
        $this->model->where([
            $this->lidFields => ['GT', $parent->{$this->lidFields}],
            $this->tidFields => $parent->{$this->tidFields}
        ])->setInc($this->lidFields, 2);
        // 更新右值
        $this->model->where([
            $this->lidFields => ['EGT', $parent->{$this->lidFields}],
            $this->tidFields => $parent->{$this->tidFields}
        ])->setInc($this->ridFields, 2);
        // 更新右值
        $this->model->where([
            $this->lidFields => ['LT', $parent->{$this->lidFields}],
            $this->ridFields => ['GT', $parent->{$this->ridFields}],
            $this->tidFields => $parent->{$this->tidFields},
        ])->setInc($this->ridFields, 2);

        return [
            $this->pidFields => $pid,
            $this->tidFields => $tid,
            $this->lidFields => $lid,
            $this->ridFields => $rid,
        ];
    }

    /**
     * 更新原上级的左右值
     * @param integer $id 记录ID
     * @return void
     */
    public function update(int $id)
    {
        $find = $this->model->where(['id' => $id])->find();
        if (empty($find)) return false;

        $this->model->where([
            $this->lidFields => ['GT', $find->{$this->lidFields}],
            $this->tidFields => $find->{$this->tidFields},
        ])->setDec($this->lidFields, 2);

        $this->model->where([
            $this->ridFields => ['GT', $find->{$this->lidFields}],
            $this->tidFields => $find->{$this->tidFields},
        ])->setDec($this->ridFields, 2);

        return true;
    }
}

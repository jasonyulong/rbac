<?php
// +----------------------------------------------------------------------
// | 服务基类
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------
namespace app\v1\service;


class Base
{
    /**
     * @var int 错误状态
     */
    public $errors = 0;

    /**
     * @var string 错误提示
     */
    public $errorsMessages = "error";

    /**
     * 设置错误信息
     * @param $status
     * @param $messages
     * @return bool
     */
    protected function setErrors($status, $messages) :bool
    {
        $this->errors = $status;
        $this->errorsMessages = $messages;

        return true;
    }

    /**
     * 返回错误提示语
     * @return string
     */
    public function getErrors() : string
    {
        return $this->errorsMessages;
    }

    /**
     * 返回错误状态
     * @return int
     */
    public function getCodes() : int
    {
        return $this->errors;
    }
}
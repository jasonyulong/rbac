<?php
// +----------------------------------------------------------------------
// | 自定义配置, 此配置文件数据来源于系统基本设置表, 如非后台配置项，请移到其他文件配置
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------
/**
 * status:用户状态
 * statusNum：数据库的用户状态所对应的控制器的方法
 * company：公司名称
 * pact_type：协议类型
 * room：是否安排住宿
 * ready_computer:是否自备电脑
 */
return [
    'searchKey' => [
        1 => '姓名',
        2 => '手机',
        3 => '邮箱',
    ],
    'searchStatus' => [
        100 => '全部',
        0 => '已发offer',
        1 => '已入职',
        2 => '待入职',
        3 => '离职',
        9 => '回收站',
    ],
    'status' => [
        'index' => '全部',
        'offer' => '已发offer',
        'wait' => '待入职',
        'work' => '已入职',
        'leave' => '离职',
        'recycle' => '回收站',
    ],
    'statusNum' => [
        0 => 'offer',
        1 => 'work',
        2 => 'wait',
        3 => 'leave',
        9 => 'recycle',
    ],
    'company' => [
        1 => '卓士网络',
        2 => '伟世通'
    ],
    'pact_type' => [
        100 => '全部',
        0 => '劳动协议',
        1 => '实习协议'
    ],
    'room' => [
        100 => '全部',
        0 => '个人',
        1 => '公司'
    ],
    'ready_computer' => [
        100 => '全部',
        0 => '否',
        1 => '是'
    ],
    'timetype' => [
        1 => '创建时间',
        2 => '入职时间',
        3 => '手续时间',
    ],
    'timetypes' => [
        1 => '创建时间',
        3 => '手续时间',
        4 => '预计入职时间',
    ],
    'orgStatus' => [
        0 => '禁用',
        1 => '启用',
    ],
];

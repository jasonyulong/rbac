<?php

// +----------------------------------------------------------------------
// | 岗位处理库
// +----------------------------------------------------------------------
// | COPYRIGHT (C) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | AUTHOR : lamkakyun
// | DATE   : 2019-04-12 09:46:29
// | VERSION：0.0.1
// +----------------------------------------------------------------------

namespace app\common\library;

use think\Config;
use app\common\model\Users;
use app\common\model\UsersJob;

class JobLib
{
    // 静态对象
    protected static $instance = null;

    /**
     * 单例
     * @return void
     * @author lamkakyun
     * @date 2019-04-12 09:47:11
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * 获取 岗位 树结构数据 (非递归)
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 15:36:30
     */
    public function getJobTree()
    {
        $job_user_map = $this->getJobUserMap();

        $where = ['status' => 1, 'tid' => ['NEQ', 1]];
        $all_jobs = UsersJob::field('id,pid,lid,tid,rid,rank,title,weigh')->where($where)->order('weigh DESC')->select()->toArray();

        // 将ID 放在 key位置上
        $tmp = $all_jobs;
        $all_jobs = [];
        foreach ($tmp as $key => $value) {
            $value['job_users'] = $job_user_map[$value['id']] ?? [];
            $value['job_users_num'] = count($value['job_users']);
            $all_jobs[$value['id']] = $value;
        }

        // 构造 tree
        $current_rank = 10;
        $min_rank = 1;

        while ($current_rank > $min_rank) {
            $tmp_jobs = $all_jobs;
            foreach ($tmp_jobs as $key => $value) {
                if ($value['rank'] != $current_rank) continue;
                unset($all_jobs[$key]);
                $all_jobs[$value['pid']]['children'][$value['id']] = $value;
            }
            $current_rank--;
        }

        return $all_jobs;
    }


    /**
     * 获取父岗位,包括自己
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 19:58:45
     */
    public function getAllParentJob($job_id)
    {
        if (!$job_id) return [];

        $all_jobs = UsersJob::field('id,pid,lid,tid,rid,rank,title,weigh')->order('weigh DESC')->select()->toArray();

        // 将ID 放在 key位置上
        $tmp = $all_jobs;
        $all_jobs = [];
        foreach ($tmp as $key => $value) {
            $value['job_users'] = $job_user_map[$value['id']] ?? [];
            $value['job_users_num'] = count($value['job_users']);
            $all_jobs[$value['id']] = $value;
        }
        $job_info = $all_jobs[$job_id];
        $tid = $job_info['tid'];
        $lid = $job_info['lid'];
        $rid = $job_info['rid'];

        // 获取父岗位
        $all_parent_jobs = [];
        foreach ($all_jobs as $value) {
            if ($value['tid'] == $tid && $value['lid'] <= $lid && $value['rid'] >= $rid) $all_parent_jobs[] = $value;
        }

        return $all_parent_jobs;
    }


    /**
     * 获取子岗位
     * @return void
     * @author lamkakyun
     * @date 2019-04-18 11:23:06
     */
    public function getAllChildJobs($job_id)
    {
        if (!$job_id) return [];

        $all_jobs = UsersJob::field('id,pid,lid,tid,rid,rank,title,weigh')->order('weigh DESC')->select()->toArray();

        // 将ID 放在 key位置上
        $tmp = $all_jobs;
        $all_jobs = [];
        foreach ($tmp as $key => $value) {
            $all_jobs[$value['id']] = $value;
        }
        $job_info = $all_jobs[$job_id];
        $tid = $job_info['tid'];
        $lid = $job_info['lid'];
        $rid = $job_info['rid'];

        // 获取父岗位
        $all_child_jobs = [];
        foreach ($all_jobs as $value) {
            if ($value['tid'] == $tid && $value['lid'] > $lid && $value['rid'] < $rid) $all_child_jobs[] = $value;
        }

        return $all_child_jobs;
    }


    /**
     * 树到 数组的转换(递归)
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 16:43:11
     */
    public function jobTreeToArray($tree, &$ret_data)
    {
        foreach ($tree as $key => $value) {
            $children = $value['children'] ?? [];
            if ($children) unset($value['children']);
            $ret_data[$value['id']] = $value;
            if ($children) $this->jobTreeToArray($children, $ret_data);
        }
    }


    /**
     * 获取 岗位 一维结构,按照 层级排序
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 16:49:47
     */
    public function getJobArray()
    {
        $tree = $this->getJobTree();
        $data = [];
        $this->jobTreeToArray($tree, $data);

        return $data;
    }


    /**
     * 获取 岗位-用户映射
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 18:05:34
     */
    public function getJobUserMap()
    {
        $where = ['status' => 1];
        $tmp = Users::field('id, username, job_id')->where($where)->select()->toArray();

        $data = [];
        foreach ($tmp as $key => $value) {
            $data[$value['job_id']][] = $value;
        }

        return $data;
    }
}
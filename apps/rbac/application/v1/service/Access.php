<?php
// +----------------------------------------------------------------------
// | 权限设置
// +----------------------------------------------------------------------
// | COPYRIGHT (C) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | AUTHOR : lamkakyun
// | DATE   : 2019-04-15 14:42:59
// | VERSION：0.0.1
// +----------------------------------------------------------------------

namespace app\v1\service;

use app\common\library\auth\Drive;
use plugin\Tree;
use think\Config;
use app\common\model\Menus;
use app\common\model\Users;
use think\cache\driver\Redis;
use app\common\library\JobLib;
use app\common\model\UsersJob;
use app\common\library\MenuLib;
use app\common\model\UsersAlso;
use app\common\model\UsersLabel;
use app\common\model\UsersJobAccess;
use app\common\model\UsersLabelAccess;
use app\common\model\UsersJobAccessAlso;
use app\common\model\UsersLabelAccessAlso;

class Access
{
    // 针对特殊的权限的关键字
    const ACCESS_KEYS = [
        'store_id', // 能看到的 仓库
        'account', // 能看到的 账号
        'order_status', // 能看到的订单状态
    ];

    /**
     * 更新岗位 权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-15 14:44:12
     */
    public function updateJobAccess($job_id, $params)
    {
        $params['menu'] = (isset($params['menu']) && !empty($params['menu'])) ? explode(',', $params['menu']) : [];
        $params['menu_detail'] = (isset($params['menu_detail']) && !empty($params['menu_detail'])) ? explode(',', $params['menu_detail']) : [];

        foreach ($params['menu_detail'] as $value) {
            $tmp_arr = explode('___', $value);
            $params['menu'][] = $tmp_arr[0];
        }
        $params['menu'] = array_unique($params['menu']);

        $parent_menu_ids = MenuLib::instance()->getAllParentMenuId($params['menu'], $params['module_id']);
        $all_menu_ids = array_filter(array_map('trim', array_unique(array_merge($params['menu'], $parent_menu_ids))), function ($v) {
            return $v != '';
        });

        // 查看岗位 拥有的权限
        $where = ['job_id' => $job_id];
        $access_list = UsersJobAccess::field('menu_id, menu_detail_id')->where($where)->select()->toArray();

        $old_access_menu_and_detail = [];
        foreach ($access_list as $value) {
            $old_access_menu_and_detail[] = $value['menu_id'] . '___' . $value['menu_detail_id'];
        }

        $new_access_menu_and_detail = [];
        sort($all_menu_ids);

        foreach ($all_menu_ids as $value) {
            $new_access_menu_and_detail[] = $value . '___0';
        }

        if (isset($params['menu_detail'])) {
            $params['menu_detail'] = array_filter($params['menu_detail'], function ($v) {
                return $v != '';
            });
            foreach ($params['menu_detail'] as $value) {
                $new_access_menu_and_detail[] = $value;
            }
        }

        // 要删除的权限 (假如父权限删除，那么子权限也要删除)
        $deleted_access = array_diff($old_access_menu_and_detail, $new_access_menu_and_detail);
        $sub_jobs = JobLib::instance()->getAllChildJobs($job_id);
        $sub_job_ids = array_column($sub_jobs, 'id');
        $all_job_ids = array_merge([$job_id], array_column($sub_jobs, 'id'));

        // 要增加的权限
        $added_access = array_diff($new_access_menu_and_detail, $old_access_menu_and_detail);

        $added_menu_ids = array_unique(array_map(function ($v) {
            return explode('___', $v)[0];
        }, $added_access));

        $added_menus = !empty($added_menu_ids) ? Menus::where(['id' => ['IN', $added_menu_ids]])->select()->toArray() : [];
        $added_menus = tranform_data($added_menus, 1);

        // 构造删除条件
        $where_delete = [];
        foreach ($deleted_access as $value) {
            $tmp_arr = explode('___', $value);
            $tmp_menu_id = $tmp_arr[0];
            $tmp_node_id = $tmp_arr[1];

            $where_delete[] = "(menu_id = {$tmp_menu_id} AND menu_detail_id = {$tmp_node_id})";
        }
        $where_delete_str = "module_id = {$params['module_id']} AND job_id IN (" . implode(',', $all_job_ids) . ") AND (" . implode(' OR ', $where_delete) . ")";

        // 构造添加数据
        $now_time = time();
        $all_add_data = [];
        foreach ($added_access as $value) {
            $tmp_arr = explode('___', $value);
            $tmp_menu_id = $tmp_arr[0];
            $tmp_node_id = $tmp_arr[1];
            $type = ($tmp_node_id != '0');

            $tmp_data = [
                'job_id' => $job_id,
                'type' => $type,
                'stand' => $added_menus[$tmp_menu_id]['type'] ?? 0,
                'menu_id' => $tmp_menu_id,
                'module_id' => $params['module_id'],
                'menu_detail_id' => $tmp_node_id,
                'createtime' => $now_time,
                'updatetime' => $now_time,
            ];

            $all_add_data[] = $tmp_data;
        }

        UsersJobAccess::startTrans();
        // 特殊权限处理(假如父权限删除，那么子权限也要删除)

        // 一次性查出所有 access_also
        $tmp_where = ['job_id' => ['IN', $all_job_ids], 'module_id' => $params['module_id']];
        $tmp_data = UsersJobAccessAlso::where($tmp_where)->select()->toArray();

        // 构建 keys -> job_id 二维数组
        $job_access_also = [];
        foreach ($tmp_data as $value) {
            $job_access_also[$value['keys']][$value['job_id']] = $value;
        }

        foreach (self::ACCESS_KEYS as $acc_key) {
            if (isset($params[$acc_key])) {
                $post_key_data = array_filter(array_map('trim', explode(',', $params[$acc_key])), function ($v) {
                    return $v != '';
                });

                // $tmp_where = ['job_id' => ['IN', $all_job_ids], 'module_id' => $params['module_id'], 'keys' => $acc_key];
                // $tmp_data = UsersJobAccessAlso::where($tmp_where)->select()->toArray();

                // job_id 放到key
                // $job_access_also = [];
                // foreach ($tmp_data as $value)
                // {
                //     $job_access_also[$value['job_id']] = $value;
                // }

                $current_job_access_also = [];
                $current_key_data = [];
                if (isset($job_access_also[$acc_key][$job_id])) {
                    $current_job_access_also = $job_access_also[$acc_key][$job_id] ?? [];
                    unset($job_access_also[$acc_key][$job_id]);

                    $current_key_data = array_filter(array_map('trim', explode(',', $current_job_access_also['values'])), function ($v) {
                        return $v != '';
                    });
                }

                $rest_job_access_also = $job_access_also[$acc_key] ?? [];

                // 找到需要删除的 values
                $deleted_keys_data = array_diff($current_key_data, $post_key_data);

                if (!empty($deleted_keys_data) && !empty($rest_job_access_also)) {
                    foreach ($rest_job_access_also as $v) {
                        $tmp_values = array_filter(array_map('trim', explode(',', $v['values'])), function ($v) {
                            return $v != '';
                        });

                        $tmp_intersect = array_intersect($tmp_values, $deleted_keys_data);
                        if (count($tmp_intersect) == 0) continue;

                        $tmp_diff_data = array_diff($tmp_values, $deleted_keys_data);
                        sort($tmp_diff_data);

                        $tmp_ret = UsersJobAccessAlso::where(['id' => $v['id']])->update(['values' => implode(',', $tmp_diff_data)]);
                    }
                }

                $tmp_save = [
                    'job_id' => $job_id,
                    'module_id' => $params['module_id'],
                    'keys' => $acc_key,
                    'values' => $params[$acc_key],
                ];

                if ($current_job_access_also) {
                    $tmp_save['updatetime'] = $now_time;
                    $_where = ['job_id' => $job_id, 'module_id' => $params['module_id'], 'keys' => $acc_key];

                    $tmp_ret = UsersJobAccessAlso::where($_where)->update($tmp_save);
                } else {
                    $tmp_ret = true;
                    if (!empty($params[$acc_key])) {
                        $tmp_save['createtime'] = $now_time;
                        $tmp_save['updatetime'] = $now_time;
                        $tmp_ret = UsersJobAccessAlso::insert($tmp_save);
                    }
                }

                if ($tmp_ret === false) {
                    UsersJobAccess::rollback();

                    return ['code' => 10001, 'msg' => '操作失败'];
                }
            }
        }

        $ret_delete = true;
        if (!empty($where_delete)) {
            $ret_delete = UsersJobAccess::where($where_delete_str)->delete();
        }

        $ret_add = true;
        if (!empty($all_add_data)) {
            $ret_add = $ret_add = UsersJobAccess::insertAll($all_add_data);
        }

        if ($ret_add !== false && $ret_delete !== false) {
            UsersJobAccess::commit();
            // 保存成功权限后, 更新岗位所涉及的用户权限
            $this->checkJobAuth($job_id);

            return ['code' => 0, 'msg' => '操作成功'];
        } else {
            UsersJobAccess::rollback();

            return ['code' => -1, 'msg' => '操作失败'];
        }
    }


    /**
     * 保存 标签权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-16 19:53:28
     */
    public function updateTagAccess($label_id, $params)
    {
        $params['menu'] = (isset($params['menu']) && !empty($params['menu'])) ? explode(',', $params['menu']) : [];
        $params['menu_detail'] = (isset($params['menu_detail']) && !empty($params['menu_detail'])) ? explode(',', $params['menu_detail']) : [];

        foreach ($params['menu_detail'] as $value) {
            $tmp_arr = explode('___', $value);
            $params['menu'][] = $tmp_arr[0];
        }
        $params['menu'] = array_unique($params['menu']);

        $parent_menu_ids = MenuLib::instance()->getAllParentMenuId($params['menu'], $params['module_id']);
        $all_menu_ids = array_filter(array_map('trim', array_unique(array_merge($params['menu'], $parent_menu_ids))), function ($v) {
            return $v != '';
        });


        // 查看标签 拥有的权限
        $where = ['label_id' => $label_id];
        $access_list = UsersLabelAccess::field('menu_id, menu_detail_id')->where($where)->select()->toArray();

        $old_access_menu_and_detail = [];
        foreach ($access_list as $value) {
            $old_access_menu_and_detail[] = $value['menu_id'] . '___' . $value['menu_detail_id'];
        }

        $new_access_menu_and_detail = [];
        // if (isset($params['menu']))
        // {
        //     foreach ($params['menu'] as $value)
        //     {
        //         $new_access_menu_and_detail[] = $value . '___0';
        //     }
        // }
        sort($all_menu_ids);

        foreach ($all_menu_ids as $value) {
            $new_access_menu_and_detail[] = $value . '___0';
        }

        if (isset($params['menu_detail'])) {
            $params['menu_detail'] = array_filter($params['menu_detail'], function ($v) {
                return $v != '';
            });
            foreach ($params['menu_detail'] as $value) {
                $new_access_menu_and_detail[] = $value;
            }
        }

        // 要删除的权限
        $deleted_access = array_diff($old_access_menu_and_detail, $new_access_menu_and_detail);

        // 要增加的权限
        $added_access = array_diff($new_access_menu_and_detail, $old_access_menu_and_detail);

        $added_menu_ids = array_unique(array_map(function ($v) {
            return explode('___', $v)[0];
        }, $added_access));

        $added_menus = !empty($added_menu_ids) ? Menus::where(['id' => ['IN', $added_menu_ids]])->select()->toArray() : [];
        $added_menus = tranform_data($added_menus, 1);

        // 构造删除条件
        $where_delete = [];
        foreach ($deleted_access as $value) {
            $tmp_arr = explode('___', $value);
            $tmp_menu_id = $tmp_arr[0];
            $tmp_node_id = $tmp_arr[1];

            $where_delete[] = "(menu_id = {$tmp_menu_id} AND menu_detail_id = {$tmp_node_id})";
        }
        $where_delete_str = implode(' OR ', $where_delete);

        // 构造添加数据
        $now_time = time();
        $all_add_data = [];
        foreach ($added_access as $value) {
            $tmp_arr = explode('___', $value);
            $tmp_menu_id = $tmp_arr[0];
            $tmp_node_id = $tmp_arr[1];
            $type = ($tmp_node_id != '0');

            $tmp_data = [
                'label_id' => $label_id,
                'type' => $type,
                'menu_id' => $tmp_menu_id,
                'module_id' => $params['module_id'],
                'menu_detail_id' => $tmp_node_id,
                'createtime' => $now_time,
                'updatetime' => $now_time,
            ];

            $all_add_data[] = $tmp_data;
        }

        UsersLabelAccess::startTrans();

        // 特殊权限处理
        foreach (self::ACCESS_KEYS as $acc_key) {
            if (isset($params[$acc_key])) {
                $tmp_where = ['label_id' => $label_id, 'module_id' => $params['module_id'], 'keys' => $acc_key];
                $tmp_data = UsersLabelAccessAlso::where($tmp_where)->find();

                $tmp_save = [
                    'label_id' => $label_id,
                    'module_id' => $params['module_id'],
                    'keys' => $acc_key,
                    'values' => $params[$acc_key],
                ];

                if ($tmp_data) {
                    $tmp_save['updatetime'] = $now_time;
                    $tmp_ret = UsersLabelAccessAlso::where($tmp_where)->update($tmp_save);
                } else {
                    $tmp_ret = true;
                    if (!empty($params[$acc_key])) {
                        $tmp_save['createtime'] = $now_time;
                        $tmp_ret = UsersLabelAccessAlso::insert($tmp_save);
                    }
                }

                if ($tmp_ret === false) {
                    UsersLabelAccess::rollback();

                    return ['code' => 10001, 'msg' => '操作失败'];
                }
            }
        }

        $ret_delete = true;
        if (!empty($where_delete)) {
            $ret_delete = UsersLabelAccess::where($where_delete_str)->delete();
        }

        $ret_add = true;
        if (!empty($all_add_data)) {
            $ret_add = $ret_add = UsersLabelAccess::insertAll($all_add_data);
        }

        if ($ret_add !== false && $ret_delete !== false) {
            UsersLabelAccess::commit();
            // 保存成功权限后, 更新岗位所涉及的用户权限
            $this->checkLaleAuth($label_id);

            return ['code' => 0, 'msg' => '操作成功'];
        } else {
            UsersLabelAccess::rollback();

            return ['code' => -1, 'msg' => '操作失败'];
        }

    }


    /**
     * 更新用户权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-25 09:56:02
     */
    public function updateUserAlso($params)
    {
        if (!isset($params['job_id']) || !preg_match('/^\d+$/', $params['job_id'])) return ['code' => 10001, 'msg' => '参数错误'];
        if (!isset($params['user_id']) || !preg_match('/^\d+$/', $params['user_id'])) return ['code' => 10002, 'msg' => '参数错误'];

        $where = ['user_id' => $params['user_id'], 'module_id' => $params['module_id']];
        $also = UsersAlso::where($where)->select()->toArray();

        $tmp = $also;
        $also = [];
        foreach ($tmp as $key => $value) {
            $also[$value['keys']] = array_filter(array_map('trim', explode(',', $value['values'])), function ($v) {
                return $v != '';
            });
        }

        // echo '<pre>';var_dump($params);echo '</pre>';
        // exit;
        UsersAlso::startTrans();
        $now_time = time();
        foreach (self::ACCESS_KEYS as $acc_key) {

            // if (!isset($params[$acc_key]) || empty($params[$acc_key])) continue;

            $tmp_value = array_filter(array_map('trim', explode(',', $params[$acc_key])), function ($v) {
                return $v != '';
            });

            if (isset($also[$acc_key])) {
                // save
                $tmp_data = [
                    'values' => implode(',', $tmp_value),
                    'updatetime' => $now_time,
                ];

                $tmp_where = ['user_id' => $params['user_id'], 'module_id' => $params['module_id'], 'keys' => $acc_key];

                $ret = UsersAlso::where($tmp_where)->update($tmp_data);
            } else {
                // add
                $tmp_data = [
                    'user_id' => $params['user_id'],
                    'module_id' => $params['module_id'],
                    'keys' => $acc_key,
                    'values' => implode(',', $tmp_value),
                    'createtime' => $now_time,
                    'updatetime' => $now_time,
                ];
                $ret = UsersAlso::insert($tmp_data);
            }

            if ($ret === false) {
                UsersAlso::rollback();
                return ['code' => 10002, 'msg' => '操作失败'];
            }
        }

        UsersAlso::commit();
        // 清除缓存权限
        \app\common\library\auth\Drive::instance()->clearAuth($params['user_id']);

        return ['code' => 0, 'msg' => '操作成功'];

    }

    /**
     * 获取 其他权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-17 10:11:24
     */
    public function getAccessAlso($id, $module_id, $type = 1)
    {
        $fields = 'keys, values';
        switch ($type) {
            case '1':
                $where = ['job_id' => $id, 'module_id' => $module_id];
                $data = UsersJobAccessAlso::field($fields)->where($where)->select()->toArray();
                break;

            case '2':
                $where = ['label_id' => $id, 'module_id' => $module_id];
                $data = UsersLabelAccessAlso::field($fields)->where($where)->select()->toArray();
                break;
        }

        $ret_data = [];
        foreach ($data as $key => $value) {
            $ret_data[$value['keys']] = array_filter(array_map('trim', explode(',', $value['values'])), function ($v) {
                return $v != '';
            });
        }

        return $ret_data;
    }


    /**
     * 获取 所有 其他权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-17 11:56:47
     */
    public function getAllAccessAlso($type = 1)
    {
        $fields = 'keys, values';
        switch ($type) {
            case '1':
                $fields .= ",job_id as id";
                $data = UsersJobAccessAlso::field($fields)->select()->toArray();
                break;

            case '2':
                $fields .= ",label_id as id";
                $data = UsersLabelAccessAlso::field($fields)->select()->toArray();
                break;
        }

        $ret_data = [];
        foreach ($data as $key => $value) {
            $ret_data[$value['id']][$value['keys']] = $value['values'];
        }

        return $ret_data;
    }

    /**
     * 岗位权限变更了， 清楚所有用户写入的权限缓存
     * @param $job_id 岗位ID
     * @return bool
     */
    public function checkJobAuth($job_id)
    {
        $jobData = UsersJob::get($job_id);
        if (empty($jobData)) return false;

        // 查找当前岗位的下级岗位
        $jobIds = UsersJob::where(['tid' => $jobData->tid, 'lid' => ['EGT', $jobData->lid], 'rid' => ['ELT', $jobData->rid]])->column('id');
        if (empty($jobIds)) return false;

        // 查找岗位对应的用户
        $userIds = Users::where(['job_id' => ['IN', $jobIds]])->column('id');
        if (empty($userIds)) return false;

        $redis = new Redis(Config::get('cache.redis'));
        foreach ($userIds as $user_id) {
            // 将权限移除
            \app\common\library\auth\Drive::instance()->clearAuth($user_id);
        }

        return true;
    }

    /**
     * 权限标签权限变更了， 清楚所有用户写入的权限缓存
     * @param $lable_id 岗位ID
     * @return bool
     */
    public function checkLaleAuth($lable_id)
    {
        $tagService = new Tag();
        $tagUsers = $tagService->getTagUsers();

        $userIds = $tagUsers[$lable_id] ?? [];
        // 查找对应的用户
        if (empty($userIds)) return false;

        $redis = new Redis(Config::get('cache.redis'));
        foreach ($userIds as $user_id) {
            // 将权限移除
            \app\common\library\auth\Drive::instance()->clearAuth($user_id);
        }

        return true;
    }
}
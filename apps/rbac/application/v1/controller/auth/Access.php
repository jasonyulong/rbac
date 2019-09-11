<?php
// +----------------------------------------------------------------------
// | 权限 设定
// +----------------------------------------------------------------------
// | COPYRIGHT (C) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | AUTHOR : lamkakyun
// | DATE   : 2019-04-11 10:37:14
// | VERSION：0.0.1
// +----------------------------------------------------------------------

namespace app\v1\controller\auth;

use think\Request;
use app\v1\service\Tag;
use app\common\library\JobLib;
use app\common\model\UsersJob;
use app\common\library\ConfLib;
use app\common\library\MenuLib;
use app\common\model\UsersAlso;
use app\common\library\LabelLib;
use app\common\library\RedisLib;
use app\common\model\UsersJobAccess;
use app\common\model\UsersLabelAccess;
use app\common\model\UsersJobAccessAlso;
use app\v1\service\Access as AccessService;
use app\common\controller\AuthController as Controller;

class Access extends Controller
{

    /**
     * 重组 岗位数据,给前端插件 (递归)
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 17:13:37
     */
    private function _reshapeJobData($data, &$job_id, $module_id, &$all_parent_job_ids)
    {
        $ret_data = [];
        foreach ($data as $key => $value) {
            if ($value['rank'] == 1 && !isset($value['children'])) {
                $tmp = [];
                $tmp['text'] = str_replace("'", '"', $value['title']) . "({$value['job_users_num']})";
                $tmp['href'] = url('index', ['id' => $value['id'], 'module_id' => $module_id], '');
                $tmp['icon'] = "glyphicon glyphicon-home";

                if (in_array($value['id'], $all_parent_job_ids)) $tmp['state']['expanded'] = true;
                if ($job_id == $value['id']) $tmp['state']['selected'] = true;

                $ret_data[] = $tmp;
                continue;
            } else {
                if (isset($value['children'])) {
                    $d = $this->_reshapeJobData($value['children'], $job_id, $module_id, $all_parent_job_ids);
                    $tmp = [];
                    $tmp['text'] = str_replace("'", '', $value['title']) . "({$value['job_users_num']})";
                    $tmp['href'] = url('index', ['id' => $value['id'], 'module_id' => $module_id], '');
                    if ($value['rank'] == 1) {
                        $tmp['icon'] = "glyphicon glyphicon-home";
                        $tmp['state']['expanded'] = false;
                    }

                    if (in_array($value['id'], $all_parent_job_ids)) $tmp['state']['expanded'] = true;
                    if ($job_id == $value['id']) $tmp['state']['selected'] = true;

                    $tmp['nodes'] = $d;
                    $ret_data[] = $tmp;
                } else {
                    $tmp = [
                        'text' => str_replace("'", '"', $value['title']) . "({$value['job_users_num']})",
                        'href' => url('index', ['id' => $value['id'], 'module_id' => $module_id], ''),
                    ];
                    if ($job_id == $value['id']) $tmp['state']['selected'] = true;
                    $ret_data[] = $tmp;
                }
            }
        }

        return $ret_data;
    }


    /**
     * 岗位权限页面
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 10:42:45
     */
    public function index()
    {
        $service = new AccessService();
        $params = input('get.');
        if (!isset($params['module_id']) || !preg_match('/^\d+$/', $params['module_id'])) $params['module_id'] = 1;

        // tree
        $all_parent_jobs = JobLib::instance()->getAllParentJob($params['id'] ?? 0);
        $all_parent_job_ids = array_column($all_parent_jobs, 'id');

        $job_tree = JobLib::instance()->getJobTree();
        $tmp = $job_tree;
        $job_arr = [];
        tree_to_array($tmp, $job_arr);

        // 合并 岗位 和 权限
        $all_access = UsersJobAccess::field('type,job_id,menu_id,menu_detail_id')->select()->toArray();
        $menu_access = [];
        $menu_detail_access = [];
        foreach ($all_access as $value) {
            if ($value['type'] == 0) $menu_access[$value['job_id']][] = $value['menu_id'];
            $tmp_value = "{$value['menu_id']}___{$value['menu_detail_id']}";
            if ($value['type'] == 1) $menu_detail_access[$value['job_id']][] = $tmp_value;
        }

        $all_access_also = $service->getAllAccessAlso(1);

        foreach ($job_arr as $key => $value) {
            $tmp_menu_access = $menu_access[$value['id']] ?? [];
            $tmp_menu_detail_access = $menu_detail_access[$value['id']] ?? [];
            $tmp_data = [
                'menu_id' => implode(',', $tmp_menu_access),
                'menu_detail_ids' => implode(',', $tmp_menu_detail_access),
            ];

            foreach (AccessService::ACCESS_KEYS as $k => $v) {
                $tmp_data[$v] = $all_access_also[$value['id']][$v] ?? '';
            }

            $job_arr[$key]['access'] = json_encode($tmp_data);
        }

        // 默认选中 第一个元素
        if (!isset($params['id'])) $params['id'] = reset($job_arr)['id'];

        $job_tree = $this->_reshapeJobData($job_tree, $params['id'], $params['module_id'], $all_parent_job_ids);

        // allow system
        $allow_systems = ConfLib::instance()->getAllowSystem();

        $menu_tree = MenuLib::instance()->getMenuTree($params['module_id'], $params['id']);

        $has_parent = false;
        $parent_id = UsersJob::where(['id' => $params['id']])->value('pid');
        if ($parent_id != 0) {
            $has_parent = true;
            $tmp = UsersJobAccessAlso::where(['job_id' => $parent_id, 'module_id' => $params['module_id']])->select()->toArray();
            $parent_access_also = [];
            foreach ($tmp as $value) {
                $parent_access_also[$value['keys']] = array_filter(array_map('trim', explode(',', $value['values'])), function ($v) {
                    return $v != '';
                });
            }

            $parent_access_also = array_filter($parent_access_also, function ($v) {
                return $v != '';
            });
            $parent_account_access_also = $parent_access_also['account'] ?? [];
            $parent_store_access_also = $parent_access_also['store_id'] ?? [];
            $parent_status_access_also = $parent_access_also['order_status'] ?? [];
        }


        $all_stores = RedisLib::instance()->getAllStores();
        $all_accounts = RedisLib::instance()->getAllErpAccounts(3);
        $all_access_order_status = RedisLib::instance()->getTopMenu();

        if ($has_parent) {
            $parent_store_id = $parent_access_also['store_id'] ?? [];
            $parent_account = $parent_access_also['account'] ?? [];
            $parent_access_order_status = $parent_access_also['order_status'] ?? [];

            $all_stores = array_filter($all_stores, function ($v) use ($parent_store_id) {
                return in_array($v['id'], $parent_store_id);
            });
            foreach ($all_accounts as $key => $value) {
                foreach ($value as $k => $v) {
                    if (!in_array($k, $parent_account)) unset($all_accounts[$key][$k]);
                }
            }

            $all_access_order_status = array_filter($all_access_order_status, function ($v) use ($parent_access_order_status) {
                return in_array($v['id'], $parent_access_order_status);
            });
        }

        $all_accounts = array_filter($all_accounts, function ($v) {
            return $v != '';
        });

        // 获取 其他 权限
        $access_also = $service->getAccessAlso($params['id'], $params['module_id'], 1);
        $store_access_also = $access_also['store_id'] ?? [];
        $account_access_also = $access_also['account'] ?? [];
        $order_status_access_also = $access_also['order_status'] ?? [];

        foreach ($all_stores as $key => $value) {
            $all_stores[$key]['access'] = in_array($value['id'], $store_access_also) ? 1 : 0;
        }

        $account_access = [];
        foreach ($all_accounts as $key => $value) {
            foreach ($value as $k => $v) {
                $account_access[$v] = in_array($k, $account_access_also) ? 1 : 0;
            }
        }

        $default_platform = array_keys($all_accounts)[0] ?? '';

        $this->assign('account_access', $account_access);

        foreach ($all_access_order_status as $key => $value) {
            $all_access_order_status[$key]['access'] = in_array($value['id'], $order_status_access_also) ? 1 : 0;
        }
        ksort($all_access_order_status);


        $scroll_data = [];
        foreach ($menu_tree['data'] as $value) {
            $scroll_data[] = ['id' => $value['id'], 'title' => $value['title']];
        }

        $this->assign('adaptive', '');
        $this->assign('unclickable', '1');
        $this->assign('job_tree', json_encode($job_tree));
        $this->assign('all_stores', $all_stores);
        $this->assign('all_accounts', $all_accounts);
        $this->assign('all_access_order_status', $all_access_order_status);
        $this->assign('default_platform', $default_platform);

        $this->assign('allow_systems', $allow_systems);
        $this->assign('params', $params);
        $this->assign('scroll_data', $scroll_data);
        $this->assign('menu_tree', $menu_tree['data']);
        $this->assign('job_arr', $job_arr);


        $this->assign('access_also', (!$has_parent || !empty($parent_access_also)));
        $this->assign('store_access_also', (!$has_parent || !empty($parent_store_access_also)));
        $this->assign('account_access_also', (!$has_parent || !empty($parent_account_access_also)));
        $this->assign('order_status_access_also', (!$has_parent || !empty($parent_status_access_also)));

        return parent::fetchAuto();
    }


    /**
     * 跟新 岗位权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-15 11:03:18
     */
    public function save()
    {
        $job_id = input('post.id', 0);
        $params = input('post.');
        $service = new AccessService();

        if (!$job_id) return json(['code' => -1, 'msg' => '参数错误']);

        $ret = $service->updateJobAccess($job_id, $params);

        return json($ret);
    }


    /**
     * 标签权限页面
     * @return void
     * @author lamkakyun
     * @date 2019-04-11 10:42:45
     */
    public function tagindex()
    {
        $service = new AccessService();
        $params = input('get.');
        if (!isset($params['module_id']) || !preg_match('/^\d+$/', $params['module_id'])) $params['module_id'] = 1;

        $all_labels = LabelLib::instance()->getAllLabels();

        $user_tag = (new Tag())->usertag();

        foreach ($all_labels as $key => $value) {
            $all_labels[$key]['user_num'] = $user_tag[$key] ?? 0;
        }

        $label_arr = LabelLib::instance()->getAllLabels();
        $all_access = UsersLabelAccess::field('type,label_id,menu_id,menu_detail_id')->select()->toArray();

        $menu_access = [];
        $menu_detail_access = [];
        foreach ($all_access as $value) {
            if ($value['type'] == 0) $menu_access[$value['label_id']][] = $value['menu_id'];
            $tmp_value = "{$value['menu_id']}___{$value['menu_detail_id']}";
            if ($value['type'] == 1) $menu_detail_access[$value['label_id']][] = $tmp_value;
        }

        $all_access_also = $service->getAllAccessAlso(2);

        foreach ($label_arr as $key => $value) {
            $tmp_menu_access = $menu_access[$value['id']] ?? [];
            $tmp_menu_detail_access = $menu_detail_access[$value['id']] ?? [];
            $tmp_data = [
                'menu_id' => implode(',', $tmp_menu_access),
                'menu_detail_ids' => implode(',', $tmp_menu_detail_access),
            ];

            foreach (AccessService::ACCESS_KEYS as $k => $v) {
                $tmp_data[$v] = $all_access_also[$value['id']][$v] ?? '';
            }

            $label_arr[$key]['access'] = json_encode($tmp_data);
        }


        // 合并 标签 和权限
        $all_label_access = UsersLabelAccess::field('type,label_id,menu_id,menu_detail_id')->select()->toArray();
        $menu_access2 = [];
        $menu_detail_access2 = [];
        foreach ($all_label_access as $value) {
            if ($value['type'] == 0) $menu_access2[$value['label_id']][] = $value['menu_id'];
            $tmp_value = "{$value['menu_id']}___{$value['menu_detail_id']}";
            if ($value['type'] == 1) $menu_detail_access2[$value['label_id']][] = $tmp_value;
        }

        foreach ($all_labels as $key => $value) {
            $tmp_menu_access = $menu_access2[$value['id']] ?? [];
            $tmp_menu_detail_access = $menu_detail_access2[$value['id']] ?? [];
            $tmp_data = [
                'menu_id' => implode(',', $tmp_menu_access),
                'menu_detail_ids' => implode(',', $tmp_menu_detail_access),
            ];
            $all_labels[$key]['access'] = json_encode($tmp_data);
        }

        // 默认选中 第一个元素
        if (!isset($params['id'])) $params['id'] = reset($all_labels)['id'];

        // allow system
        $allow_systems = ConfLib::instance()->getAllowSystem();

        $menu_tree = MenuLib::instance()->getMenuTree($params['module_id'], $params['id'], 2);

        // echo '<pre>';var_dump($menu_tree);echo '</pre>';
        // exit;
        $all_stores = RedisLib::instance()->getAllStores();
        $all_accounts = RedisLib::instance()->getAllErpAccounts(3);
        $all_access_order_status = RedisLib::instance()->getTopMenu();

        // 获取 其他 权限
        $access_also = $service->getAccessAlso($params['id'], $params['module_id'], 2);
        $store_access_also = $access_also['store_id'] ?? [];
        $account_access_also = $access_also['account'] ?? [];
        $order_status_access_also = $access_also['order_status'] ?? [];

        foreach ($all_stores as $key => $value) {
            $all_stores[$key]['access'] = in_array($value['id'], $store_access_also) ? 1 : 0;
        }

        $account_access = [];
        foreach ($all_accounts as $key => $value) {
            foreach ($value as $k => $v) {
                $account_access[$v] = in_array($k, $account_access_also) ? 1 : 0;
            }
        }
        $this->assign('account_access', $account_access);

        foreach ($all_access_order_status as $key => $value) {
            $all_access_order_status[$key]['access'] = in_array($value['id'], $order_status_access_also) ? 1 : 0;
        }
        ksort($all_access_order_status);

        $scroll_data = [];
        foreach ($menu_tree['data'] as $value) {
            $scroll_data[] = ['id' => $value['id'], 'title' => $value['title']];
        }

        $default_platform = array_keys($all_accounts)[0] ?? '';

        $this->assign('adaptive', '');
        $this->assign('all_labels', $all_labels);
        $this->assign('all_stores', $all_stores);
        $this->assign('all_accounts', $all_accounts);
        $this->assign('default_platform', $default_platform);
        $this->assign('all_access_order_status', $all_access_order_status);

        $this->assign('allow_systems', $allow_systems);
        $this->assign('params', $params);
        $this->assign('scroll_data', $scroll_data);
        $this->assign('menu_tree', $menu_tree['data']);
        $this->assign('label_arr', $label_arr);


        $this->assign('access_also', true);
        $this->assign('store_access_also', true);
        $this->assign('account_access_also', true);
        $this->assign('order_status_access_also', true);

        return parent::fetchAuto('index');
    }


    /**
     * 保存 标签权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-16 19:51:48
     */
    public function savetag()
    {
        $label_id = input('post.id', 0);
        $params = input('post.');
        $service = new AccessService();

        if (!$label_id) return json(['code' => -1, 'msg' => '参数错误']);

        $ret = $service->updateTagAccess($label_id, $params);

        return json($ret);
    }


    /**
     * 用户可见权限
     * @return void
     * @author lamkakyun
     * @date 2019-04-24 16:47:50
     */
    public function useralso()
    {
        $params = input('get.');
        $params['module_id'] = 2;

        $all_jobs = JobLib::instance()->getJobArray();

        if (!isset($params['job_id']) || !preg_match('/^\d+$/', $params['job_id'])) $params['job_id'] = reset($all_jobs)['id'];

        $job_info = $all_jobs[$params['job_id']];

        $tmp_data = UsersJobAccessAlso::where(['job_id' => $params['job_id']])->select()->toArray();
        $job_access_also = [];
        foreach ($tmp_data as $value) {
            $job_access_also[$value['keys']] = array_filter(array_map('trim', explode(',', $value['values'])), function ($v) {
                return $v != '';
            });
        }

        $store_id_also = $job_access_also['store_id'] ?? [];
        $account_also = $job_access_also['account'] ?? [];
        $order_status_also = $job_access_also['order_status'] ?? [];

        $all_users = $job_info['job_users'] ?? [];

        if (!isset($params['user_id']) || !preg_match('/^\d+$/', $params['user_id'])) $params['user_id'] = reset($all_users)['id'] ?? 0;

        // id 放到 key 上
        $tmp_data = $all_users;
        $all_users = [];
        foreach ($tmp_data as $key => $value) {
            $all_users[$value['id']] = $value;
        }

        foreach ($all_jobs as $key => $value) {
            $all_jobs[$key]['job_users_json'] = json_encode($value['job_users']);
        }

        $user_info = $all_users[$params['user_id']] ?? [];

        $all_stores = RedisLib::instance()->getAllStores();
        $all_stores = array_filter($all_stores, function ($v) use ($store_id_also) {
            return in_array($v['id'], $store_id_also);
        });

        $all_accounts = RedisLib::instance()->getAllErpAccounts(3);
        foreach ($all_accounts as $key => $value) {
            foreach ($value as $k => $v) {
                if (!in_array($k, $account_also)) unset($all_accounts[$key][$k]);
            }
            if (empty($all_accounts[$key])) unset($all_accounts[$key]);
        }

        $all_access_order_status = RedisLib::instance()->getTopMenu();
        $all_access_order_status = array_filter($all_access_order_status, function ($v) use ($order_status_also) {
            return in_array($v['id'], $order_status_also);
        });


        $also = $params['user_id'] ? UsersAlso::where(['module_id' => $params['module_id'], 'user_id' => $params['user_id']])->select()->toArray() : [];
        $tmp_data = $also;
        $also = [];
        foreach ($tmp_data as $key => $value) {
            $also[$value['keys']] = array_filter(array_map('trim', explode(',', $value['values'])), function ($v) {
                return $v != '';
            });
        }

        $store_access_also = $also['store_id'] ?? [];
        $account_access_also = $also['account'] ?? [];
        $order_status_access_also = $also['order_status'] ?? [];

        foreach ($all_stores as $key => $value) {
            $all_stores[$key]['access'] = in_array($value['id'], $store_access_also) ? 1 : 0;
        }

        $account_access = [];
        foreach ($all_accounts as $key => $value) {
            foreach ($value as $k => $v) {
                $account_access[$v] = in_array($k, $account_access_also) ? 1 : 0;
            }
        }

        $default_platform = array_keys($all_accounts)[0] ?? '';

        foreach ($all_access_order_status as $key => $value) {
            $all_access_order_status[$key]['access'] = in_array($value['id'], $order_status_access_also) ? 1 : 0;
        }
        ksort($all_access_order_status);

        $this->assign('adaptive', '');
        $this->assign('unclickable', '1');

        $this->assign('account_access', $account_access);
        $this->assign('job_info', $job_info);
        $this->assign('user_info', $user_info);
        $this->assign('default_platform', $default_platform);

        $this->assign('all_jobs', $all_jobs);
        $this->assign('all_users', $all_users);
        $this->assign('params', $params);

        $this->assign('all_stores', $all_stores);
        $this->assign('all_accounts', $all_accounts);
        $this->assign('all_access_order_status', $all_access_order_status);

        return parent::fetchAuto();
    }


    /**
     * 用户可见权限保存
     * @return void
     * @author lamkakyun
     * @date 2019-04-24 16:48:06
     */
    public function useralsosave()
    {
        $params = input('post.');
        $service = new AccessService();

        $ret = $service->updateUserAlso($params);
        return json($ret);
    }
}


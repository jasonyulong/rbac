<?php

// +----------------------------------------------------------------------
// | redis 缓存库
// +----------------------------------------------------------------------
// | COPYRIGHT (C) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | AUTHOR : lamkakyun
// | DATE   : 2019-04-15 18:24:41
// | VERSION：0.0.1
// +----------------------------------------------------------------------
namespace app\common\library;

use think\Cache;
use think\Config;
use app\common\model\erp\EbayUser;
use app\common\model\erp\EbayStore;
use app\common\model\erp\EbayAccount;
use app\common\model\erp\EbayTopmenu;

class RedisLib
{

    public function __construct()
    {
        $this->redis = Cache::init(Config::get('cache.redis'));
        $this->defaultTimout = 5 * 60; // 默认缓存时间，5分钟
    }

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
     * 获取所有 erp 的用户信息
     * @return void
     * @author lamkakyun
     * @date 2019-04-15 18:26:49
     */
    public function getAllErpUsers($format_type = 1)
    {
        $key = Config::get('redis.all_erp_users');
        $data = $this->redis->get($key);

        if (!$data) {
            $fields = 'id, username, is_del';
            $data = EbayUser::field($fields)->select()->toArray();
            $this->redis->set($key, $data, $this->defaultTimout);
        }

        switch ($format_type) {
            // id 放到 key 上
            case '1':
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[$value['id']] = $value;
                }
                break;
        }

        return $data;
    }


    /**
     * 获取所有账号信息
     * @return void
     * @author lamkakyun
     * @date 2019-04-16 09:29:16
     */
    public function getAllErpAccounts($format_type = 1)
    {
        $key = Config::get('redis.all_erp_accounts');
        $data = $this->redis->get($key);

        if (!$data) {
            $fields = 'id, ebay_account, platform';
            $where = ['status' => 1];
            $data = EbayAccount::field($fields)->where($where)->select()->toArray();
            $this->redis->set($key, $data, $this->defaultTimout);
        }

        switch ($format_type) {
            // id 放到 key 上
            case '1':
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[$value['id']] = $value;
                }
                break;
            case '2': // 将ebay_account 放到 key 的位置上
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[$value['ebay_account']] = $value;
                }
                break;
            case '3': // 以平台为分组
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[$value['platform']][$value['id']] = $value['ebay_account'];
                }
                foreach ($data as $key => $value) {
                    asort($value);
                    $data[$key] = $value;
                }
                break;
            case '4': // 建立一个 ebay_account -> platform 的映射, (因为数据表中就是一对一的，所以没问题)
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[trim($value['ebay_account'])] = trim($value['platform']);
                }
                break;
        }

        return $data;
    }


    /**
     * 获取所有仓库信息
     * @return void
     * @author lamkakyun
     * @date 2019-04-16 09:45:10
     */
    public function getAllStores($format_type = 1)
    {
        $key = Config::get('redis.all_erp_stores');
        $data = $this->redis->get($key);

        if (!$data) {
            $fields = 'id, store_name, store_sn';
            $data = EbayStore::field($fields)->select()->toArray();
            $this->redis->set($key, $data, $this->defaultTimout);
        }

        switch ($format_type) {
            // id 放到 key 上
            case '1':
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[$value['id']] = $value;
                }
                break;
        }

        return $data;
    }


    /**
     * 订单状态（订单可见性）
     * @return void
     * @author lamkakyun
     * @date 2019-04-18 17:17:37
     */
    public function getTopMenu($format_type = 1)
    {
        $key = Config::get('redis.erp_topmenu');
        $data = $this->redis->get($key);

        if (!$data) {
            $fields = 'id, name';
            $data = EbayTopmenu::field($fields)->select()->toArray();
            $this->redis->set($key, $data, $this->defaultTimout);
        }
        if (empty($data) || !is_array($data)) return [];

        $others = [
            ['id' => '0', 'name' => '未付款'],
            ['id' => '1', 'name' => '待处理'],
            ['id' => '2', 'name' => '已经发货'],
        ];

        $data = array_merge($data, $others);

        switch ($format_type) {
            // id 放到 key 上
            case '1':
                $tmp = $data;
                $data = [];
                foreach ($tmp as $value) {
                    $data[$value['id']] = $value;
                }
                break;
        }

        return $data;
    }
}
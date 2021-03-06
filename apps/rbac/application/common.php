<?php
// +----------------------------------------------------------------------
// | 应用公共方法文件
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.jeoshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: kevin
// +----------------------------------------------------------------------
use plugin\Form;
use think\cache\driver\Redis;
use think\Config;

// 应用公共文件

if (!function_exists('__')) {
    /**
     * 获取语言变量值
     * @param string $name 语言变量名
     * @param array $vars 动态变量值
     * @param string $lang 语言
     * @return mixed
     */
    function __($name, $vars = [], $lang = ''): string
    {
        if (is_numeric($name) || !$name)
            return $name;
        if (!is_array($vars)) {
            $vars = func_get_args();
            array_shift($vars);
            $lang = '';
        }

        return \think\Lang::get($name, $vars, $lang);
    }
}

/**
 * 拼接生成url
 */
if (!function_exists('urlbuld')) {
    function urlbuld($url, $str = '',$array = [])
    {
        return url($url . $str,$array);
    }
}

/**
 * 滞留时间
 */
if (!function_exists('retentionTimes')) {
    function retentionTimes($createtime)
    {
        $second = time() - $createtime;
        // 小于1分钟
        if ($second < 60) {
            return $second . '秒';
        }
        if ($second < 3600) {
            return '<span class="text-success">' . intval($second / 60) . '分钟</span>';
        }
        if ($second < 86400) {
            return '<span class="text-primary">' . intval($second / 3600) . '小时</span>';
        }
        $days = intval($second / 86400);

        return '<span class="error">' . $days . '天</span>';
    }
}

if (!function_exists('datetime')) {

    /**
     * 将时间戳转换为日期时间
     * @param int $time 时间戳
     * @param string $format 日期时间格式
     * @return string
     */
    function datetime($time, $format = 'Y-m-d H:i:s')
    {
        $time = is_numeric($time) ? $time : strtotime($time);

        return date($format, $time);
    }

}

if (!function_exists('is_really_writable')) {

    /**
     * 判断文件或文件夹是否可写
     * @param string $file 文件或目录
     * @return    bool
     */
    function is_really_writable($file)
    {
        if (DIRECTORY_SEPARATOR === '/') {
            return is_writable($file);
        }
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand(0, 6));
            if (($fp = @fopen($file, 'ab')) === FALSE) {
                return FALSE;
            }
            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);

            return TRUE;
        } elseif (!is_file($file) OR ($fp = @fopen($file, 'ab')) === FALSE) {
            return FALSE;
        }
        fclose($fp);

        return TRUE;
    }

}

if (!function_exists('rmdirs')) {

    /**
     * 删除文件夹
     * @param string $dirname 目录
     * @param bool $withself 是否删除自身
     * @return boolean
     */
    function rmdirs($dirname, $withself = true)
    {
        if (!is_dir($dirname))
            return false;
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        if ($withself) {
            @rmdir($dirname);
        }

        return true;
    }

}

if (!function_exists('copydirs')) {

    /**
     * 复制文件夹
     * @param string $source 源文件夹
     * @param string $dest 目标文件夹
     */
    function copydirs($source, $dest)
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
        foreach (
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                $sontDir = $dest . DS . $iterator->getSubPathName();
                if (!is_dir($sontDir)) {
                    mkdir($sontDir, 0755, true);
                }
            } else {
                copy($item, $dest . DS . $iterator->getSubPathName());
            }
        }
    }
}

if (!function_exists('can')) {
    /**
     * 判断当前用户是否具有参数指定的权限
     * @param string $operation
     * @return array|bool
     */
    function can($operation = '')
    {
        $auth = \app\common\library\auth\Token::instance();
        if ($auth->id <= 0) return false;

        // 岗位ID
        $jobId = $auth->jobId;
        // 权限标签ID
        $rulesId = $auth->getRulesId();
        // 系统ID
        $system_id = \think\Config::get('app.system_id');
        // 权限获取类
        $accessService = new \app\common\library\auth\Access();
        // 超级管理员拥有所有权限
        if ($jobId == 1 || in_array(1, $rulesId)) {
            return true;
        }

        $access = $accessService->getAccess($auth->id, $system_id, $jobId, $rulesId);
        if (empty($access)) return false;

        // 拆分URL
        $explode = explode("?", trim($operation, '/'));
        if (empty($explode) || empty($explode[0])) return false;
        $path = str_replace('.html', '', $explode[0]);

        return in_array($path, $access);
    }
}

if (!function_exists('build_toolbar')) {

    /**
     * 生成表格操作按钮栏
     * @param null $type 类型
     * @param array $options 参数
     * @param null $title 标题
     * @return string
     */
    function build_toolbar($type = NULL, $options = [], $title = NULL)
    {
        $auth = \app\common\library\auth\Token::instance();
        // 系统ID
        $system_id = \think\Config::get('app.system_id');

        $html = $optionsHtml = $url = '';
        switch ($type) {
            // 按钮
            case  'button':
                if (!empty($options)) {
                    foreach ($options as $key => $val) {
                        $optionsHtml .= sprintf(' %s="%s"', $key, $val);
                    }
                }
                $url = $options['data-url'] ?? ($options['url'] ?? '');
                $html .= sprintf('<button %s>%s</button>', $optionsHtml, __($title));
                break;
            // A标签
            case 'a':
                if (!empty($options)) {
                    foreach ($options as $key => $val) {
                        $optionsHtml .= sprintf(' %s="%s"', $key, $val);
                    }
                }
                $url = $options['href'] ?? ($options['data-url'] ?? '');
                $html .= sprintf('<a %s>%s</a>', $optionsHtml, __($title));
                break;
        }
        // 拆分URL
        $explode = explode("?", trim($url, '/'));
        if (empty($explode) || empty($explode[0])) return '';
        $path = str_replace('.html', '', $explode[0]);
        // 校验权限
        if (empty($path) || !$auth->check($system_id, $path)) {
            return '';
        }

        return $html;
    }
}

if (!function_exists('build_select')) {

    /**
     * 生成下拉列表
     * @param string $name
     * @param mixed $options
     * @param mixed $selected
     * @param mixed $attr
     * @return string
     */
    function build_select($name, $options, $selected = [], $attr = [])
    {
        $options = is_array($options) ? $options : explode(',', $options);
        $selected = is_array($selected) ? $selected : explode(',', $selected);

        return Form::select($name, $options, $selected, $attr);
    }
}


if (!function_exists('build_radios')) {

    /**
     * 生成单选按钮组
     * @param string $name
     * @param array $list
     * @param mixed $selected
     * @return string
     */
    function build_radios($name, $list = [], $selected = null)
    {
        $html = [];
        $selected = is_null($selected) ? key($list) : $selected;
        $selected = is_array($selected) ? $selected : explode(',', $selected);
        foreach ($list as $k => $v) {
            $html[] = sprintf(Form::label("{$name}-{$k}", "%s {$v}"), Form::radio($name, $k, in_array($k, $selected), ['id' => "{$name}-{$k}"]));
        }

        return '<div class="radio">' . implode(' ', $html) . '</div>';
    }
}

if (!function_exists('build_checkboxs')) {

    /**
     * 生成复选按钮组
     * @param string $name
     * @param array $list
     * @param mixed $selected
     * @return string
     */
    function build_checkboxs($name, $list = [], $selected = null)
    {
        $html = [];
        $selected = is_null($selected) ? [] : $selected;
        $selected = is_array($selected) ? $selected : explode(',', $selected);
        foreach ($list as $k => $v) {
            $html[] = sprintf(Form::label("{$name}-{$k}", "%s {$v}"), Form::checkbox($name, $k, in_array($k, $selected), ['id' => "{$name}-{$k}"]));
        }

        return '<div class="checkbox">' . implode(' ', $html) . '</div>';
    }
}

if (!function_exists('user_online')) {
    /**
     * 判断用户是否在线
     * @param null $token
     * @return int
     */
    function user_online($token = null)
    {
        if (empty($token)) {
            return 0;
        }
        // 解出token信息
        $users = \app\common\library\auth\Drive::instance()->decodeToken($token);
        if (empty($users)) {
            return 0;
        }
        $redis = new Redis(Config::get('cache.redis'));
        // 判断token是否存在
        $tokenRedis = $redis->handler()->hget(Config::get('redis.user_token'), $users['id']);
        if (!$tokenRedis || $tokenRedis != $token) {
            return 0;
        }
        $users = (object)$users;
        $time = time();
        if ($users->expiretime >= $time) {
            return 1;
        }
        return 0;
    }
}

if (!function_exists('user_online_html')) {
    /**
     * 在线状态html
     * @param $token
     * @return string
     */
    function user_online_html($token = null)
    {
        $status = user_online($token);
        if ($status == 0) {
            return '<span class="label label-danger">离线</span>';
        }

        return '<span class="label label-primary">在线</span>';
    }
}

if (!function_exists('grepDocComment')) {
    /**
     * 匹配反射出来的注释
     * @param $doc
     * @param string $name
     * @param string $default
     * @return string
     */
    function grepDocComment($doc, $name = '', $default = '')
    {
        if (empty($doc)) return $default;
        if (preg_match('#^/\*\*(.*)\*/#s', $doc, $comment) === false)
            return $default;

        $comment = trim($comment[1]);
        if (preg_match_all('#^\s*\*(.*)#m', $comment, $lines) === false)
            return $default;

        $docLines = ($lines[1]);
        if (empty($name))
            return trim(trim($docLines[0], '@name')) ?? $default;
    }
}


if (!function_exists('json_tostring')) {
    /**
     * json 转成字符串
     * @param $json
     * @return string
     */
    function json_tostring($json)
    {
        if (empty($json)) return '--';
        $arr = json_decode($json, true);

        if (empty($arr)) {
            return '--';
        }

        return array_tostring($arr);
    }
}

if (!function_exists('array_tostring')) {
    /**
     * 数组转成字符串
     * @param $arr
     * @return string
     */
    function array_tostring($arr)
    {
        if (empty($arr)) return '--';
        $str = '';
        foreach ($arr as $key => $val) {
            $str .= is_array($val) ? array_tostring($val) : sprintf("%s=%s，", $key, $val);
        }

        return trim($str, '，');
    }
}

if (!function_exists('tree_to_array')) {
    /**
     * 树状 转换成 一维数组
     * @return void
     * @author lamkakyun
     * @date 2019-04-15 14:13:42
     */
    function tree_to_array($tree, &$ret_data)
    {
        foreach ($tree as $key => $value) {
            $children = $value['children'] ?? [];
            if ($children) unset($value['children']);
            $ret_data[$value['id']] = $value;
            if ($children) tree_to_array($children, $ret_data);
        }
    }
}

if (!function_exists('tranform_data')) {
    /**
     * 树状 转换成 一维数组
     * @return void
     * @author lamkakyun
     * @date 2019-04-15 14:13:42
     */
    function tranform_data($data, $format_type = 1)
    {
        $ret_data = [];

        switch ($format_type) {
            case '1': // id 放到 key 的位置上
                foreach ($data as $value) {
                    $ret_data[$value['id']] = $value;
                }
                break;
        }

        return $ret_data;
    }
}
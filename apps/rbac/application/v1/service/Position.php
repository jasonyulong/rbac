<?php
/**
 * @Copyright (C), ZhuoShi.
 * @Author: 杨能文
 * @Name: Position.php
 * @Date: 2019/4/1
 * @Time: 14:55
 * @Description
 */

namespace app\v1\service;

use app\common\model\Users;
use app\common\model\UsersJob;
use app\common\model\UsersJobAccess;
use plugin\Tree;
use think\Config;

class Position extends Base
{
    /**
     * @var UsersJob|null 岗位模型
     */
    private $userJob = null;

    /**
     * @var Users|null 用户模型
     */
    private $users = null;

    /**
     * @var UsersJobAccess|null 岗位权限模型
     */
    private $usersJobAccess = null;

    /**
     * Position constructor.
     */
    public function __construct()
    {
        $this->userJob = new UsersJob();
        $this->users = new Users();
        $this->usersJobAccess = new UsersJobAccess();
    }

    /**
     * @desc 新增岗位
     * @param $request
     * @return bool
     * @author 杨能文
     */
    public function add($request): bool
    {
        $addData = [
            'pid' => (int)($request['pid'] ?? 0),
            'title' => trim($request['title']),
            'weigh' => (int)$request['weigh'],
            'auto_account' => (int)$request['auto_account'],
            'createtime' => time(),
            'updatetime' => time(),
            'status' => 1, //0禁用，1启用
        ];

        $res = $this->checkpos($addData['title'], $addData['pid']);
        if ($res) {
            $this->setErrors(0, __('父级岗位下存在相同岗位名称'));
            return false;
        }

        $userJob = $this->userJob;
        $treeClass = \plugin\TreeClass::instance($userJob);

        $addData['rank'] = $this->rank($addData['pid']);
        if ($addData['pid'] > 0) {
            $parent = $userJob->where(['id' => $addData['pid']])->find();
            $addData['tid'] = $parent->tid;
        }

        // 启动事务
        $userJob->startTrans();
        try {
            // 开始更新左右值
            $return = $treeClass->add($addData['pid']);
            // 插入
            $id = $userJob->insert(array_merge($addData, $return), false, true);
            if ($addData['pid'] <= 0) {
                $userJob->where(['id' => $id])->update(['tid' => $id]);
            }
            //岗位绑定给用户
            if (isset($request['user_id'])) $this->bindUserPos($request['user_id'], $id);
            // 提交事务
            $userJob->commit();
            //更新岗位用户数
            if (isset($request['user_id'])) $this->updateunder($id);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('添加岗位失败'));
            // 回滚事务
            $userJob->rollback();

            return false;
        }
    }

    /**
     * @desc 编辑岗位
     * @param $data
     * @return bool
     * @author 杨能文
     * @date 2019/4/1 14:57
     * @access public
     */
    public function edit($data): bool
    {
        $id = $data['id'];
        $save = [
            'pid' => (int)$data['pid'],
            'title' => trim($data['title']),
            'weigh' => (int)$data['weigh'],
            'auto_account' => (int)$data['auto_account'],
            'updatetime' => time(),
        ];
        $save['rank'] = $this->rank($save['pid']);

        $res = $this->checkpos($save['title'], $save['pid'], $data['id']);
        if ($res) {
            $this->setErrors(0, __('父级岗位下存在相同岗位名称'));

            return false;
        }

        //获取编辑前岗位信息
        $userJob = $this->userJob;
        $treeClass = \plugin\TreeClass::instance($userJob);
        $info = $userJob->where(['id' => $id])->find();
        $info = is_array($info) ? collection($info)->toArray() : $info->toArray();

        //如果父级岗位发生修改、检测是否存在子岗位、存在不允许修改(原因:扰乱层级关系)
        $sonTitle = $this->checkson($id);
        if ($save['pid'] != $info['pid'] && $sonTitle) {
            $this->setErrors(0, __("存在子级岗位【{$sonTitle}】、不允许修改【父级名称】"));

            return false;
        }

        // 启动事务
        $userJob->startTrans();
        try {
            // 开始更新左右值
            if ($save['pid'] != $info['pid']) {
                $return = $treeClass->add($save['pid']);
                $save = array_merge($save, $return);
            }
            //更新
            $userJob->update($save, ['id' => $id]);
            if ($save['pid'] != $info['pid']) $this->tid($id);
            //岗位绑定给用户
            $userIdArr = isset($data['user_id']) ? $data['user_id'] : [];
            $this->bindUserPos($userIdArr, $id, 1);
            // 提交事务
            $userJob->commit();
            $this->updateunder($id);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('编辑岗位失败'));
            // 回滚事务
            $userJob->rollback();

            return false;
        }
    }

    /**
     * @desc 岗位绑定用户
     * @param array $userIdArr 用户表id数组
     * @param int $job_id 岗位id
     * @param int $is_edit 是否编辑
     * @return bool
     * @author 杨能文
     * @date 2019/4/23 16:22
     * @access public
     */
    public function bindUserPos($userIdArr = [], $job_id, $is_edit = 0): bool
    {
        if (!is_numeric($job_id)) return false;
        $userModel = $this->users;
        if ($userIdArr) {
            $jobIdArr = $userModel->where(['id' => ['in', $userIdArr], 'job_id' => ['neq', 0]])->column('job_id');
            $userModel->update(['job_id' => $job_id], ['id' => ['in', $userIdArr]]);
            //以前绑定过岗位的更新下级用户数
            $jobIdArr = array_unique($jobIdArr);
            foreach ($jobIdArr as $jobId) {
                if ($jobId != $job_id) $this->updateunder($jobId);
            }
        }
        //编辑需要解绑未选择的用户
        if ($is_edit) {
            $map = ['job_id' => $job_id];
            if ($userIdArr) $map['id'] = ['not in', $userIdArr];
            $userModel->update(['job_id' => 0], $map);
        }
        return true;
    }

    /**
     * @desc 获取岗位相关用户id
     * @param int $job_id
     * @return array
     * @author 杨能文
     * @date 2019/4/23 16:49
     * @access public
     */
    public function getPosUserId($job_id): array
    {
        if (!$job_id) return [];
        $userModel = $this->users;
        $idArr = $userModel->where(['job_id' => $job_id, 'status' => 1])->column('id');
        return $idArr;
    }

    /**
     * @desc 获取已绑定岗位用户
     * @return array
     * @author 杨能文
     * @date 2019/4/23 17:26
     * @access public
     */
    public function getBindPosId(): array
    {
        $userModel = $this->users;
        $idArr = $userModel->where(['job_id' => ['gt', 0], 'status' => 1])->column('id');
        return $idArr;
    }

    /**
     * @desc 复制岗位
     * @param $data
     * @return bool
     * @author 杨能文
     * @date 2019/4/3 15:12
     * @access public
     */
    public function copy($data): bool
    {
        $time = time();
        $addData = [
            'pid' => (int)($data['pid'] ?? 0),
            'title' => trim($data['title']),
            'weigh' => (int)$data['weigh'],
            'createtime' => $time,
            'updatetime' => $time,
            'status' => 1, //0禁用，1启用
        ];
        $res = $this->checkpos($addData['title'], $addData['pid']);
        if ($res) {
            $this->setErrors(0, __('父级岗位下存在相同岗位名称'));

            return false;
        }

        $userJob = $this->userJob;
        $treeClass = \plugin\TreeClass::instance($userJob);

        $addData['rank'] = $this->rank($addData['pid']);
        if ($addData['pid'] > 0) {
            $parent = $userJob->where(['id' => $addData['pid']])->find();
            $addData['tid'] = $parent->tid;
        }

        // 启动事务
        $userJob->startTrans();
        try {
            // 开始更新左右值
            $return = $treeClass->add($addData['pid']);
            // 插入
            $id = $userJob->insert(array_merge($addData, $return), false, true);
            if ($addData['pid'] <= 0) {
                $userJob->where(['id' => $id])->update(['tid' => $id]);
            }
            //复制权限
            $authArr = $this->positionauth($data['id']);
            if ($authArr) {
                $time = time();
                $usersJobAccess = $this->usersJobAccess;
                foreach ($authArr as $val) {
                    unset($val['id']);
                    unset($val['updatetime']);
                    $val['createtime'] = $time;
                    $val['job_id'] = $id;
                    $usersJobAccess->insert($val);
                }
            }

            // 提交事务
            $userJob->commit();

            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('复制岗位失败'));
            // 回滚事务
            $userJob->rollback();

            return false;
        }
    }


    /**
     * @desc 根据岗位id获取岗位权限
     * @param $job_id 岗位id
     * @return array
     * @author 杨能文
     * @date 2019/4/3 15:21
     * @access public
     */
    public function positionauth($job_id): array
    {
        if (!$job_id) return [];
        $usersJobAccess = $this->usersJobAccess;
        $data = $usersJobAccess->where(['job_id' => $job_id])->select();

        return collection($data)->toArray();
    }


    /**
     * @desc 检测子岗位
     * @param $id
     * @return string
     * @author 杨能文
     * @date 2019/4/2 9:59
     * @access public
     */
    public function checkson($id): string
    {
        if (empty($id)) return 0;
        $userJob = $this->userJob;
        $son = $userJob->where(['pid' => $id])->value('title');

        return $son ? $son : '';
    }

    /**
     * @desc 获取层级
     * @param $pid
     * @access public
     * @return string
     * @author 杨能文
     * @date 2019/4/2 9:20
     */
    public function rank($pid): string
    {
        if (empty($pid)) return 1;
        $userJob = $this->userJob;
        $rank = $userJob->where(['id' => $pid])->value('rank');
        $rank = $rank > 0 ? $rank + 1 : 1;

        return $rank;
    }

    /**
     * @desc 更新顶级类的tid
     * @param $id
     * @author 杨能文
     * @date 2019/4/1 16:52
     * @access public
     */
    public function tid($id)
    {
        $userJob = $this->userJob;
        $userJob->update(['tid' => $id], ['id' => $id, 'pid' => 0]);
    }

    /**
     * @desc 获取所有的岗位
     * @return array
     * @author 杨能文
     * @date 2019/4/1 15:54
     * @access public
     */
    public function position(): array
    {
        $userJob = $this->userJob;
        // 必须将结果集转换为数组
        $ruleList = collection($userJob->where(['status' => 1])->order('weigh', 'desc')->select())->toArray();

        Tree::instance()->init($ruleList);
        $rulelist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');

        return $rulelist;
    }

    /**
     * @desc 获取统计后的岗位人员
     * @return array
     * @author 杨能文
     * @date 2019/4/1 18:15
     * @access public
     */
    public function userposition(): array
    {
        $users = $this->users;
        $map = [
            'status' => 1,
            'job_id' => ['gt', 0]
        ];
        $data = $users->field('job_id,count(id) as num')
            ->where($map)
            ->group('job_id')->select();
        if (is_array($data)) $data = collection($data)->toArray();
        $return = [];
        foreach ($data as &$val) {
            $return[$val['job_id']] = $val['num'];
        }

        return $return;
    }

    /**
     * @desc 根据id获取岗位信息
     * @param $id
     * @return array
     * @author 杨能文
     * @date 2019/4/1 20:13
     * @access public
     */
    public function positioninfo($id)
    {
        $userJob = $this->userJob;
        $data = $userJob->where(['id' => $id])->find();
        $data = is_array($data) ? collection($data)->toArray() : $data->toArray();

        return $data;
    }

    /**
     * @desc 批量删除岗位
     * @param  $data
     * @return bool
     * @author 杨能文
     * @date 2019/4/2 11:41
     * @access public
     */
    public function delete($data): bool
    {
        $userJob = $this->userJob;
        $ids = $data['ids'];
        $map = ['id' => ['in', $ids]];
        //按层级倒序、以便删除操作
        $positionArr = $userJob->where($map)->order('rank desc')->column('id,under');
        if (!$positionArr) {
            $this->setErrors(0, __('未找到需要删除的数据'));

            return false;
        }

        $usersJobAccess = $this->usersJobAccess;

        //循环删除数据
        $num1 = 0;
        $num2 = 0;
        foreach ($positionArr as $key => $val) {
            $son = $this->checkson($key);
            if ($son || $val) {
                $num2++;
                continue;
            }
            $res = $userJob->where(['id' => $key])->delete();
            $usersJobAccess->where(['job_id' => $key])->delete();
            if ($res) $num1++;
        }
        if ($num2) {
            $msg = "删除岗位成功条数【{$num1}】.失败条数【{$num2}】原因:【存在子岗位或绑定用户未移除】";
            $this->setErrors(0, __($msg));

            return false;
        }

        return true;
    }

    /**
     * @desc 查看用户
     * @param $params
     * @return array
     * @author 杨能文
     * @date 2019/4/2 16:02
     * @access public
     */
    public function cat($params): array
    {
        //每页显示的数量
        $page_size = !empty($params['ps']) ? $params['ps'] : 10;
        //当前页
        $current_page = (!empty($params['page']) && intval($params['page']) > 0) ? $params['page'] : 1;
        //分页起始值
        $start = $page_size * ($current_page - 1);

        $users = $this->users;

        $where = [];
        if (isset($params['id']) && $params['id']) $where['job_id'] = $params['id'];
        if ($params['username']) $where['username'] = $params['username'];

        //分页url参数
        $config = [
            'query' => request()->param(),
        ];

        $userInfo = $users
            ->field('id,username')
            ->where($where)
            ->limit($start, $page_size)
            ->paginate($page_size, true, $config);

        $page = $userInfo->render();
        $return_data = [
            'list' => $userInfo->toArray(),
            'page' => $page,
        ];

        return $return_data;
    }

    /**
     * @desc 移除用户
     * @param $data
     * @return bool
     * @author 杨能文
     * @date 2019/4/2 17:25
     * @access public
     */
    public function move($data): bool
    {
        $ids = $data['ids'];
        $users = $this->users;
        $job_id = $users->where(['id' => ['in', $ids]])->value('job_id');
        $saveData = ['job_id' => 0];
        try {
            $users->update($saveData, ['id' => ['in', $ids]]);
            $this->updateunder($job_id);

            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('移除用户失败'));// 回滚事务
            return false;
        }
    }

    /**
     * @desc 根据岗位id获取所有父级岗位id
     * @param int $id
     * @param int $is_my 是否返回当前部门id (默认0不返回)
     * @return array
     * @author 杨能文
     * @date 2019/4/10 9:57
     * @access public
     */
    public function getparent($id, $is_my = 0): array
    {
        if (!$id) return [];
        $idArr = $is_my ? [$id] : [];
        $userJob = $this->userJob;
        $info = $userJob->where(['id' => $id])->find()->toArray();
        if (!$info) return $idArr;
        $map = [
            'tid' => $info['tid'],
            'lid' => ['lt', $info['lid']],
            'rid' => ['gt', $info['rid']],
        ];
        $idArr1 = $userJob->where($map)->column('id');

        return $idArr1 ? array_merge($idArr, $idArr1) : $idArr;
    }

    /**
     * @desc 根据岗位id获取所有子级岗位id
     * @param $id
     * @param int $is_my 是否返回当前部门id (默认0不返回)
     * @return array
     * @author 杨能文
     * @date 2019/4/10 14:16
     * @access public
     */
    public function getson($id, $is_my = 0): array
    {
        if (!$id) return [];
        $idArr = $is_my ? [$id] : [];
        $userJob = $this->userJob;
        $info = $userJob->where(['id' => $id])->find();
        $info = is_object($info) ? $info->toArray() : [];
        if (!$info) return $idArr;
        $map = [
            'tid' => $info['tid'],
            'lid' => ['gt', $info['lid']],
            'rid' => ['lt', $info['rid']],
        ];
        $idArr1 = $userJob->where($map)->column('id');

        return $idArr1 ? array_merge($idArr, $idArr1) : $idArr;
    }

    /**
     * @desc 检测同级岗位名称重复
     * @param string $tile
     * @param int $pid
     * @param int $id
     * @return bool
     * @author 杨能文
     * @date 2019/4/10 21:18
     * @access public
     */
    public function checkpos($tile, $pid, $id = 0): bool
    {
        if (!$tile || !is_numeric($pid)) return false;
        $model = $this->userJob;
        $map = [
            'title' => $tile,
            'pid' => $pid,
        ];
        if ($id > 0) $map['id'] = ['neq', $id];
        $id = $model->where($map)->value('id');

        return $id ? true : false;
    }

    /**
     * @desc 更新相关岗位下级用户数
     * @param $job_id
     * @return bool
     * @author 杨能文
     * @date 2019/4/11 9:58
     * @access public
     */
    public function updateunder($job_id): bool
    {
        if (!$job_id) return false;
        $userJob = $this->userJob;
        $users = $this->users;

        //获取所有相关岗位信息
        $tid = $userJob->where(['id' => $job_id])->value('tid');
        if (!$tid) return false;
        $obj = $userJob->where(['tid' => $tid])->field('id,pid,rank,title')->order('rank desc')->select();
        $userJobArr = collection($obj)->toArray();
        if (!$userJobArr) return false;

        //分组统计用户数据
        $obj = $users->field('job_id,count(id) as num')->where(['job_id' => ['in', array_column($userJobArr, 'id')]])->group('job_id')->select();
        $userArr = collection($obj)->toArray();

        //键值数组
        $keyArr = array_column($userArr,'num','job_id');

        //将查询的下级用户数写入数组
        foreach ($userJobArr as &$val) {
            $key = $val['id'];
            $val['num'] = isset($keyArr[$key]) ? $keyArr[$key] : 0;
        }

        //为父级部门统计下级用户数
        $saveData = [];
        foreach ($userJobArr as $val) {
            $arr = ['id' => $val['id'], 'under' => $val['num']];
            array_push($saveData,$arr);
        }
        $userJob->saveAll($saveData);
        return true;
    }

    /**
     * @desc 为父级岗位统计下级用户数
     * @param $array
     * @param $rank
     * @return array
     * @author 杨能文
     * @date 2019/4/11 14:19
     * @access public
     */
    public function parentunder($array, $rank): array
    {
        static $list = [];
        foreach ($array as $key => $value) {
            if ($value['rank'] == $rank) {
                $list[$value['id']] = [
                    'id' => $value['id'], 'pid' => $value['pid'], 'rank' => $value['rank'], 'title' => $value['title'],
                    'num' => isset($list[$value['id']]['num']) ? $list[$value['id']]['num'] + $value['num'] : $value['num'],
                ];
                if ($value['pid']) $list[$value['pid']]['num'] = isset($list[$value['pid']]['num']) ? $list[$value['pid']]['num'] + $list[$value['id']]['num'] : $list[$value['id']]['num'];
                unset($array[$key]);
            }
        }
        if ($array) $this->parentunder($array, $rank - 1);

        return $list;
    }
}

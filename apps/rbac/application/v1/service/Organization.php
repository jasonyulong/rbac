<?php
/**
 * @Copyright (C), ZhuoShi.
 * @Author: 杨能文
 * @Name: Organization.php
 * @Date: 2019/4/9
 * @Time: 14:22
 * @Description
 */


namespace app\v1\service;


use app\common\model\erp\EbayAccount;
use app\common\model\erp\EbayStore;
use app\common\model\OrganizationUser;
use app\common\model\Users;
use app\common\model\UsersLabel;
use app\common\model\OrganizationUserAccount;
use plugin\Tree;
use think\Config;
use think\Cache;

class Organization extends Base
{
    /**
     * @var null 组织架构成员模型
     */
    private $organizationUser = null;

    /**
     * @var null 权限模型
     */
    private $userLabel = null;

    /**
     * @var Users|null 用户模型
     */
    private $users = null;

    /**
     * @var null 组织架构模型
     */
    private $organization = null;

    /**
     * @var null 成员账号模型
     */
    private $organizationAccount = null;

    /**
     * @var null 部门服务层
     */
    private $departmentService = null;

    /**
     * @var null 仓库数据模型
     */
    private $ebayStore = null;

    /**
     * @var null 帐号数据模型
     */
    private $ebayAccount = null;

    /**
     * @var null redis缓存
     */
    private $redis = null;

    /**
     * Position constructor.
     */
    public function __construct()
    {
        $this->userLabel = new UsersLabel();
        $this->users = new Users();
        $this->organizationUser = new OrganizationUser();
        $this->organization = new \app\common\model\Organization();
        $this->departmentService = new Department();
        $this->organizationAccount = new OrganizationUserAccount();
        $this->ebayAccount = new EbayAccount();
        $this->ebayStore = new EbayStore();
        $this->redis = Cache::init(Config::get('cache.redis'));
    }

    /**
     * 获取组织架构列表
     * @param int $select_id 选中ID
     * @return string
     */
    public function orglists($select_id = 0)
    {
        $organization = collection(\app\common\model\Organization::where(['status' => 1])->order('weigh', 'desc')->select())->toArray();
        if (empty($organization)) return '';

        $topOrganization = [];
        foreach ($organization as $index => &$item) {
            $item['title'] = sprintf('%s [%s]', $item['title'], $item['manage']);
            $item['icon'] = 'fa fa-chevron-right';
            $item['url'] = url('/v1/group/organization/index', ['org_id' => $item['id']]);
            if (!$item['pid']) {
                $topOrganization[] = $item;
            }
        }

        $tree = Tree::instance();
        $tree->init($organization);

        $selectParentIds = [];
        if ($select_id) {
            //$selectParentIds = $tree->getParentsIds($select_id, true);
        }
        $orgs = '';
        // 部门菜单
        foreach ($topOrganization as $index => $item) {
            $childList = Tree::instance()->getTreeMenu($item['id'], '<li class="@class" pid="@pid"><a href="@url" addtabs="@id" url="@url"><i class="@icon"></i> <span>@title</span> <span class="fa arrow"></span></a> @childlist</li>', $select_id, '', 'ul', 'class="nav nav-second-level "');

            $current = in_array($item['id'], $selectParentIds);
            $childList = str_replace('" pid="' . $item['id'] . '"', ' treeview ' . ($current ? 'active' : '') . '" pid="' . $item['id'] . '"', $childList);

            // 生成下拉
            $navchildlistul = !empty($childList) ? '<ul class="nav nav-second-level">' . $childList . '</ul>' : '';

            $nstr = '<li class="dropdown @current"><a href="@url" addtabs="@addtabs" url="@url"> <i class="@icon"></i> <span>@title</span> <span class="fa arrow"></span> <span class="pull-right-container"> </span></a> @navchildlistul</li>';
            $orgs .= strtr($nstr, [
                '@current' => ($current ? 'active' : ''),
                '@url' => $item['url'],
                '@addtabs' => $item['id'],
                '@icon' => $item['icon'],
                '@title' => $item['title'],
                '@navchildlistul' => $navchildlistul,
            ]);
        }

        return $orgs;
    }

    /**
     * @desc  成员列表
     * @param $params 参数数组
     * @return array
     * @author 杨能文
     * @date 2019/4/10 14:59
     * @access public
     */
    public function list($params):array
    {
        //每页显示的数量
        $page_size = !empty($params['ps']) ? $params['ps'] : 20;
        //当前页
        $current_page = (!empty($params['page']) && intval($params['page']) > 0) ? $params['page'] : 1;
        //分页起始值
        $start = $page_size * ($current_page - 1);

        $organizationUser = $this->organizationUser;

        $where = [];
        if ($params['org_id']) $where['org_id'] = $params['org_id'];
        if (is_numeric($params['status'])) $where['status'] = $params['status'];
        if ($params['binding'] == '0') $where['binding'] = $params['binding'];
        if ($params['binding'] == '1') $where['binding'] = ['gt', 0];
        $user_name = preg_split('/[\s,，]+/', trim($params['user_name']));
        if ($user_name[0]) {
            if (count($user_name) > 1) {
                $where['user_name'] = ['in', $user_name];
            } else {
                $where['user_name'] = ['like', "%{$user_name[0]}%"];
            }
        }
        if($params['account']){
            $accountModel = $this->organizationAccount;
            $accountArr = preg_split('/[,，]+/', trim($params['account']));
            $userIdArr  = $accountModel->where(['status'=>1, 'platform_account'=>['in',$accountArr] ])->column('user_id');
            if($userIdArr){
                $where['user_id'] = ['in',$userIdArr];
            }else{
                $where['user_id'] = 0;
            }
        }

        //分页url参数
        $config = [
            'query' => request()->param(),
        ];

        $userInfo = $organizationUser
            ->where($where)
            ->limit($start, $page_size)
            ->paginate($page_size, false, $config);

        $page = $userInfo->render();
        $return_data = [
            'list' => $userInfo->toArray(),
            'page' => $page,
        ];

        if ($return_data['list']['data']) {
            $departmentService = $this->departmentService;
            $orgArr = [];
            foreach ($return_data['list']['data'] as &$val) {
                $key = $val['org_id'];
                $orgArr[$key] = isset($orgArr[$key]) ? $orgArr[$key] : $departmentService->getParentName($key);
                $val['title'] = $orgArr[$key] && isset($orgArr[$key]) ? implode(' / ',$orgArr[$key]) : '';
            }
        }

        return $return_data;
    }

    /**
     * 修改用户的组织架构
     * @param $user_id 用户ID
     * @param int $old_org_id 原部门ID
     * @param $new_org_id 新部门ID
     * @return bool
     */
    public function update($user_id, $old_org_id = 0, $new_org_id)
    {
        // 当原部门ID和当前部门ID一样时
        if ($old_org_id == $new_org_id) {
            $orgUserData = \app\common\model\OrganizationUser::get(['org_id' => $old_org_id, 'user_id' => $user_id]);
            if (empty($orgUserData)) {
                $this->add(['user_id' => [$user_id], 'org_id' => $new_org_id]);
                return true;
            } else {
                return true;
            }
        }
        $orgData = \app\common\model\Organization::get(['id' => $new_org_id]);
        if (empty($orgData)) {
            return false;
        }
        // 如果是新增用户, 没有原部门的时候, 直接插入到新部门
        if ($old_org_id == 0 && $new_org_id > 0) {
            $this->add(['user_id' => [$user_id], 'org_id' => $new_org_id]);
            return true;
        }
        // 禁用原部门,加入到新部门
        $oldOrgData = \app\common\model\OrganizationUser::get(['org_id' => $old_org_id, 'user_id' => $user_id]);
        if (!empty($oldOrgData)) {
            $this->forbid(['id' => $oldOrgData->id]);
        }

        $this->add(['user_id' => [$user_id], 'org_id' => $new_org_id]);
        return true;
    }

    /**
     * @desc 新增成员
     * @param $post 表格提交数据
     * @return bool
     * @author 杨能文
     * @date 2019/4/10 14:27
     * @access public
     */
    public function add($post):bool
    {
        $userIdArr = $post['user_id'] ?? [];
        $org_id = $post['org_id'] ?? 0;
        if(!$userIdArr || !$org_id){
            $this->setErrors(0, __('参数错误'));
            return false;
        }

        $res = $this->checkuser($userIdArr, $org_id);
        if ($res) {
            $this->setErrors(0, __("成员:【".implode(',',$res)."】已在当前部门存在."));
            return false;
        }

        $time = time();
        $auth = \app\common\library\auth\Token::instance();
        $service = $this->departmentService;
        $addData = [];
        foreach($userIdArr as $value){
            $arr = [
                'user_id' => $value,
                'org_id' => $org_id,
                'status' => 1,
                'createtime' => $time,
                'updatetime' => $time,
                'createuser' => $auth->username,
            ];
            $arr['user_name'] = $service->getuser($value);
            array_push($addData,$arr);
        }

        $organizationUser = $this->organizationUser;
        try {
            // 插入
            $organizationUser->insertAll($addData);
            foreach($addData as $value){
                $user_id = $value['user_id'];
                $this->updateUserOrg($user_id,$org_id);
            }
            $this->updateunder($org_id);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('新增成员失败'));
            return false;
        }
    }

    /**
     * @desc 编辑成员
     * @param $post 表格提交数据
     * @return bool
     * @author 杨能文
     * @date 2019/4/10 14:27
     * @access public
     */
    public function edit($post):bool
    {
        $saveData = [
            'org_id' => (int)($post['org_id'] ?? 0),
            'updatetime' => time(),
        ];
        if (isset($post['status'])) $saveData['status'] = (int)$post['status'];

        $organizationUser = $this->organizationUser;
        try {
            //更新
            $organizationUser->update($saveData, ['id' => $post['id']]);
            $this->updateOrgTime($saveData['org_id']);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('编辑成员失败'));

            return false;
        }
    }

    /**
     * @desc 禁用成员
     * @param $post
     * @return bool
     * @author 杨能文
     * @date 2019/4/11 14:59
     * @access public
     */
    public function forbid($post):bool
    {
        if (isset($post['status'])) $saveData['status'] = (int)$post['status'];

        $organizationUser = $this->organizationUser;

        $userArr = $organizationUser->where(['id' => ['in', $post['id']], 'status' => 1])->field('org_id,user_id,user_name,id')->select();
        $userArr = is_object($userArr) ? collection($userArr)->toArray() : [];
        if (!$userArr) {
            $this->setErrors(0, __('成员已禁用、请勿重复操作'));
            return false;
        }
        $orgId  = array_unique(array_column($userArr,'org_id'));

        $bindName = [];
        $idArr = [];
        foreach($userArr as $value){
            $res = $this->checkaccount($value['org_id'],$value['user_id']);
            if($res){
                array_push($bindName,$value['user_name']);
            }else{
                array_push($idArr,$value['id']);
            }
        }

        if(!$idArr){
            $this->setErrors(0, __('成员【'.implode(',',$bindName)).'】已绑定账号,无法禁用');
            return false;
        }

        try {
            //更新
            $res = $organizationUser->update(['status' => 0], ['id' => ['in', $idArr]]);
            if ($res && $orgId){
                foreach($orgId as $value){
                    $this->updateunder($value);
                }
            }

            if($bindName && $idArr){
                $this->setErrors(0, __('成员【'.implode(',',$bindName)).'】已绑定账号,无法禁用、禁用成功条数为'.count($idArr));
                return false;
            }else{
                return true;
            }
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('禁用成员失败'));

            return false;
        }
    }


    /**
     * @desc 复制成员
     * @param $post 表格提交数据
     * @return bool
     * @author 杨能文
     * @date 2019/4/10 14:27
     * @access public
     */
    public function copy($post):bool
    {
        $time = time();
        $auth = \app\common\library\auth\Token::instance();
        $addData = [
            'user_id' => (int)($post['user_id'] ?? 0),
            'org_id' => (int)($post['org_id'] ?? 0),
            'status' => 1,
            'createtime' => $time,
            'updatetime' => $time,
            'createuser' => $auth->username,
        ];

        $res = $this->checkuser($addData['user_id'], $addData['org_id']);
        if ($res) {
            $this->setErrors(0, __('成员已存在当前部门'));

            return false;
        }

        $service = $this->departmentService;
        $organizationUser = $this->organizationUser;
        $addData['user_name'] = $service->getuser($addData['user_id']);
        try {
            // 插入
            $organizationUser->insert($addData, false, true);
            $this->updateunder($addData['org_id']);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('复制成员失败'));
            return false;
        }
    }

    /**
     * @desc 检查成员是否存在部门
     * @param mixed $user_id 用户id
     * @param int $org_id 部门id
     * @param int $id 成员id
     * @return mixed
     * @author 杨能文
     * @date 2019/4/10 14:45
     * @access public
     */
    public function checkuser($user_id, $org_id, $id = 0)
    {
        if (!$user_id || !$org_id) return '';
        $model = $this->organizationUser;
        if ($id > 0) $map['id'] = ['neq', $id];
        if(is_array($user_id)){
            $map = ['user_id' => ['in',$user_id], 'org_id' => $org_id, 'status' => 1];
            $userName = $model->where($map)->column('user_name');
        }else{
            $map = ['user_id' => $user_id, 'org_id' => $org_id, 'status' => 1];
            $userName = $model->where($map)->value('user_name');
        }
        return $userName;
    }


    /**
     * @desc 获取成员信息
     * @param $id 成员id
     * @return array
     * @author 杨能文
     * @date 2019/4/10 17:40
     * @access public
     */
    public function getinfo($id):array
    {
        if (!$id) return [];
        $model = $this->organizationUser;
        $data = $model->where(['id' => $id])->find()->toArray();

        return $data;
    }

    /**
     * @desc 更新相关部门下级用户数
     * @param $org_id
     * @return bool
     * @author 杨能文
     * @date 2019/4/11 9:58
     * @access public
     */
    public function updateunder($org_id):bool
    {
        if (!$org_id) return false;
        $organization = $this->organization;
        $organizationUser = $this->organizationUser;

        //获取所有相关部门信息
        $tid = $organization->where(['id' => $org_id])->value('tid');
        if (!$tid) return false;
        $obj = $organization->where(['tid' => $tid])->field('id,pid,rank,title')->order('rank desc')->select();
        $organizationArr = collection($obj)->toArray();
        if (!$organizationArr) return false;

        //分组统计用户数据
        $obj = $organizationUser->field('org_id,count(id) as num')->where(['org_id' => ['in', array_column($organizationArr, 'id')], 'status' => 1])->group('org_id')->select();
        $userArr = collection($obj)->toArray();

        //键值数组
        $keyArr = array_column($userArr,'num','org_id');

        //将查询的下级用户数写入数组
        foreach ($organizationArr as &$val) {
            $key = $val['id'];
            $val['num'] = isset($keyArr[$key]) ? $keyArr[$key] : 0;
        }

        //为父级部门统计下级用户数
        $data = $this->parentunder($organizationArr, $organizationArr[0]['rank']);
        $saveData = [];
        $time = time();
        foreach ($data as $val) {
            $arr = ['id' => $val['id'], 'under' => $val['num'], 'updatetime' => $time];
            array_push($saveData,$arr);
        }
        $organization->saveAll($saveData);
        return true;
    }

    /**
     * @desc 为父级部门统计下级用户数
     * @param $array
     * @param $rank
     * @return array
     * @author 杨能文
     * @date 2019/4/11 14:19
     * @access public
     */
    public function parentunder($array, $rank):array
    {
        static $list = [];
        foreach ($array as $key => $value) {
            if ($value['rank'] == $rank) {
                $list[$value['id']] = [
                    'id' => $value['id'], 'pid' => $value['pid'], 'rank' => $value['rank'], 'title' => $value['title'],
                    'num' => isset($list[$value['id']]['num']) ? $list[$value['id']]['num'] : $value['num'],
                ];
                if ($value['pid']) $list[$value['pid']]['num'] = isset($list[$value['pid']]['num']) ? $list[$value['pid']]['num'] + $list[$value['id']]['num'] : $list[$value['id']]['num'];
                unset($array[$key]);
            }
        }
        if ($array) $this->parentunder($array, $rank - 1);

        return $list;
    }

    /**
     * @desc 根据部门与用户id获取绑定账号
     * @param $org_id 部门id
     * @param $user_id 用户id
     * @return array
     * @author 杨能文
     * @date 2019/4/17 10:40
     * @access public
     */
    public function useraccount($org_id, $user_id):array
    {
        if (!is_numeric($org_id) || !is_numeric($user_id)) return [];
        $model = $this->organizationAccount;
        $data = $model->where(['org_id' => $org_id, 'user_id' => $user_id, 'status'=>1])->order('platform asc')->select();
        $data = is_object($data) ? collection($data)->toArray() : [];
        $store = $this->getAllStore();
        foreach($data as &$value){
            $key = $value['store_id'];
            $value['warehouse'] = isset($store[$key]) ? $store[$key] : '';
        }
        return $data;
    }

    /**
     * @desc 根据帐号id获取帐号信息
     * @author 杨能文
     * @date 2019/4/26 10:27
     * @access public
     * @param $accountId 帐号id
     * @return array
     */
    public function getAccountById($accountId):array
    {
        if(!is_numeric($accountId))return [];
        $model = $this->organizationAccount;
        $data = $model->where('id',$accountId)->find()->toArray();
        if($data){
            $data['locations_arr']  = explode('*',$data['locations']);
            $data['sales_label_arr']= explode(',',$data['sales_label']);
        }
        return $data;
    }

    /**
     * @desc 检测是否绑定账号
     * @param $org_id 部门id
     * @param $user_id 用户id
     * @return bool
     * @author 杨能文
     * @date 2019/4/17 18:18
     * @access public
     */
    public function checkaccount($org_id,$user_id):bool
    {
        if(!is_numeric($org_id) || !is_numeric($user_id))return false;
        $model = $this->organizationAccount;
        $id = $model->where(['org_id'=>$org_id, 'user_id'=>$user_id, 'status'=>1])->value('id');
        return $id ? true : false;
    }


    /**
     * @desc 获取所有仓库
     * @author 杨能文
     * @date 2019/4/25 10:41
     * @access public
     * @return array
     */
    public function getAllStore():array
    {
        $redis = $this->redis;
        $key   = Config::get('redis.all_erp_store_kv');
        $data  =  $redis->handler()->get($key);
        if($data)$data = json_decode($data,true);
        if($data == false || $data == null){
            $model = $this->ebayStore;
            $data  = $model->column('id,store_name');
            $redis->handler()->set($key,json_encode($data),3600);
        }
        return $data;
    }

    /**
     * @desc 获取所有的发货地
     * @author 杨能文
     * @date 2019/4/25 11:45
     * @access public
     * @return array
     */
    public function getAllLocation():array
    {
        $cache = $this->redis;
        $key = Config::get('redis.all_erp_location');
        $return = $cache->handler()->get($key);
        $return = json_decode($return,true);
        if(empty($return)){
            $model = $this->ebayStore;
            $location = $model->where(['store_name'=>['notlike',['%备货仓%','%FBA%'],'and'] ])->column('location');
            $location = array_map('unserialize',$location);
            $return  = array();
            foreach ($location as $v){
                if($v)$return = array_merge($return,$v);
            }
            $data = array_unique($return);
            $return = array();
            foreach($data as $k=>$v){
                if(empty($v)){
                    unset($data[$k]);
                }else{
                    $return[$k] = $v;
                }
            }
            $cache->handler()->set($key,json_encode($return),3600);
        }
        return $return;
    }

    /**
     * @desc 获取帐号
     * @author 杨能文
     * @date 2019/4/25 13:51
     * @access public
     * @return array
     */
    public function getPlatformAccount():array
    {
        $redis = $this->redis;
        $key = Config::get('redis.all_erp_platform_account');
        $return = $redis->handler()->get($key);
        $return = json_decode($return,true);
        if(empty($return)){
            $model = $this->ebayAccount;
            $data  = $model->where(['status'=>1])->field('platform,ebay_account,id')->select()->toArray();
            $return = [];
            foreach($data as $value){
                $key = $value['platform'];
                $k1  = $value['id'];
                $return[$key][$k1] = $value['ebay_account'];
            }
            $redis->handler()->set($key,json_encode($return),3600);
        }
        return $return;
    }

    /**
     * @desc 获取帐号
     * @author 杨能文
     * @date 2019/4/25 18:48
     * @access public
     * @param string $platform 平台
     * @return array
     */
    public function getAccount($platform = ''):array
    {
        $return = [];
        $data = $this->getPlatformAccount();
        if(!$data)return $return;
        foreach($data as $key=>$val){
            if($platform && $key != $platform)continue;
            $return = array_merge($return,$val);
        }
        return $return;
    }

    /**
     * @desc 新增帐号
     * @author 杨能文
     * @date 2019/4/26 17:11
     * @access public
     * @param $post
     * @return bool
     */
    public function addAccount($post):bool
    {
        $platform           = $post['platform'] ?? '';
        $platform_account   = isset($post['platform_account']) ? preg_split('/[\n,，]+/', trim($post['platform_account'])) : [];
        $user_id            = $post['user_id'] ?? 0;
        $org_id             = $post['org_id'] ?? 0;
        $store_id           = $post['store_id'] ?? 0;
        $locations          = isset($post['locations']) ? implode('*',$post['locations']) : '';
        $sales_label        = isset($post['sales_label']) ? implode(',',$post['sales_label']) : '';

        if(!$platform){
            $this->setErrors(0,__('平台不能为空'));
            return false;
        }

        if(!$post['platform_account']){
            $this->setErrors(0,__('帐号不能为空'));
            return false;
        }

        if(!$user_id || !$org_id){
            $this->setErrors(0,__('参数错误'));
            return false;
        }

        //获取用户名
        $service = $this->departmentService;
        $userName = $service->getuser($user_id);
        if(!$userName){
            $this->setErrors(0,__('当前用户已被禁用或不存在'));
            return false;
        }

        if($platform == 'ebay' && ($locations || $sales_label || $store_id) && (!$locations || !$sales_label || !$store_id)){
            $this->setErrors(0,__('ebay平台仅支持帐号单独绑定与全信息绑定'));
            return false;
        }

        //批量检查帐号是否绑定
        if($platform != 'ebay' || ($platform == 'ebay' && !$locations && !$sales_label && !$store_id) ){
            $accountArr = $this->getBindAccountName($platform_account, 0, $platform);
            if($accountArr){
                $string = "账号【".implode(',',$accountArr)."】已绑定";
                $this->setErrors(0,__($string));
                return false;
            }
        }

        //获取帐号ID
        $accountIdArr = $this->getAccountIdByName($platform_account,$platform);

        $addData = [];
        $time = time();
        $notAccountArr = [];
        foreach($platform_account as $val){
            if(!$val)continue;
            $accountId = array_search($val,$accountIdArr);
            if(!$accountId){
                array_push($notAccountArr,$val);
                continue;
            }
            $arr = [
                'org_id'            => $org_id,
                'user_id'           => $user_id,
                'user_name'         => $userName,
                'platform'          => $platform,
                'platform_account'  => $val,
                'platform_account_id'=> $accountId,
                'store_id'          => $store_id,
                'locations'         => $locations,
                'sales_label'       => $sales_label,
                'status'            => 1,
                'createtime'        => $time,
                'updatetime'        => $time,
            ];
            array_push($addData,$arr);
        }

        if($notAccountArr){
            $string = "帐号【".implode(',',$notAccountArr)."】未找到或已禁用";
            $this->setErrors(0,__($string));
            return false;
        }

        $model = $this->organizationAccount;
        try {
            $model->insertAll($addData);
            $this->updateBind($org_id,$user_id);
            $this->updateOrgTime($org_id);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('新增帐号失败'));
            return false;
        }
    }

    /**
     * @desc 编辑帐号
     * @author 杨能文
     * @date 2019/4/26 14:50
     * @access public
     * @param $post
     * @return bool
     */
    public function editAccount($post):bool
    {
        $platform         = $post['platform'] ?? '';
        $platform_account = $post['platform_account'] ?? '';
        $locations        = isset($post['locations']) ? implode('*',$post['locations']) : '';
        $sales_label      = isset($post['sales_label']) ? implode(',',$post['sales_label']) : '';

        if(!$platform){
            $this->setErrors(0,__('平台不能为空'));
            return false;
        }

        if(!$platform_account){
            $this->setErrors(0,__('帐号不能为空'));
            return false;
        }

        if($platform == 'ebay' && ($locations || $sales_label || $post['store_id']) && (!$locations || !$sales_label || !$post['store_id'])){
            $this->setErrors(0,__('ebay平台仅支持帐号单独绑定与全信息绑定'));
            return false;
        }

        //如果不是ebay平台、进行帐号重复性检测
        if($platform != 'ebay' || ($platform == 'ebay' && !$locations && !$sales_label && !$post['store_id']) ){
            $account = $this->getBindAccountName($platform_account, $post['id'], $platform);
            if($account){
                $this->setErrors(0,__("帐号【{$account}】已绑定"));
                return false;
            }
        }

        $saveData = [
            'platform'          => $platform,
            'platform_account'  => $platform_account,
            'platform_account_id'=> 0,
            'locations'         => $locations,
            'store_id'          => $post['store_id'] ?? 0,
            'sales_label'       => $sales_label,
            'updatetime'        => time(),
        ];
        $saveData['platform_account_id'] = $this->getAccountIdByName($saveData['platform_account']);
        if(!$saveData['platform_account_id']){
            $this->setErrors(0,__('系统已不存在此帐号'));
            return false;
        }

        $model = $this->organizationAccount;
        $org_id = $model->where(['id' => $post['id']])->value('org_id');
        try {
            $model->update($saveData, ['id' => $post['id']]);
            $this->updateOrgTime($org_id);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('编辑成员失败'));
            return false;
        }
    }

    /**
     * @desc 根据帐号名称获取帐号id
     * @author 杨能文
     * @date 2019/4/26 15:00
     * @access public
     * @param mixed $account 帐号
     * @param string $platform 平台
     * @return mixed
     */
    public function getAccountIdByName($account, $platform = '')
    {
        if(!$account)return 0;
        $model = $this->ebayAccount;
        if($platform)$map['platform'] = $platform;
        if(is_array($account)){
            $map['ebay_account'] = ['in',$account];
            $accountId = $model->where($map)->column('id,ebay_account');
        }else{
            $map['ebay_account'] = $account;
            $accountId = $model->where($map)->value('id');
        }
        return $accountId;
    }

    /**
     * @desc 移除账号
     * @author 杨能文
     * @date 2019/4/26 16:13
     * @access public
     * @param $post
     * @return bool
     */
    public function moveAccount($post):bool
    {
        $org_id  = $post['org_id'] ?? 0;
        $user_id = $post['user_id'] ?? 0;
        $id      = $post['id'] ?? 0;
        if($id && ($org_id && $user_id)){
            $this->setErrors(0,__('参数错误'));
            return false;
        }

        $model = $this->organizationAccount;
        $saveData = [ 'status'=> 0];
        try {
            //单个移除
            if($id)$model->update($saveData, ['id' => $id]);
            //一键移除
            if($org_id && $user_id)$model->update($saveData, ['org_id' => $org_id, 'user_id'=>$user_id]);
            //为了更新绑定信息、必须去获取
            if(!$org_id || !$user_id){
                $info = $model->where(['id' => $id])->find()->toArray();
                $org_id  = $info['org_id'];
                $user_id = $info['user_id'];
            }
            $this->updateBind($org_id,$user_id);
            $this->updateOrgTime($org_id);
            return true;
        } catch (\Exception $e) {
            $this->setErrors(0, Config::get('app_debug') ? $e->getMessage() : __('移除帐号失败'));
            return false;
        }
    }

    /**
     * @desc 获取用户所在部门绑定帐号(启用)
     * @param mixed $account 帐号
     * @param int $id
     * @param string $platform 平台
     * @return mixed
     * @author 杨能文
     * @date 2019/4/17 18:18
     * @access public
     */
    public function getBindAccountName($account, $id=0, $platform = '')
    {
        if(!$account)return [];
        $model = $this->organizationAccount;
        $map = ['status'=>1];
        if($id>0)$map['id'] = ['neq',$id];
        if($platform == 'ebay'){
            $map['store_id']    = 0;
            $map['locations']   = '';
            $map['sales_label'] = '';
        }
        if(is_array($account)){
            $map['platform_account'] = ['in',$account];
            $platform_account = $model->where($map)->column('platform_account');
            $platform_account = array_unique($platform_account);
        }else{
            $map['platform_account'] = $account;
            $platform_account = $model->where($map)->value('platform_account');
        }
        return $platform_account;
    }

    /**
     * @desc 更新用户绑定信息
     * @author 杨能文
     * @date 2019/4/27 9:38
     * @access public
     * @param $org_id
     * @param $user_id
     */
    public function updateBind($org_id,$user_id){
        $model          = $this->organizationUser;
        $accountModel   = $this->organizationAccount;

        //检查是否还有绑定帐号
        $map = ['status'=>1, 'org_id'=>$org_id, 'user_id'=>$user_id];
        $accountId = $accountModel->where($map)->value('id');
        if($accountId > 0){
            $model->update(['binding'=>1],$map);
        }else{
            $model->update(['binding'=>0],$map);
        }
    }

    /**
     * @desc 获取所有被绑定的帐号(不包含ebay帐号)
     * @param string $account 排除的帐号
     * @author 杨能文
     * @date 2019/4/27 11:05
     * @access public
     * @return array
     */
    public function getAllBindAccount($account = ''):array
    {
        $model = $this->organizationAccount;
        $map = ['status'=>1, 'platform'=>['neq','ebay']];
        if($account)$map['platform_account'] = ['neq',$account];
        $accountArr = $model->where($map)->column('platform_account');
        return $accountArr;
    }

    /**
     * @desc 更新部门时间(对部门成员进行增、删、改,也行更新部门时间)
     * @author 杨能文
     * @date 2019/4/30 11:32
     * @access public
     * @param $org_id
     * @return bool
     */
    public function updateOrgTime($org_id = 0):bool
    {
        if($org_id)return false;
        $model = $this->organization;
        $res = $model->update(['updatetime'=>time()],['id'=>$org_id]);
        return $res ? true : false;
    }

    /**
     * @desc 更新用户所属部门(将成员新增的部门)
     * @author 杨能文
     * @date 2019/4/30 16:28
     * @access public
     * @param int $user_id 用户id
     * @param int $org_id 部门id
     * @return bool
     */
    public function updateUserOrg($user_id = 0, $org_id = 0):bool
    {
        if(!is_numeric($user_id) || !is_numeric($org_id))return false;
        $model = $this->users;
        $red = $model->update(['id'=>$user_id],['org_id'=>$org_id]);
        return $red ? true : false;
    }
}
<?php if (!defined('THINK_PATH')) exit(); /*a:10:{s:77:"/opt/web/zs/apps/rbac/public/../application/v1/view/users/index/editrule.html";i:1554790531;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:71:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_edit_job_id.html";i:1555901542;s:73:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_edit_rules_id.html";i:1555901158;s:75:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_edit_allow_bath.html";i:1554790531;s:73:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_edit_rule_all.html";i:1556245828;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
<head>
    <!-- 加载样式及META信息 -->
    <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<link rel="shortcut icon" href="/favicon.ico" />
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 4 -->
<!-- Bootstrap Core CSS -->
<link href="/vendor/bootstrap/css/bootstrap.min.css?v=<?php echo $config['site']['version']; ?>" rel="stylesheet">
<!-- Custom CSS -->
<link href="/dist/css/app.min.css?v=<?php echo $config['site']['version']; ?>" rel="stylesheet">
<!-- Custom CSS -->
<link href="/dist/css/extend.min.css?v=<?php echo $config['site']['version']; ?>" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
</head>
<body class="skin-blue adaptive">
    <div>
        
<div class="dialog-content">
    <form action="<?php echo url('/v1/users/index/editrule'); ?>" class="form-horizontal dialog-form"
          data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
        <input type="hidden" name="ids" value="<?php echo $ids; ?>"/>
        <?php if($saveType == 'job_id'): ?>
        <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <input type="hidden" name="saveType" value="job_id"/>
            <label for="job_id" class="col-sm-2 control-label"><span class="red-color">*</span>岗位</label>
            <div class="col-sm-5">
                <select class="selectpicker show-tick" title="" id="job_id" name="job_id"
                         data-live-search="true">
                    <option value="">请选择</option>
                    <?php foreach($userJobInfos as $k=>$v): ?>
                    <option value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-5">
                <?php echo build_toolbar('a',
                ['class' => 'btn btn-info btn-sm addobj','data-url' => url('/v1/auth/position/add?dialog=1')],
                '<i class="glyphicon glyphicon-plus"></i> 新增岗位'); ?>
            </div>
        </div>
    </div>
</div>

<div class="td-align dialog-footer">
    <button class="btn btn-warning" id="cancel"> <i class="fa fa-close"></i> 取消</button>
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 确定提交</button>
</div>
        <?php elseif(($saveType == 'rules_id')): ?>
        <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <input type="hidden" name="saveType" value="rules_id"/>
            <label for="rules_id" class="col-sm-2 control-label">权限标签</label>
            <div class="col-sm-5">
                <select multiple="multiple" class="selectpicker show-tick" title="请选择(可多选)" id="rules_id"
                        name="rules_id[]"
                        data-actions-box="true" data-live-search="true">
                    <?php foreach($usersLabel as $kk=>$vv): ?>
                    <option value="<?php echo $kk; ?>"><?php echo $vv; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-5">
                <?php echo build_toolbar('a',
                ['class' => 'btn btn-info addobj','data-url' => url('/v1/auth/tag/add&dialog=1')],
                '<i class="glyphicon glyphicon-plus"></i> 新增权限标签'); ?>
            </div>
        </div>
    </div>
</div>

<div class="td-align dialog-footer">
    <button class="btn btn-warning" id="cancel"> <i class="fa fa-close"></i> 取消</button>
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 确定提交</button>
</div>
        <?php elseif($saveType == 'allow'): ?>
        <div class="row">
    <div class="col-md-12">
        <input type="hidden" name="saveType" value="allow"/>
        <div class="form-group">
            <label for="all" class="col-sm-3 control-label"><span class="red-color">*</span>允许登录的系统：</label>
            <div class="col-sm-9">
                <div class="checkbox">
                    <label>
                        <input class="data-check_box_total allow" type="checkbox" id="all"> 全部
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
                <div class="checkbox child">
                    <?php foreach($allowSystem as $k2=>$v2): ?>
                    <label><input type="checkbox" class="data-check_box" name="allow[]" value="<?php echo $v2; ?>"><?php echo $v2; ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="td-align dialog-footer">
    <button class="btn btn-warning" id="cancel"> <i class="fa fa-close"></i> 取消</button>
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 确定提交</button>
</div>
        <?php elseif($saveType == 'all'): ?>
        <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="org_id" class="col-sm-3 control-label"><span class="red-color">*</span>部门：</label>
            <div class="col-sm-5">
                <select class="selectpicker show-tick" title="请选择部门" id="org_id" name="org_id"
                        data-live-search="true">
                    <option value="">请选择部门</option>
                    <?php foreach($orgInfo as $orgid=>$orgList): ?>
                    <option value="<?php echo $orgList['id']; ?>" <?php if($userInfo['org_id'] == $orgList['id']): ?>selected<?php endif; if(($orgList['rid']-$orgList['lid'] !=1)): ?>disabled="disabled"<?php endif; ?>><?php echo $orgList['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="job_type" class="col-sm-3 control-label">角色：</label>
            <div class="col-sm-9">
                <select class="selectpicker show-tick" title="请选择角色" id="job_type" name="job_type"
                        data-rule="required;job_type;"
                        data-msg-required="请选择角色">
                    <?php foreach($userJobInfo as $ruleId=>$ruleName): ?>
                    <option value="<?php echo $ruleId; ?>" <?php if($userInfo['job_type'] == $ruleId): ?>selected<?php endif; ?>><?php echo $ruleName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="job_id" class="col-sm-3 control-label"><span class="red-color">*</span>岗位：</label>
            <div class="col-sm-5">
                <input type="hidden" name="saveType" value="all"/>
                <select class="selectpicker show-tick" title="请选择" id="job_id" name="job_id"
                         data-live-search="true">
                    <?php foreach($userJobInfos as $k4=>$v4): ?>
                    <option value="<?php echo $v4['id']; ?>" <?php if($v4['id'] == $userInfo['job_id']): ?>selected<?php endif; ?>><?php echo $v4['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-3">
                <?php echo build_toolbar('a',
                ['class' => 'btn btn-info btn-sm addobj','data-url' => url('/v1/auth/position/add?dialog=1')],
                '<i class="glyphicon glyphicon-plus"></i> 新增岗位'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="rules_id" class="col-sm-3 control-label">权限标签：</label>
            <div class="col-sm-5">
                <select multiple="multiple" class="selectpicker show-tick" title="请选择(可多选)" id="rules_id" name="rules_id[]"
                        data-actions-box="true" data-live-search="true">
                    <?php foreach($usersLabel as $kk=>$vv): ?>
                    <option value="<?php echo $kk; ?>" <?php if(in_array($kk,$userInfo['rules_id'])): ?>selected<?php endif; ?>><?php echo $vv; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-3">
                <?php echo build_toolbar('a',
                ['class' => 'btn btn-info btn-sm addobj','data-url' => url('/v1/auth/tag/add&dialog=1')],
                '<i class="glyphicon glyphicon-plus"></i> 新增权限标签'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">密码：</label>

            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm input-width-218px" id="password" name="password" value='<?php if(empty($userInfo['password'])): ?>888888<?php endif; ?>'
                       placeholder="填写了密码就修改">
            </div>
            <div class="col-sm-3">

            </div>
        </div>

        <?php if($userInfo['status_value'] == 1): ?>
        <div class="form-group">
            <label for="maturitytime" class="col-sm-3 control-label">授权过期时间：</label>
            <div class="col-sm-5">
                <input class="form-control input-width-218px" name="maturitytime" value="<?php echo date('Y-m-d H:i:s',$userInfo['maturitytime']); ?>" type="text" readonly <?php if($userInfo['time_type'] == 1): ?>id="maturitytime"<?php endif; ?>/>
            </div>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="all" class="col-sm-3 control-label">允许登录的系统：</label>
            <div class="col-sm-9">
                <div class="checkbox">
                    <label>
                        <input class="data-check_box_total allow" type="checkbox" id="all"> 全部
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
                <div class="checkbox child">
                    <?php foreach($allowSystem as $k2=>$v2): ?>
                    <label>
                        <input type="checkbox" class="data-check_box" name="allow[]" value="<?php echo $v2; ?>" <?php if(in_array($v2,$userInfo['allow'])): ?>checked<?php endif; ?>><?php echo $v2; ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php if((!empty($userInfo['status_value'])) AND ($userInfo['status_value'] == 2)): ?>
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label">是否转入已入职：</label>
            <div class="col-sm-5">
                <select class="selectpicker show-tick" title="" id="status" name="status">
                    <option value="1">已入职</option>
                </select>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="td-align dialog-footer">
    <button class="btn btn-warning" id="cancel"> <i class="fa fa-close"></i> 取消</button>
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 确定提交</button>
</div>

        <?php else: endif; ?>
    </form>
</div>

    </div>
    <!-- 加载JS脚本 -->
    <script id="test" type="text/html">
    <h1>{{title}}</h1>1wwerewrewr
</script>
    <!-- jQuery 3 -->
<script src="/vendor/jquery/jquery.min.js?v=<?php echo $config['site']['version']; ?>"></script>
    <!-- 自定义js -->
    <!-- 自定义js模板 -->
    <!-- require -->
<script src="/dist/js/require.js?v=<?php echo $config['site']['version']; ?>" data-main="/dist/js/require-main.js?v=<?php echo $config['site']['version']; ?>"></script>
</body>
</html>
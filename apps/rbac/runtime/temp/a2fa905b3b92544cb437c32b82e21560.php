<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:73:"/opt/web/zs/apps/rbac/public/../application/v1/view/users/index/edit.html";i:1556241189;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <form action="<?php echo url('/v1/users/index/edit',array('id'=>$userInfo['id'],'addType'=>'edit')); ?>" class="form-horizontal dialog-form" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label"><span class="red-color">*</span>真实姓名：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="username" name="username" value="<?php echo $userInfo['username']; ?>"
                               data-rule="required;username;"
                               data-msg-required="请填写用户名"
                               data-tip="你可以用汉字、字母、数字">
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_id" class="col-sm-3 control-label"><span class="red-color">*</span>公司：</label>
                    <div class="col-sm-9">
                        <select class="form-control" title="" id="company_id" name="company_id"
                                data-rule="required;company_id;"
                                data-msg-required="请选择公司">
                            <?php foreach($company as $company=>$company_name): ?>
                            <option value="<?php echo $company; ?>" <?php if($userInfo['company_id'] == $company): ?>selected<?php endif; ?>><?php echo $company_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="org_id" class="col-sm-3 control-label"><span class="red-color">*</span>部门：</label>
                    <div class="col-sm-9">
                        <select class="selectpicker show-tick form-control" title="请选择部门" id="org_id" name="org_id"
                                data-live-search="true">
                            <option value="">请选择部门</option>
                            <?php foreach($orgInfo as $orgid=>$orgList): ?>
                            <option value="<?php echo $orgList['id']; ?>" <?php if($userInfo['org_id'] == $orgList['id']): ?>selected<?php endif; if(($orgList['rid']-$orgList['lid'] !=1)): ?>disabled="disabled"<?php endif; ?>><?php echo $orgList['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">职位：</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="position" name="position" value="<?php echo $userInfo['position']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="job_type" class="col-sm-3 control-label">角色：</label>
                    <div class="col-sm-9">
                        <select class="form-control" title="请选择角色" id="job_type" name="job_type"
                                data-rule="required;job_type;"
                                data-msg-required="请选择角色">
                            <?php foreach($userJobInfo as $ruleId=>$ruleName): ?>
                            <option value="<?php echo $ruleId; ?>" <?php if($userInfo['job_type'] == $ruleId): ?>selected<?php endif; ?>><?php echo $ruleName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">邮箱：</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $userInfo['email']; ?>" placeholder="邮箱" data-rule="email">
                    </div>
                </div>
                <?php if($userInfo['status'] != 1): ?>
                <div class="form-group">
                    <label for="preentrytime" class="col-sm-3 control-label">预计入职时间：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="preentrytime" name="preentrytime" value="<?php echo $userInfo['preentrytime']; ?>" readonly placeholder="预计入职时间">
                    </div>
                </div>
                <div class="form-group">
                    <label for="proceduretime" class="col-sm-3 control-label">手续时间：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="proceduretime" name="proceduretime" value="<?php echo $userInfo['proceduretime']; ?>" readonly placeholder="手续时间">
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="mobile" class="col-sm-3 control-label">手机号：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $userInfo['mobile']; ?>" placeholder="手机号" data-rule="mobile">
                    </div>
                </div>

                <div class="form-group">
                    <label for="room" class="col-sm-3 control-label">住宿安排：</label>
                    <div class="col-sm-9">
                        <select class="form-control" title="" id="room" name="room">
                            <?php foreach($rooms as $roomId=>$roomName): ?>
                            <option value="<?php echo $roomId; ?>" <?php if($userInfo['room'] == $roomId): ?>selected<?php endif; ?>><?php echo $roomName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pact_type" class="col-sm-3 control-label">协议类型：</label>
                    <div class="col-sm-9">
                        <select class="form-control" title="" id="pact_type" name="pact_type">
                            <?php foreach($pact_types as $typeId=>$typeName): ?>
                            <option value="<?php echo $typeId; ?>" <?php if($userInfo['pact_type'] == $typeId): ?>selected<?php endif; ?>><?php echo $typeName; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ready_computer" class="col-sm-3 control-label">提前准备电脑：</label>
                    <div class="col-sm-9">
                        <select class="form-control" title="" id="ready_computer" name="ready_computer">
                            <?php foreach($ready_computers as $readyId=>$readyName): ?>
                            <option value="<?php echo $readyId; ?>" <?php if($userInfo['ready_computer'] == $readyId): ?>selected<?php endif; ?>><?php echo $readyName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="td-align dialog-footer">
            <button class="btn btn-warning" id="cancel"> <i class="fa fa-close"></i> 取消</button>
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 确定提交</button>
        </div>
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
<?php if (!defined('THINK_PATH')) exit(); /*a:16:{s:73:"/opt/web/zs/apps/rbac/public/../application/v1/view/users/index/wait.html";i:1555121566;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986348;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1556509685;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891314;s:79:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_finance_wait_search.html";i:1555148828;s:71:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_offersearch.html";i:1555148965;s:67:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_navtabs.html";i:1556599567;s:73:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_adm_wait_bath.html";i:1555559638;s:77:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_finance_wait_bath.html";i:1555582480;s:76:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_adm_wait_tables2.html";i:1555999285;s:78:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_finance_wait_table.html";i:1556246511;s:65:"/opt/web/zs/apps/rbac/application/v1/view/users/index/_table.html";i:1556246511;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <!-- 自定义css -->
</head>
<body class="skin-blue fixed <?php echo $adaptive; ?>">
    <div id="wrapper">
        <!-- Navigation -->
<nav class="navbar navbar-default navbar-top navbar-static-top main-header" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo url('/'); ?>">ZS
            <small>v2.0</small>
        </a>
    </div>
    <a href="#" class="sidebar-toggle <?php if($adaptive): ?>open<?php endif; if(isset($unclickable) && $unclickable): ?>unclickable<?php endif; ?>" data-toggle="offcanvas" role="button">
        <i class="fa fa-bars"></i>
    </a>
    <ul class="nav navbar-top-links navbar-topbar navbar-left" role="tablist">
        <?php echo $navlist; ?>
        <li class="dropdown">
            <a href="<?php echo $config['app']['erpdomain']; ?>&rbac_token=<?php echo $users['token']; ?>" class="dropdown-toggle" data-hover="dropdown"> <i class="fa fa-fw fa-cubes"></i> <span>ERP</span> <span class="pull-right-container"> </span></a>
        </li>
    </ul>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <!--<li class="dropdown">-->
            <!--<a class="dropdown-toggle" data-toggle="dropdown" href="#">-->
                <!--<i class="fa fa-bell fa-fw"></i>-->
                <!--<span class="label label-danger">4</span>-->
            <!--</a>-->
            <!--<ul class="dropdown-menu dropdown-messages notice-ul">-->
                <!--<li>-->
                    <!--<a href="#">-->
                        <!--<div>-->
                            <!--<strong>John Smith</strong>-->
                            <!--<span class="pull-right text-muted">-->
                                    <!--<em>Yesterday</em>-->
                                <!--</span>-->
                        <!--</div>-->
                        <!--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li>-->
                    <!--<a class="text-center" href="#">-->
                        <!--<strong>Read All Messages</strong>-->
                        <!--<i class="fa fa-angle-right"></i>-->
                    <!--</a>-->
                <!--</li>-->
            <!--</ul>-->
            <!--&lt;!&ndash; /.dropdown-messages &ndash;&gt;-->
        <!--</li>-->
        <!-- /.dropdown -->

        <li class="dropdown">

        </li>

        <li class="dropdown user user-menu">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <img src="/dist/img/avatar.png" class="user-image" alt="User Image"> <?php echo $users['username']; ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo url($config['url']['profile']); ?>"><i class="fa fa-user fa-fw"></i> 我的资料</a></li>
                <li><a href="javascrit:void(0);" class="btn-ajax" data-url="<?php echo url($config['url']['cleanup']); ?>"><i class="fa fa-fw fa-refresh"></i> 刷新权限</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo url($config['url']['logout']); ?>"><i class="fa fa-sign-out fa-fw"></i> 退出</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav side-menu" id="side-menu">
                <?php echo $menulist; ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
        <!-- Full Width Column -->
        <div id="page-wrapper">
            <div class="row page-header content-header">
    <h3><?php if(isset($ruletitle)): ?><?php echo $ruletitle; else: ?><?php echo $rule_title; endif; ?></h3>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> <?php echo __('首页'); ?></a></li>
        <li><?php echo $rule_title; ?></li>
        <li class="active"><?php echo $method_title; ?></li>
    </ol>
</div>
            
<div class="content">
    <?php if(($curJobType != 9)): ?>
    <form class="form-inline">
    <div class="panel panel-default panel-btn">
        <div class="panel-heading">
            <div class="form-group">
                <label for="org_id">部门</label>
                <select class="selectpicker show-tick" title="" id="org_id" name="org_id"
                        data-live-search="true">
                    <option value="">全部</option>
                    <?php foreach($orgInfo as $orgid=>$orgList): ?>
                    <option value="<?php echo $orgList['id']; ?>" <?php if($params['org_id'] == $orgList['id']): ?>selected<?php endif; ?>><?php echo $orgList['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="job_id">岗位：</label>
                <select class="selectpicker show-tick" title="" id="job_id" name="job_id"
                        data-actions-box="true" data-live-search="true">
                    <option value="">全部</option>
                    <?php foreach($userJobInfos as $k=>$v): ?>
                    <option value="<?php echo $v['id']; ?>" <?php if($params['job_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo $v['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="searchKey"></label>
                <select class="form-control" title="" id="searchKey" name="searchKey">
                    <?php foreach($searchKey as $keyId=>$keyName): ?>
                    <option value="<?php echo $keyId; ?>" <?php if($params['searchKey'] == $keyId): ?>selected<?php endif; ?>><?php echo $keyName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="searchValue"></label>
                <input type="text" class="form-control" id="searchValue" name="searchValue"
                       placeholder="支持多个搜索(空格或逗号隔开)" value="<?php echo $params['searchValue']; ?>"/>
            </div>



            <div class="form-group">
                <button class="btn btn-primary">搜索</button>
            </div>
        </div>
    </div>
</form>
    <?php else: ?>
    <form class="form-inline">
    <div class="panel panel-default panel-btn">
        <div class="panel-heading">
            <div class="form-group">
                <label for="org_id">部门：</label>
                <select class="selectpicker show-tick" title="全部" id="org_id" name="org_id"
                        data-actions-box="true" data-live-search="true">
                    <option value="">全部</option>
                    <?php foreach($orgInfo as $orgid=>$orgList): ?>
                    <option value="<?php echo $orgList['id']; ?>" <?php if($params['org_id'] == $orgList['id']): ?>selected<?php endif; ?>><?php echo $orgList['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pact_type">协议类型：</label>
                <select class="form-control" title="" id="pact_type" name="pact_type">
                    <?php foreach($pact_type as $pactId=>$pactName): ?>
                    <option value="<?php echo $pactId; ?>" <?php if($params['pact_type'] == $pactId): ?>selected<?php endif; ?>><?php echo $pactName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="room">住宿安排：</label>
                <select class="form-control" title="" id="room" name="room">
                    <?php foreach($room as $roomId=>$roomName): ?>
                    <option value="<?php echo $roomId; ?>" <?php if($params['room'] == $roomId): ?>selected<?php endif; ?>><?php echo $roomName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ready_computer">提前准备电脑：</label>
                <select class="form-control" title="" id="ready_computer" name="ready_computer">
                    <?php foreach($ready_computer as $readyId=>$readyName): ?>
                    <option value="<?php echo $readyId; ?>" <?php if($params['ready_computer'] == $readyId): ?>selected<?php endif; ?>><?php echo $readyName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="timetype"></label>
                <select class="form-control" title="" id="timetype" name="timetype">
                    <?php foreach($timetypes as $k3=>$v3): ?>
                    <option value="<?php echo $k3; ?>" <?php if(($params['timetype'] == $k3)): ?>selected<?php endif; ?>><?php echo $v3; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control input-sm input-width for-input-wid" type="text" id="start_time" name="start_time" value="<?php echo $params['start_time']; ?>" readonly>
                <span>到</span>
                <input class="form-control input-sm input-width for-input-wid" type="text" id="end_time" name="end_time" value="<?php echo $params['end_time']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="searchKey"></label>
                <select class="form-control" title="" id="searchKey" name="searchKey">
                    <?php foreach($searchKey as $keyId=>$keyName): ?>
                    <option value="<?php echo $keyId; ?>" <?php if($params['searchKey'] == $keyId): ?>selected<?php endif; ?>><?php echo $keyName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="searchValue"></label>
                <input type="text" class="form-control" id="searchValue" name="searchValue"
                       placeholder="支持多个搜索(空格或逗号隔开)" value="<?php echo $params['searchValue']; ?>"/>
            </div>
            <button class="btn btn-primary">搜索</button>
        </div>
    </div>
</form>
    <?php endif; ?>
    <div class="panel-body">
        <ul class="nav nav-tabs nav-curstom">
    <?php foreach($userStatus as $key => $val): if(can(urlbuld('/v1/users/index/', $key))): ?>
    <li role="presentation" class="marg-left <?php if(($request->action() == $key)): ?>active<?php endif; ?>"><a
            href="<?php echo urlbuld('/v1/users/index/', $key,['searchKey'=>$search_key,'searchValue'=>$search_value]); ?>"><?php echo $val; ?> <span class="badge badge-primary"><?php echo isset($statusTotals[$key])?$statusTotals[$key]: 0; ?></span></a></li>
    <?php endif; endforeach; ?>
</ul>
        <?php if(($curJobType == 9)): ?>
        <div class="form-group margin-t">
    <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="badge box_total">0</span>批量操作 <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <?php echo build_toolbar('a',
                ['class' => 'savePending','data-url' => url('/v1/users/index/pending',array('statusValue'=>0))],
                '<i class="glyphicon glyphicon-pencil"></i> 转入已发OFFER'); ?>
            <li>
                <?php echo build_toolbar('a',
                ['class' => 'bathdel','data-url' => url('/v1/users/index/del',array('status'=>2))],
                '<i class="glyphicon glyphicon-remove"></i> 批量删除'); ?>
        </ul>
    </div>
</div>

        <?php else: ?>
        <div class="form-group margin-t">
    <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="badge box_total">0</span>批量操作 <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <?php echo build_toolbar('a',
                ['class' => 'editrule','data-url' => url('/v1/users/index/editrule',array('saveType'=>'job_id'))],
                '<i class="glyphicon glyphicon-pencil"></i> 批量修改岗位'); ?>
            </li>

            <li>
                <?php echo build_toolbar('a',
                ['class' => 'editrule','data-url' => url('/v1/users/index/editrule',array('saveType'=>'rules_id'))],
                '<i class="glyphicon glyphicon-pencil"></i> 批量修改权限标签'); ?>
            </li>

            <li>
                <?php echo build_toolbar('a',
                ['class' => 'editrule','data-url' => url('/v1/users/index/editrule',array('saveType'=>'allow'))],
                '<i class="glyphicon glyphicon-pencil"></i> 允许登录系统'); ?>
            </li>

            <?php if(($params['status'] != 2)): ?>
            <li>
                <?php echo build_toolbar('a',
                ['class' => 'savePending','data-url' => url('/v1/users/index/pending',array('statusValue'=>3))],
                '<i class="glyphicon glyphicon-pencil"></i> 批量转离职'); ?>
            </li>

            <?php endif; ?>
        </ul>
    </div>
</div>

        <?php endif; ?>
        <div class="table-responsive">
            <?php if($curJobType == 9): ?>
            <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="td-align td-width-40px">
            <input class="data-check_box_total" type="checkbox"/>
        </th>
        <th class="td-align">ID</th>
        <th class="td-align">姓名</th>
        <th class="td-align">邮箱/手机号</th>
        <th class="td-align">部门/角色</th>
        <th class="td-align">职位</th>
        <th class="td-align">协议类型</th>
        <th class="td-align">是否提前准备电脑</th>
        <th class="td-align">住宿安排</th>
        <th class="td-align">创建人</th>
        <th class="td-align">时间信息</th>
        <th class="td-align">备注</th>
        <th class="td-align">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($userInfo as $key=>$val): ?>
    <tr>
        <td class="td-align td-padding">
            <input class="data-check_box" name="box_checked" data-id="<?php echo $val['id']; ?>" type="checkbox"/>
        </td>
        <td class="td-align td-padding" style="width: 100px;"><?php echo isset($val['id'])?$val['id']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['username'])?$val['username']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['email'])?$val['email']: ''; ?><br><?php echo isset($val['mobile'])?$val['mobile']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['org_id'])?$val['org_id']: ''; ?><br><span class="text-primary"><?php echo isset($userJobInfo[$val['job_type']])?$userJobInfo[$val['job_type']]: ''; ?></span></td>
        <td class="td-align td-padding"><?php echo $val['position']; ?></td>
        <td class="td-align td-padding"><?php echo isset($pact_type[$val['pact_type']])?$pact_type[$val['pact_type']]: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($ready_computer[$val['ready_computer']])?$ready_computer[$val['ready_computer']]: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($room[$val['room']])?$room[$val['room']]: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['createuser'])?$val['createuser']: ''; ?></td>
        <td class="td-align td-paddingtd-padding small">
            <div class="div-wid">
                <div>预计入职时间：<?php echo $val['preentrytime']; ?></div>
                <div>手续时间：<?php echo $val['proceduretime']; ?></div>
                <div>滞留时间：<?php echo $val['retention_time']; ?></div>
            </div>
        </td>
        <td class="td-align td-padding td-width-10">
            <div class="notes" id="<?php echo $val['id']; ?>" data-url="<?php echo url('/v1/users/index/savenote'); ?>"><?php echo $val['remarks']; ?></div>
        </td>
        <td class="td-align td-padding">
            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-primary editusername','data-url' => url('/v1/users/index/edit',array('id'=>$val['id']))],
            '<i class="glyphicon glyphicon-pencil"></i> 编辑'); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="pages"><?php echo isset($pages)?$pages: ''; ?></div>
            <?php elseif($curJobType == 10): ?>
            <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="td-align td-width-40px">
            <input class="data-check_box_total" type="checkbox"/>
        </th>
        <th class="td-align">ID</th>
        <th class="td-align">姓名</th>
        <th class="td-align">邮箱/手机号</th>
        <th class="td-align">部门/角色</th>
        <th class="td-align">岗位</th>
        <th class="td-align">权限标签</th>
        <th class="td-align">允许登录系统</th>
        <th class="td-align">状态</th>
        <th class="td-align">授权时间/授权人</th>
        <th class="td-align">授权过期时间</th>
        <th class="td-align">最后登录时间</th>
        <th class="td-align">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($userInfo as $key=>$val): ?>
    <tr>
        <td class="td-align td-padding">
            <input class="data-check_box" name="box_checked" data-id="<?php echo $val['id']; ?>" type="checkbox"/>
        </td>
        <td class="td-align td-padding" style="width: 100px;"><?php echo isset($val['id'])?$val['id']: ''; ?></td>
        <td class="td-align td-padding td-width-110px"><?php echo isset($val['username'])?$val['username']: ''; ?></td>
        <td class="td-align td-padding td-width-160px"><?php echo isset($val['email'])?$val['email']: ''; ?><br><?php echo isset($val['mobile'])?$val['mobile']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['org_id'])?$val['org_id']: ''; ?><br><span class="text-primary"><?php echo isset($userJobInfo[$val['job_type']])?$userJobInfo[$val['job_type']]: ''; ?></span></td>
        <td class="td-align td-padding td-width-90px"><?php echo isset($val['job_id'])?$val['job_id']: ''; ?></td>
        <td class="td-align td-padding td-width-160px"><?php echo isset($val['rules_id'])?$val['rules_id']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['allow'])?$val['allow']: ''; ?></td>
        <td class="td-align td-padding td-width-62px">
            <?php echo user_online_html($val['token']); ?>
        </td>
        <td class="td-align td-padding td-width-160px">
            <?php echo $val['authtime']; ?><br>
            <?php echo $val['maturityuser']; ?>
        </td>
        <td class="td-align td-padding td-width-160px">
            <?php echo $val['maturitytime']; ?>
        </td>
        <td class="td-align td-paddingtd-padding td-width-160px">
            <?php echo $val['logintime']; ?>
            <br>
            <span class="text-primary"><?php echo isset($val['loginip'])?$val['loginip']: ''; ?></span>
        </td>
        <td class="td-align td-padding td-width-240px">
            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-primary editusername','data-url' => url('/v1/users/index/editrule',array('saveType'=>'all','ids'=>$val['id'],'status'=>$val['status']))],
            '<i class="glyphicon glyphicon-pencil"></i> 编辑'); ?>
            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-warning bathdel','datas-id' => $val['id'], 'data-url' => url('/v1/users/index/del',array('status'=>$val['status']))],
            '<i class="glyphicon glyphicon-trash"></i> 回收站'); ?>
            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-success showLog','data-url' => url('/v1/users/index/showlog',array('id'=>$val['id']))],
            '<i class="glyphicon glyphicon-eye-open"></i> 日志'); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php echo isset($pages)?$pages: ''; else: ?>
            <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="td-align td-width-40px">
            <input class="data-check_box_total" type="checkbox"/>
        </th>
        <th class="td-align">ID</th>
        <th class="td-align">姓名</th>
        <th class="td-align">邮箱/手机号</th>
        <th class="td-align">部门/角色</th>
        <th class="td-align">岗位</th>
        <th class="td-align">权限标签</th>
        <th class="td-align">允许登录系统</th>
        <th class="td-align">状态</th>
        <th class="td-align">授权时间/授权人</th>
        <th class="td-align">授权过期时间</th>
        <th class="td-align">最后登录时间</th>
        <th class="td-align">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($userInfo as $key=>$val): ?>
    <tr>
        <td class="td-align td-padding">
            <input class="data-check_box" name="box_checked" data-id="<?php echo $val['id']; ?>" type="checkbox"/>
        </td>
        <td class="td-align td-padding td-width-90px"><?php echo isset($val['id'])?$val['id']: ''; ?></td>
        <td class="td-align td-padding td-width-110px"><?php echo isset($val['username'])?$val['username']: ''; ?></td>
        <td class="td-align td-padding td-width-160px"><?php echo isset($val['email'])?$val['email']: ''; ?><br><?php echo isset($val['mobile'])?$val['mobile']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['org_id'])?$val['org_id']: ''; ?><br><span class="text-primary"><?php echo isset($userJobInfo[$val['job_type']])?$userJobInfo[$val['job_type']]: ''; ?></span></td>
        <td class="td-align td-padding td-width-160px"><?php echo isset($val['job_id'])?$val['job_id']: ''; ?></td>
        <td class="td-align td-padding td-width-160px"><?php echo isset($val['rules_id'])?$val['rules_id']: ''; ?></td>
        <td class="td-align td-padding"><?php echo isset($val['allow'])?$val['allow']: ''; ?></td>
        <td class="td-align td-padding td-width-62px">
            <?php echo user_online_html($val['token']); ?>
        </td>
        <td class="td-align td-padding td-width-160px">
            <?php echo $val['authtime']; ?><br>
            <?php echo $val['maturityuser']; ?>
        </td>
        <td class="td-align td-padding td-width-160px">
            <?php echo $val['maturitytime']; ?>
        </td>
        <td class="td-align td-paddingtd-padding td-width-160px">
            <?php echo $val['logintime']; ?>
            <br>
            <span class="text-primary"><?php echo isset($val['loginip'])?$val['loginip']: ''; ?></span>
        </td>
        <td class="td-align td-padding td-width-240px">
            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-primary editusername','data-url' => url('/v1/users/index/editrule',array('saveType'=>'all','ids'=>$val['id'],'status'=>$val['status']))],
            '<i class="glyphicon glyphicon-pencil"></i> 编辑'); ?>

            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-warning bathdel','datas-id' => $val['id'], 'data-url' => url('/v1/users/index/del',array('status'=>9))],
            '<i class="glyphicon glyphicon-trash"></i> 回收站'); ?>

            <?php echo build_toolbar('button',
            ['class' => 'btn btn-sm btn-success showLog','data-url' => url('/v1/users/index/showlog',array('id'=>$val['id']))],
            '<i class="glyphicon glyphicon-eye-open"></i> 日志'); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php echo isset($pages)?$pages: ''; endif; ?>
        </div>
    </div>
</div>

        </div>
    </div>
    <script id="test" type="text/html">
    <h1>{{title}}</h1>1wwerewrewr
</script>
    <!-- 加载JS脚本 -->
    <!-- jQuery 3 -->
    <!-- jQuery 3 -->
<script src="/vendor/jquery/jquery.min.js?v=<?php echo $config['site']['version']; ?>"></script>
    <!-- 自定义js -->
    <!-- 自定义js模板 -->
    <!-- require -->
<script src="/dist/js/require.js?v=<?php echo $config['site']['version']; ?>" data-main="/dist/js/require-main.js?v=<?php echo $config['site']['version']; ?>"></script>
</body>
</html>
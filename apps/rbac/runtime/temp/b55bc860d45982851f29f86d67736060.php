<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:70:"/opt/web/zs/apps/rbac/public/../application/v1/view/index/profile.html";i:1555559259;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986348;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1556240506;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891314;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <a href="#" class="sidebar-toggle <?php if($adaptive): ?>open<?php endif; ?>" data-toggle="offcanvas" role="button">
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
            

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="/dist/img/avatar.png" width="100" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?php echo $userinfo['username']; ?></h3>
                        <p class="text-muted text-center"><?php echo $userinfo['id']; ?></p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email:</b> <a class="float-right"><?php echo $userinfo['email']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>手机:</b> <a class="float-right"><?php echo $userinfo['mobile']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>组织:</b> <a class="float-right"><?php echo isset($allOrg[$userinfo['org_id']])?$allOrg[$userinfo['org_id']]: ''; ?>  <?php echo isset($getUserObj[$userinfo['job_id']])?$getUserObj[$userinfo['job_id']]: ''; ?>  <?php echo isset($userJob[$userinfo['job_type']])?$userJob[$userinfo['job_type']]: ''; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>授权人:</b> <a class="float-right"><?php echo $userinfo['maturityuser']; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>授权到期:</b> <a class="float-right"><?php echo date('Y-m-d H:i:s',$userinfo['maturitytime']); ?></a>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-block btn-dialog" data-url="<?php echo url('/v1/index/changepass'); ?>" title="修改信息/密码"><b>修改信息/密码</b></button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- About Me Box -->
                <!--<div class="card card-primary">-->
                    <!--<div class="card-header">-->
                        <!--<h3 class="card-title">About Me</h3>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /.card-header &ndash;&gt;-->
                    <!--<div class="card-body">-->
                        <!--<strong><i class="fa fa-book mr-1"></i> Education</strong>-->
                        <!--<p class="text-muted">-->
                            <!--B.S. in Computer Science from the University of Tennessee at Knoxville-->
                        <!--</p>-->
                        <!--<hr>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /.card-body &ndash;&gt;-->
                <!--</div>-->
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <!--<li class="nav-item active"><a class="nav-link active " href="#activity" data-toggle="tab">动态</a></li>-->
                            <li class="nav-item active"><a class="nav-link" href="#timeline" data-toggle="tab">最新日志</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="timeline">
                                <!-- The timeline -->
                                <ul class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <!--<li class="time-label">-->
                                        <!--<span class="bg-danger">10 Feb. 2014</span>-->
                                    <!--</li>-->
                                    <?php if($usersLogs): foreach($usersLogs as $logs): ?>
                                    <li>
                                        <i class="fa fa-comments bg-warning"></i>
                                        <div class="timeline-item">
                                            <span class="time"> <i class="fa fa-clock-o"></i> <?php echo retentionTimes(strtotime($logs['createtime'])); ?></span>
                                            <h3 class="timeline-header"><a href="#"><?php echo $logs['title']; ?></a> <?php echo $logs['url']; ?></h3>
                                            <div class="timeline-body">
                                                <?php echo json_tostring($logs['content']); ?>
                                            </div>
                                            <!--<div class="timeline-footer">-->
                                                <!--<a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>-->
                                            <!--</div>-->
                                        </div>
                                    </li>
                                    <?php endforeach; endif; ?>
                                </ul>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

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
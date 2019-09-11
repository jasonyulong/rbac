<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:73:"/opt/web/zs/apps/rbac/public/../application/v1/view/auth/index/index.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1553692263;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1554716647;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
<body class="skin-blue fixed adaptive">
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
    <ul class="nav navbar-top-links navbar-left" role="tablist">
        <li class="dropdown">
            <a href="<?php echo url('/'); ?>" class="dropdown-toggle"><i class="fa fa-home"></i> <span>首页</span></a>
        </li>
        <li class="dropdown">
            <a href="<?php echo url('/v1/users/index'); ?>" class="dropdown-toggle" data-hover="dropdown">
                <i class="fa fa-users"></i> <span>用户</span>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
                <div class="title">用户入职列表</div>
                <li class="mini clearfix">
                    <a href="<?php echo urlbuld('/v1/users/index/'); ?>"><i class="fa fa-angle-right"></i> 全部</a>
                </li>
                <div class="title">用户权限列表</div>
                <li class="mini clearfix">
                    <a href="<?php echo urlbuld('/v1/users/index/'); ?>"><i class="fa fa-angle-right"></i> 全部</a>
                </li>
            </ul>

        </li>
        <li class="dropdown">
            <a href="<?php echo url('/v1/auth/index'); ?>" class="dropdown-toggle" data-hover="dropdown">
                <i class="fa fa-cube"></i> <span>权限</span>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
                <div class="title">部门/岗位</div>
                <li class="mini clearfix">
                    <a href="#"><i class="fa fa-angle-right"></i> 部门管理</a>
                    <a href="#"><i class="fa fa-angle-right"></i> 岗位管理</a>
                    <a href="#"><i class="fa fa-angle-right"></i> 岗位管理</a>
                </li>
                <div class="title">菜单管理</div>
                <li class="mini clearfix">
                    <a href="<?php echo urlbuld('/v1/menus/index/systemrbac'); ?>"><i class="fa fa-angle-right"></i> 菜单列表</a>
                </li>
            </ul>
        </li>
        <li class="dropdown active">
            <a href="<?php echo url('/v1/system/index'); ?>" class="dropdown-toggle" data-hover="dropdown">
                <i class="fa fa-cogs"></i> <span>系统</span>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
                <div class="title">设置</div>
                <li class="mini clearfix">
                    <a href="#"><i class="fa fa-angle-right"></i> 基本设置</a>
                    <a href="#"><i class="fa fa-angle-right"></i> 操作日志</a>
                    <a href="#"><i class="fa fa-angle-right"></i> 访问日志</a>
                </li>
            </ul>
            <!-- /.dropdown-messages -->
        </li>
    </ul>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i>
                <span class="label label-danger">4</span>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                            </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                        </div>
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>Read All Messages</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown user user-menu">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <img src="/dist/img/avatar5.png" class="user-image" alt="User Image"> 管理员 <i
                    class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo url($config['url']['profile']); ?>"><i class="fa fa-user fa-fw"></i> 我的资料</a></li>
                <li><a href="<?php echo url($config['url']['setting']); ?>"><i class="fa fa-gear fa-fw"></i> 我的设置</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo url($config['url']['logout']); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> 控制台</a>
                </li>
                <li class="active">
                    <a href="#"><i class="fa fa-bar-chart-o fa-users"></i> 用户管理 <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo urlbuld('/v1/users/index/'); ?>"><i class="fa fa-chevron-right"></i> 用户入职列表</a>
                        </li>

                        <li>
                            <a href="<?php echo urlbuld('/v1/users/index/'); ?>"><i class="fa fa-chevron-right"></i> 用户权限列表</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-cube"></i> 权限管理 <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="<?php echo urlbuld('/v1/auth/position/index'); ?>"><i class="fa fa-chevron-right"></i> 岗位管理</a>
                        </li>
                        <li>
                            <a href="<?php echo urlbuld('/v1/auth/tag/index'); ?>"><i class="fa fa-chevron-right"></i> 权限标签</a>
                        </li>
                        <li>
                            <a href="typography.html"><i class="fa fa-chevron-right"></i> 菜单管理</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="glyphicon glyphicon-th"></i> 组织架构 <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="<?php echo urlbuld('/v1/group/department/index'); ?>"><i class="fa fa-chevron-right"></i> 部门管理</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-chevron-right"></i> 组织架构列表</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-chevron-right"></i> 15天新用户授权</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-cogs"></i> 系统管理 <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="<?php echo urlbuld('/v1/system/config'); ?>"><i class="fa fa-chevron-right"></i> 基本设置</a>
                        </li>
                        <li>
                            <a href="<?php echo urlbuld('/v1/system/logs/doings'); ?>"><i class="fa fa-chevron-right"></i> 操作日志</a>
                        </li>
                        <li>
                            <a href="<?php echo urlbuld('/v1/system/logs/access'); ?>"><i class="fa fa-chevron-right"></i> 访问日志</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
        <!-- Full Width Column -->
        <div id="page-wrapper">
            


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
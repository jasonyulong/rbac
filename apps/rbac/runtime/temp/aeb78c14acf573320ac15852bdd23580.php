<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:68:"/opt/web/zs/apps/rbac/public/../application/v1/view/index/index.html";i:1565146764;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986350;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692264;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1565146704;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891316;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692264;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692264;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692264;}*/ ?>
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
            <a href="<?php echo $config['app']['erpdomain']; ?>" class="dropdown-toggle" data-hover="dropdown"> <i class="fa fa-fw fa-cubes"></i> <span>ERP</span> <span class="pull-right-container"> </span></a>
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
                <img src="/dist/img/avatar.png" class="user-image" alt="User Image"> <i class="fa fa-caret-down"></i>
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
            
<div class="row">
    <?php foreach($statusNum as $k=>$name): ?>
    <div class="col-lg-3 col-md-6">
        <div class="panel <?php echo isset($statusColor[$name])?$statusColor[$name]: ''; ?>">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo isset($list[$name])?$list[$name]: 0; ?></div>
                        <div><?php echo isset($statusName[$name])?$statusName[$name]: ''; ?></div>
                    </div>
                </div>
            </div>
            <a href="<?php echo isset($urlValue[$name])?$urlValue[$name]: '#'; ?>">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>



<!-- /.row -->
<!--<div class="row">-->
<!--<div class="col-lg-12">-->
<!--<div class="panel panel-default">-->
<!--<div class="panel-heading">-->
<!--<i class="fa fa-bar-chart-o fa-fw"></i> 用户分布图-->
<!--<div class="pull-right">-->
<!--<div class="btn-group">-->
<!--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">-->
<!--Actions-->
<!--<span class="caret"></span>-->
<!--</button>-->
<!--<ul class="dropdown-menu pull-right" role="menu">-->
<!--<li><a href="#">Action</a></li>-->
<!--<li><a href="#">Another action</a></li>-->
<!--<li><a href="#">Something else here</a></li>-->
<!--<li class="divider"></li>-->
<!--<li><a href="#">Separated link</a></li>-->
<!--</ul>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!--&lt;!&ndash; /.panel-heading &ndash;&gt;-->
<!--<div class="panel-body">-->
<!--<div id="morris-area-chart"></div>-->
<!--</div>-->
<!--&lt;!&ndash; /.panel-body &ndash;&gt;-->
<!--</div>-->
<!--&lt;!&ndash; /.panel &ndash;&gt;-->
<!--</div>-->
<!--&lt;!&ndash; /.col-lg-8 &ndash;&gt;-->
<!--</div>-->
<!-- /.row -->
<!-- /#page-wrapper -->

        </div>
    </div>
    <script id="test" type="text/html">
    <h1>{{title}}</h1>1wwerewrewr
</script>
    <!-- 加载JS脚本 -->
    <!-- jQuery 3 -->
    <!-- jQuery 3 -->
<script src="/vendor/jquery/jquery.min.js?v=<?php echo $config['site']['version']; ?>"></script>
    
<!-- Morris Charts JavaScript -->
<script src="/vendor/raphael/raphael.min.js"></script>
<!--<script src="/vendor/morrisjs/morris.min.js"></script>-->
<!--<script src="/data/morris-data.js"></script>-->

    <!-- 自定义js模板 -->
    <!-- require -->
<script src="/dist/js/require.js?v=<?php echo $config['site']['version']; ?>" data-main="/dist/js/require-main.js?v=<?php echo $config['site']['version']; ?>"></script>
</body>
</html>
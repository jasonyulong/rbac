<?php if (!defined('THINK_PATH')) exit(); /*a:10:{s:76:"/opt/web/zs/apps/rbac/public/../application/v1/view/auth/position/index.html";i:1554891314;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986348;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1556509685;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891314;s:71:"/opt/web/zs/apps/rbac/application/v1/view/auth/position/index_form.html";i:1555897544;s:72:"/opt/web/zs/apps/rbac/application/v1/view/auth/position/index_table.html";i:1556509685;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="badge box_total">0</span> 批量操作 <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
        <!--物流操作-->
        <?php echo build_toolbar('a',
        ['class' => 'batch_delete','data-url' => url('/v1/auth/position/delete')],
        '<i class="glyphicon glyphicon-remove"></i> 批量删除'); ?>
        </li>
    </ul>
</div>
<div class="btn-group">
    <?php echo build_toolbar('button',
    ['class' => 'btn btn-success btn-sm add','data-url' => url('/v1/auth/position/add')],
    '<i class="glyphicon glyphicon-plus"></i> 新增岗位'); ?>
</div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
    <thead>
    <tr>
        <th class="td-align td-width-40px">
            <input class="data-check_box_total" type="checkbox"/>
        </th>
        <th class="td-align">岗位名称</th>
        <th class="td-align">用户</th>
        <th class="td-align">自动获取所有帐号可见权限</th>
        <th class="td-align">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['rank'] != 1): ?>
    <tr class="show-<?php echo $vo['tid']; ?>" style="display: none">
    <?php else: ?>
    <tr>
    <?php endif; ?>
        <td class="td-align td-padding">
            <input type="checkbox" name="box_checked" data-id="<?php echo $vo['id']; ?>" class="data-check_box">
        </td>
        <td class="td-padding <?php echo $vo['rank']; ?>">
            <?php if($vo['rank'] == 1): ?>
            <i class="glyphicon glyphicon-home"></i>
            <?php endif; if($vo['id'] == 1): ?><span class="text-danger"><?php echo $vo['title']; ?></span><?php else: ?><?php echo $vo['title']; endif; if($vo['rank'] == 1 and $vo['id'] != 1): ?>
            <a href="#" class="pos-show" data-id="<?php echo $vo['tid']; ?>"><i class="glyphicon glyphicon-menu-down"></i></a>
            <?php endif; ?>
        </td>
        <?php if(($vo['under'])): ?>
            <td class="td-align td-padding"><a class="a-show cat" data-url="<?php echo url('/v1/auth/position/cat',array('id'=>$vo['id'])); ?>"><?php echo $vo['under']; ?></a></td>
        <?php else: ?>
            <td class="td-align td-padding">0</td>
        <?php endif; ?>
        <td class="td-align td-padding">
            <?php if($vo['auto_account'] == 1): ?> <span class="label label-success">是</span> <?php else: ?> <span class="label label-default">否</span> <?php endif; ?>
        </td>
        <td class="td-align td-padding">
            <?php if($vo['id'] != 1): ?>

            <?php echo build_toolbar('button',
            ['class' => 'btn btn-primary btn-sm btn-padding edit','data-url' => url('/v1/auth/position/edit',array('id'=>$vo['id']))],
            '<i class="glyphicon glyphicon-pencil"></i> 编辑'); ?>

            <?php echo build_toolbar('a',
            ['class' => 'btn btn-info btn-sm btn-padding','href' => url('/v1/auth/access/index', ['id'=>$vo['id']])],
            '<i class="fa fa-cube"></i> 功能权限'); ?>

            <?php echo build_toolbar('a',
            ['class' => 'btn btn-success btn-sm btn-padding','href' => url('/v1/auth/access/useralso', ['job_id'=>$vo['id']])],
            '<i class="fa  fa-eye"></i> 可见权限'); ?>

            <?php echo build_toolbar('button',
            ['class' => 'btn btn-warning btn-sm btn-padding copy','data-url' => url('/v1/auth/position/copy',array('id'=>$vo['id']))],
            '<i class="glyphicon glyphicon-copy"></i> 复制'); endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
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
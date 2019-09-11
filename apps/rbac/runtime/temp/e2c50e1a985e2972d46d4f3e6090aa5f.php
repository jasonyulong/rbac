<?php if (!defined('THINK_PATH')) exit(); /*a:10:{s:74:"/opt/web/zs/apps/rbac/public/../application/v1/view/menus/index/index.html";i:1555487665;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986348;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1556509685;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891314;s:66:"/opt/web/zs/apps/rbac/application/v1/view/menus/index/navtabs.html";i:1554793744;s:70:"/opt/web/zs/apps/rbac/application/v1/view/menus/index/_indextable.html";i:1556077502;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <ul class="nav nav-tabs nav-curstom">
    <?php foreach($allowSystem as $key => $val): ?>
    <li role="presentation" class="marg-left <?php if(($module_id == $key)): ?>active<?php endif; ?>"><a href="<?php echo url('/v1/menus/index/index', array('module_id'=>$key)); ?>"><?php echo $val; ?> <span class="badge badge-primary"><?php echo isset($menusTotals[$key])?$menusTotals[$key]: 0; ?></span></a></li>
    <?php endforeach; ?>
</ul>
    <div class="panel-body">
        <div class="table-responsive">
            <div class="table-titles">
    <button class="btn btn-success addmenus" data-url="<?php echo url('/v1/menus/index/edit', array('module_id'=>$module_id)); ?>"><i
            class="glyphicon glyphicon-plus"></i>添加菜单
    </button>
</div>
<table class="table table-striped table-bordered table-hover dataTables" id="dataTables">
    <thead>
    <tr>
        <th class="td-align td-width-50px">ID</th>
        <th class="td-align">标题</th>
        <th class="td-align">图标</th>
        <th class="td-align">请求地址</th>
        <th class="td-align">权重</th>
        <th class="td-align">状态</th>
        <th class="td-align">类型</th>
        <th class="td-align">创建时间</th>
        <th class="td-align">备注</th>
        <th class="td-align">操作</th>
    </tr>
    </thead>
    <tbody id="scroll_table_head">
    <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$vo): ?>
    <tr class="<?php if($vo['type'] == 1): ?>warning<?php endif; ?>">
        <td class="td-align td-padding"><?php echo $vo['id']; ?></td>
        <td class=""><?php echo $vo['title']; ?></td>
        <td class="td-align td-padding"><i class="<?php echo $vo['icon']; ?>"></i></td>
        <td class="td-padding"><?php echo $vo['url']; ?></td>
        <td class="td-align td-padding"><?php echo $vo['weigh']; ?></td>
        <?php if($vo['status'] == 1): ?>
        <td class="td-align text-success"><i class="fa fa-circle"> 正常</i></td>
        <?php else: ?>
        <td class="td-align text-danger"><i class="fa fa-times-circle"> 禁用</i></td>
        <?php endif; ?>
        <td class="td-align">
            <?php echo isset($menuFields['type'][$vo['type']])?$menuFields['type'][$vo['type']]: ''; ?>
        </td>
        <td class="td-align td-paddingtd-padding"><?php if(!(empty($vo['createtime']) || (($vo['createtime'] instanceof \think\Collection || $vo['createtime'] instanceof \think\Paginator ) && $vo['createtime']->isEmpty()))): ?><?php echo date("Y-m-d H:i:s",$vo['createtime']); endif; ?>
        </td>
        <td class="td-align td-padding"><?php echo $vo['remark']; ?></td>
        <td class="td-align td-padding">
            <?php echo build_toolbar('button',
            ['class' => 'btn btn-primary btn-xs menudetail','title' => '查看节点','data-url' => url('/v1/menus/index/detail',array('id'=>$vo['id']))],
            '<i class="fa fa-sitemap"></i>'); ?>

            <?php echo build_toolbar('button',
            ['class' => 'btn btn-success btn-xs editmenus','title' => '编辑菜单','data-url' => url('/v1/menus/index/edit',array('id'=>$vo['id'],'module_id'=>$module_id))],
            '<i class="fa fa-pencil"></i>'); ?>

            <?php echo build_toolbar('button',
            ['class' => 'btn btn-danger btn-xs delmenus','title' => '删除','data-param' => $vo['id'],'data-url' => url('/v1/menus/index/del')],
            '<i class="fa fa-trash"></i>'); ?>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
<div class="pages"><?php echo isset($pages)?$pages: ''; ?></div>
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
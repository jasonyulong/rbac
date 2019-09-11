<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:74:"/opt/web/zs/apps/rbac/public/../application/v1/view/users/index/comer.html";i:1553763208;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1553692263;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1553762992;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        <a class="navbar-brand" href="<?php echo url('/'); ?>">ZS <small>v2.0</small></a>
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
                <div class="title">用户列表</div>
                <li class="mini clearfix">
                    <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-angle-right"></i> 全部</a>
                    <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-angle-right"></i> 已发Offer</a>
                    <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-angle-right"></i> 待入职</a>
                    <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-angle-right"></i> 已入职</a>
                    <a href="<?php echo url('/v1/users/index'); ?>"><i class="fa fa-angle-right"></i> 在职</a>
                    <a href="<?php echo url('/v1/users/index'); ?>"><i class="fa fa-angle-right"></i> 离职</a>
                    <a href="<?php echo url('/v1/users/index'); ?>"><i class="fa fa-angle-right"></i> 回收站</a>
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
                    <a href="#"><i class="fa fa-angle-right"></i> 菜单列表</a>
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
                <img src="/dist/img/avatar5.png" class="user-image" alt="User Image"> 管理员 <i class="fa fa-caret-down"></i>
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
                            <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-chevron-right"></i> 已发offer</a>
                        </li>
                        <li>
                            <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-chevron-right"></i> 待入职</a>
                        </li>
                        <li>
                            <a href="<?php echo url('/v1/users/index/comer'); ?>"><i class="fa fa-chevron-right"></i> 已入职</a>
                        </li>
                        <li>
                            <a href="<?php echo url('/v1/users/index/whole'); ?>"><i class="fa fa-chevron-right"></i> 全部</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-cube"></i> 权限管理 <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="panels-wells.html"><i class="fa fa-chevron-right"></i> 部门管理</a>
                        </li>
                        <li>
                            <a href="buttons.html"><i class="fa fa-chevron-right"></i> 岗位管理</a>
                        </li>
                        <li>
                            <a href="notifications.html"><i class="fa fa-chevron-right"></i> 权限标签</a>
                        </li>
                        <li>
                            <a href="typography.html"><i class="fa fa-chevron-right"></i> 菜单管理</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-cogs"></i> 系统管理 <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="panels-wells.html"><i class="fa fa-chevron-right"></i> 基本设置</a>
                        </li>
                        <li>
                            <a href="buttons.html"><i class="fa fa-chevron-right"></i> 操作日志</a>
                        </li>
                        <li>
                            <a href="notifications.html"><i class="fa fa-chevron-right"></i> 访问日志</a>
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
            
<div class="row page-header content-header">
    <h3>用户管理</h3>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> 首页</a></li>
        <li>用户管理</li>
        <li class="active">查看</li>
    </ol>
</div>
<div class="content">
    <form class="form-inline">
    <div class="panel panel-default panel-btn">
        <div class="panel-heading">
            <div class="form-group">
                <label for="section">部门：</label>
                <select class="selectpicker show-tick" title="全部" id="section" name="section" data-actions-box="true" data-live-search="true" >
                <option value="">IT部</option>
                <option value="">产品开发部</option>
                <option value="">物流部</option>
                <option value="">业务部</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">状态：</label>
                <select class="selectpicker show-tick" title="" id="status" name="status" data-actions-box="true" data-live-search="true" >
                <option value="">在职</option>
                <option value="">离职</option>
                </select>
            </div>
            <div class="form-group">
                <label for="searchKey"></label>
                <select class="selectpicker show-tick" title="" id="searchKey" name="searchKey" data-actions-box="true" data-live-search="true" >
                    <option value="">姓名</option>
                    <option value="">手机</option>
                    <option value="">邮箱</option>
                </select>
            </div>
            <div class="form-group">
                <label for="searchValue"></label>
                <input type="text" class="form-control" id="searchValue" name="searchValue" placeholder="支持多个搜索(空格或逗号隔开)"/>
            </div>
            <button class="btn btn-primary">搜索</button>
        </div>
    </div>
    </form>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <ul class="nav nav-tabs nav-curstom">
            <li role="presentation" class="marg-left <?php if(($params['action_name'] == 'whole')): ?>active<?php else: ?>left-act<?php endif; ?>"><a href="<?php echo url('/v1/users/index/comer',['action_name'=>'whole']); ?>">全部</a></li>
            <li role="presentation" class="marg-left <?php if(($params['action_name'] == 'comer')): ?>active<?php else: ?>left-act<?php endif; ?>"><a href="<?php echo url('/v1/users/index/comer',['action_name'=>'comer']); ?>">已发offer(20)</a></li>
            <li role="presentation" class="marg-left <?php if(($params['action_name'] == 'comer')): ?>active<?php else: ?>left-act<?php endif; ?>"><a href="<?php echo url('/v1/users/index/comer'); ?>">待入职(30)</a></li>
            <li role="presentation" class="marg-left <?php if(($params['action_name'] == 'comer')): ?>active<?php else: ?>left-act<?php endif; ?>"><a href="<?php echo url('/v1/users/index/comer'); ?>">已入职(50)</a></li>
        </ul>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="td-align td-width-40px">
                        <input class="" type="checkbox"/>
                    </th>
                    <th class="td-align">姓名</th>
                    <th class="td-align">邮箱/手机号</th>
                    <th class="td-align">部门/角色</th>
                    <th class="td-align">创建时间</th>
                    <th class="td-align">滞留时间</th>
                    <th class="td-align">备注</th>
                    <th class="td-align">操作</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td-align td-padding">
                            <input class="" type="checkbox"/>
                        </td>
                        <td class="td-align td-padding">刘洋</td>
                        <td class="td-align td-padding">209289289@qq.com<br>13510129455</td>
                        <td class="td-align td-padding">开发部<br>开发</td>
                        <td class="td-align td-padding">2019-03-27 10:00</td>
                        <td class="td-align td-paddingtd-padding">
                            创建时间:2019-03-27 10:00<br>
                            入职时间:
                        </td>
                        <td class="td-align td-padding">1哈哈哈</td>
                        <td class="td-align td-padding">
                            <button class="btn edit" data-url="<?php echo url('/v1/users/index/edi',array('id'=>1)); ?>"><i class="fa fa-edit"></i></button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn deluser" data-url="<?php echo url('/v1/users/index/del',array('id'=>1)); ?>"><i class="fa fa-remove"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-align td-padding">
                            <input class="" type="checkbox"/>
                        </td>
                        <td class="td-align td-padding">刘洋</td>
                        <td class="td-align td-padding">209289289@qq.com<br>13510129455</td>
                        <td class="td-align td-padding">开发部<br>开发</td>
                        <td class="td-align td-padding">2019-03-27 10:00</td>
                        <td class="td-align td-paddingtd-padding">
                            创建时间:2019-03-27 10:00<br>
                            入职时间:
                        </td>
                        <td class="td-align td-padding">1哈哈哈</td>
                        <td class="td-align td-padding">
                            <button class="btn edit" data-url="<?php echo url('/v1/users/index/edi',array('id'=>1)); ?>"><i class="fa fa-edit"></i></button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn deluser" data-url="<?php echo url('/v1/users/index/del',array('id'=>1)); ?>"><i class="fa fa-remove"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-align td-padding">
                            <input class="" type="checkbox"/>
                        </td>
                        <td class="td-align td-padding">刘洋</td>
                        <td class="td-align td-padding">209289289@qq.com<br>13510129455</td>
                        <td class="td-align td-padding">开发部<br>开发</td>
                        <td class="td-align td-padding">2019-03-27 10:00</td>
                        <td class="td-align td-paddingtd-padding">
                            创建时间:2019-03-27 10:00<br>
                            入职时间:
                        </td>
                        <td class="td-align td-padding">1哈哈哈</td>
                        <td class="td-align td-padding">
                            <button class="btn edit" data-url="<?php echo url('/v1/users/index/edi',array('id'=>1)); ?>"><i class="fa fa-edit"></i></button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn deluser" data-url="<?php echo url('/v1/users/index/del',array('id'=>1)); ?>"><i class="fa fa-remove"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-align td-padding">
                            <input class="" type="checkbox"/>
                        </td>
                        <td class="td-align td-padding">刘洋</td>
                        <td class="td-align td-padding">209289289@qq.com<br>13510129455</td>
                        <td class="td-align td-padding">开发部<br>开发</td>
                        <td class="td-align td-padding">2019-03-27 10:00</td>
                        <td class="td-align td-paddingtd-padding">
                            创建时间:2019-03-27 10:00<br>
                            入职时间:
                        </td>
                        <td class="td-align td-padding">1哈哈哈</td>
                        <td class="td-align td-padding">
                            <button class="btn edit" data-url="<?php echo url('/v1/users/index/edi',array('id'=>1)); ?>"><i class="fa fa-edit"></i></button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn deluser" data-url="<?php echo url('/v1/users/index/del',array('id'=>1)); ?>"><i class="fa fa-remove"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-align td-padding">
                            <input class="" type="checkbox"/>
                        </td>
                        <td class="td-align td-padding">刘洋</td>
                        <td class="td-align td-padding">209289289@qq.com<br>13510129455</td>
                        <td class="td-align td-padding">开发部<br>开发</td>
                        <td class="td-align td-padding">2019-03-27 10:00</td>
                        <td class="td-align td-paddingtd-padding">
                            创建时间:2019-03-27 10:00<br>
                            入职时间:
                        </td>
                        <td class="td-align td-padding">1哈哈哈</td>
                        <td class="td-align td-padding">
                            <button class="btn edit" data-url="<?php echo url('/v1/users/index/edi',array('id'=>1)); ?>"><i class="fa fa-edit"></i></button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn deluser" data-url="<?php echo url('/v1/users/index/del',array('id'=>1)); ?>"><i class="fa fa-remove"></i></button>
                        </td>
                    </tr>
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
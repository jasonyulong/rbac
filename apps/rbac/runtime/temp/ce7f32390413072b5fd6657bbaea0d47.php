<?php if (!defined('THINK_PATH')) exit(); /*a:10:{s:77:"/opt/web/zs/apps/rbac/public/../application/v1/view/auth/access/useralso.html";i:1556162819;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986348;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1556509685;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891314;s:72:"/opt/web/zs/apps/rbac/application/v1/view/auth/access/useralso_left.html";i:1556240506;s:73:"/opt/web/zs/apps/rbac/application/v1/view/auth/access/useralso_table.html";i:1556240506;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    
<link rel="stylesheet" href="/vendor/bootstrap-treeview/bootstrap-treeview.min.css">

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
    <div class="row">
        <div class="col-md-2 left-job">
            <div class="row" style="padding: 10px 15px;">
    <div class="col-sm-6 col-md-6" style="padding: 0;">
        <select name="" id="job_list" class="form-control selectpicker" data-actions-box="true" data-live-search="true" size="6">
            <option value="">----选择岗位----</option>
            <?php foreach($all_jobs as $value): ?>
            <option value="<?php echo $value['id']; ?>" <?php if($job_info['id'] == $value['id']): ?>selected<?php endif; ?> data-users='<?php echo $value["job_users_json"]; ?>'><?php echo str_repeat('--', ($value['rank'] - 1)); ?><?php echo $value['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-sm-6 col-md-6" style="padding: 0;">
        <select name="" id="select_users" class="form-control selectpicker" data-actions-box="true" data-live-search="true">
            <option value="">----选择用户----</option>
            <?php foreach($all_users as $value): ?>
            <option value="<?php echo $value['id']; ?>" data-job_id="<?php echo $value['job_id']; ?>"><?php echo $value['username']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<ul class="list-group" id="user_list">
    <?php foreach($all_users as $value): ?>
    <a class="list-group-item <?php if($params['user_id'] == $value['id']): ?>active<?php endif; ?>"  href="<?php echo url('', ['job_id' => $value['job_id'], 'user_id' => $value['id']], ''); ?>"><?php echo $value['username']; ?></a>
    <?php endforeach; ?>
</ul>

<div class="navbar-default" role="navigation"></div>
        </div>
        <div class="col-md-10 menu-content">
            <div class="row quick-set">
    <div class="col-xs-2 col-sm-2 col-md-2">
        <h4><?php echo isset($user_info['username'])?$user_info['username']: ''; ?></h4>
    </div>
    <div class="col-xs-7 col-sm-7 col-md-7"></div>
        
    <div class="col-xs-3 col-sm-3 col-md-3">
       
    </div>
</div>

<form action="<?php echo url('useralsosave'); ?>" id="default_form">

    <input type="hidden" name="job_id" value="<?php echo isset($params['job_id'])?$params['job_id']: 0; ?>">
    <input type="hidden" name="user_id" value="<?php echo isset($params['user_id'])?$params['user_id']: 0; ?>">
    <input type="hidden" name="module_id" value="<?php echo isset($params['module_id'])?$params['module_id']: 0; ?>">
    

    <?php if($params['module_id'] == 2): ?>
    <div class="panel panel-primary level1-rule" id="anchor-oversee-div">
        <div class="panel-heading" id="anchor-oversee">
            <label class="panel-title "><input type="checkbox" name="" class="level1-checkbox" value="" />
                可见管理
            </label>
        </div>

        <?php if($all_access_order_status): ?>
        <div class="panel-body  level2-rule">
            <div class="panel panel-info">
                    <div class="panel-heading">
                        &nbsp;&nbsp;<label class="panel-title "><input type="checkbox" class="level2-checkbox"/>订单可见性</label>
                    </div>
                    <div class="panel-body level3-rule">
                        <div class="level3-rule other-rule">
                            <?php foreach($all_access_order_status as $value): ?>
                            <label class=""><input type="checkbox" name="order_status[]" class="level3-checkbox" value="<?php echo $value['id']; ?>" id="" <?php if($value['access'] == 1): ?>checked<?php endif; ?> /> <?php echo $value['name']; ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
            </div>
        </div>
        <?php endif; if($all_stores): ?>
        <div class="panel-body  level2-rule">
            <div class="panel panel-info">
                    <div class="panel-heading">
                        &nbsp;&nbsp;<label class="panel-title "><input type="checkbox" class="level2-checkbox"/>仓库</label>
                    </div>
                    <div class="panel-body level3-rule">
                        <div class="level3-rule other-rule">
                            <?php foreach($all_stores as $value): ?>
                            <label class=""><input type="checkbox" name="store_id[]" class="level3-checkbox" value="<?php echo $value['id']; ?>" id="" <?php if($value['access'] == 1): ?>checked<?php endif; ?> /> <?php echo $value['store_name']; ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
            </div>
        </div>
        <?php endif; if($all_accounts): ?>
        <div class="panel-body  level2-rule">
            <div class="panel panel-info">
                    <div class="panel-heading">
                        &nbsp;&nbsp;<label class="panel-title "><input type="checkbox" class="level2-checkbox"/>全平台账号</label>
                    </div>
                    <div class="panel-body level3-rule">
                        <div class="level3-rule other-rule">
                            <ul class="platform-nav">
                            <?php foreach($all_accounts as $key => $value): ?>
                                <li role="presentation" class="<?php if($key == $default_platform): ?>active<?php endif; ?>">
                                    <input type="checkbox" data-platform="<?php echo $key; ?>" class="platform-select platform-select-<?php echo $key; ?>">
                                    <a href="javascript:void(0);" data-platform="<?php echo $key; ?>" class="platform-tab"><?php echo $key; ?> </a></li>
                            <?php endforeach; ?>
                            </ul>

                            <?php foreach($all_accounts as $key => $value): ?>
                            <div data-platform="<?php echo $key; ?>" class="<?php echo $key; ?>_account_div platform-div" <?php if($key != $default_platform): ?>style="display:none;"<?php endif; ?>>
                                <?php foreach($value as $k => $v): ?>
                                <label  ><input type="checkbox" name="account[]" class="level3-checkbox" id="" value="<?php echo $k; ?>" <?php if($account_access[$v] == 1): ?>checked<?php endif; ?> /> <?php echo $v; ?></label>
                                <?php endforeach; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="save-div">
        <button class="btn btn-success btn-lg" type="submit">确定保存</button>
    </div>
</form>
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
    
<script src="/vendor/bootstrap-treeview/bootstrap-treeview.min.js" ></script>
<script>
<?php if(\think\Request::instance()->action() == 'index'): ?>
$(function() {
    var data = '<?php echo $job_tree; ?>';
    data = JSON.parse(data);
    $('#tree').treeview({
        color: "#555",
        selectedColor: "#337ab7",
        selectedBackColor: '#F5F5F5',
        expandIcon: 'glyphicon glyphicon-chevron-right',
        collapseIcon: 'glyphicon glyphicon-chevron-down',
        nodeIcon: 'glyphicon glyphicon-user',
        enableLinks: true,
        showTags: true,
        data: data
    });
});
<?php endif; ?>

function init_onload_checkbox(level)
{
    var next_level = level + 1;
    var div = $('.level' + level + '-rule');
    for (var i = 0;i < div.length;i++)
    {
        var cb = $(div[i]).find('.level' + next_level + '-checkbox');
        var check_num = 0;

        var is_indeterminate = false;
        for (var j = 0; j < cb.length; j++) {
            if ($(cb[j]).is(':checked')) check_num++;
            if ($(cb[j]).is(':indeterminate')) 
            {
                is_indeterminate = true;
                break;
            }
        }

        var check_status = 0; // 0 全没选 1 全选 -1  部分选中

        if (is_indeterminate)
        {
            check_status = -1;
        }
        else
        {
            if (check_num == 0) {
            check_status = 0;
            }
            else if (check_num == cb.length) {
                check_status = 1;
            }
            else {
                check_status = -1
            }
        }
        

        if (check_status == -1)
        {
            $(div[i]).find('.level' + level + '-checkbox').prop('indeterminate', true);
            $(div[i]).find('.level' + level + '-checkbox').prop('checked', false);
        }
    }
}
init_onload_checkbox(3);
init_onload_checkbox(2);
init_onload_checkbox(1);
</script>

    <!-- 自定义js模板 -->
    <!-- require -->
<script src="/dist/js/require.js?v=<?php echo $config['site']['version']; ?>" data-main="/dist/js/require-main.js?v=<?php echo $config['site']['version']; ?>"></script>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:80:"/opt/web/zs/apps/rbac/public/../application/v1/view/group/organization/edit.html";i:1556509685;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        
<div class="dialog-content content">
    <div>
        <a class="btn btn-success btn-sm add_account" data-url="<?php echo url('/v1/group/organization/addaccount',array('user_id'=>$info['user_id'])); ?>" data-id="<?php echo $info['org_id']; ?>" href="javascript:;"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i>新增帐号</a>
        &nbsp;&nbsp;
        <a class="btn btn-success btn-sm add_account" data-url="<?php echo url('/v1/group/organization/batchaccount',array('user_id'=>$info['user_id'])); ?>" data-id="<?php echo $info['org_id']; ?>" href="javascript:;"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i>批量新增</a>
        &nbsp;&nbsp;
        <a class="btn btn-danger btn-sm batch_move_account" href="javascript:;" data-url="<?php echo url('/v1/group/organization/moveaccount'); ?>" data-org="<?php echo $info['org_id']; ?>" data-user="<?php echo $info['user_id']; ?>"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i>一键移除</a>
    </div>
    <br>
    <form action="<?php echo url('/v1/group/organization/edit'); ?>" class="form-horizontal dialog-form" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th class="td-align">平台</th>
            <th class="td-align">帐号</th>
            <th class="td-align">操作</th>
        </tr>
        </thead>
        <tbody id="body">
        <?php if(is_array($accountInfo) || $accountInfo instanceof \think\Collection || $accountInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $accountInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
            <td class="td-align td-padding"><?php echo $vo['platform']; ?></td>
            <td class="td-align td-padding"><?php echo $vo['platform_account']; ?></td>
            <td class="td-align td-padding">
                <a class="btn btn-info btn-xs edit_account" data-url="<?php echo url('/v1/group/organization/editaccount',array('id'=>$vo['id']) ); ?>" href="javascript:;"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>编辑</a>
                <a class="btn btn-danger btn-xs move_account" href="javascript:;" data-url="<?php echo url('/v1/group/organization/moveaccount'); ?>" data-id="<?php echo $vo['id']; ?>"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i>移除</a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
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
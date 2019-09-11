<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:69:"/opt/web/zs/apps/rbac/public/../application/v1/view/auth/tag/cat.html";i:1555919735;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
<body class="hold-transition skin-blue sidebar-mini">

<div class="container-fluid">
    <br>
    <form action="<?php echo url('/v1/auth/tag/cat'); ?>" class="form-horizontal" method="post">
        <input type="hidden" name="id" id="rules_id" value="<?php echo $params['id']; ?>">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm"  name="username" value="<?php echo $params['username']; ?>" placeholder="请输入姓名">
                    </div>
                    <button class="btn btn-info" type="Submit">搜索</button>
                </div>
            </div>
        </div>
    </form>

    <div class="btn-group batch-bottom">
        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="badge box_total">0</span> 批量操作 <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <!--物流操作-->
            <li><a href="javascript:;" class="batch_move" data-url="<?php echo url('/v1/auth/tag/move'); ?>"><i class="glyphicon glyphicon-remove"></i> 批量移除</a></li>
        </ul>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th class="td-align td-width-40px">
                <input class="data-check_box_total" type="checkbox"/>
            </th>
            <th class="td-align">姓名</th>
            <th class="td-align">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list['data']) || $list['data'] instanceof \think\Collection || $list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
            <td class="td-align td-padding">
                <input type="checkbox" name="box_checked" data-id="<?php echo $vo['id']; ?>" class="data-check_box">
            </td>
            <td><?php echo $vo['username']; ?></td>
            <td class="td-align td-padding">
                <button type="button" class="btn btn-danger btn-xs move"
                        data-url="<?php echo url('/v1/auth/tag/move',array('ids'=>$vo['id'],'rules_id'=>$params['id'])); ?>"><i
                        class="glyphicon glyphicon-remove-circle"></i> 移除
                </button>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div class="pages"><?php echo isset($page)?$page: ''; ?></div>
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

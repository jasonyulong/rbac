<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:79:"/opt/web/zs/apps/rbac/public/../application/v1/view/menus/index/menudetail.html";i:1556077502;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        
<div class="panel-body">
    <div class="form-group">
        <?php echo build_toolbar('button',
        ['class' => 'btn btn-success addmenudetail','data-url' => url('/v1/menus/index/editdetail',array('menuid'=>$menuid))],
        '<i class="glyphicon glyphicon-plus"></i> 添加节点'); ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="td-align td-width-50px">ID</th>
                <th class="td-align">标题</th>
                <th class="td-align">请求地址</th>
                <th class="td-align">节点因子</th>
                <th class="td-align">类型</th>
                <th class="td-align">状态</th>
                <th class="td-align">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($menudetail) || $menudetail instanceof \think\Collection || $menudetail instanceof \think\Paginator): if( count($menudetail)==0 ) : echo "" ;else: foreach($menudetail as $key=>$vo): ?>
            <tr class="<?php if($vo['is_special'] == 1): ?>warning<?php endif; ?>">
                <td class="td-align td-padding"><?php echo $vo['id']; ?></td>
                <td class="td-padding"><?php echo $vo['title']; ?></td>
                <td class="td-padding"><?php echo $vo['url']; ?></td>
                <td class="td-padding"><?php echo $vo['condition']; ?></td>
                <td class="td-align td-padding"><?php if($vo['type'] == '1'): ?>节点<?php else: ?>页面<?php endif; ?></td>
                <?php if($vo['status'] == 1): ?>
                <td class="td-align text-success"><i class="fa fa-circle"> 正常</i></td>
                <?php else: ?>
                <td class="td-align text-danger"><i class="fa fa-times-circle"> 禁用</i></td>
                <?php endif; ?>
                <td class="td-align td-padding">
                    <?php echo build_toolbar('button',
                    ['class' => 'btn btn-success btn-xs editdetail','title' => '编辑节点','data-url' => url('/v1/menus/index/editdetail',array('id'=>$vo['id'], 'menuid'=>$menuid))],
                    '<i class="fa fa-pencilfa fa-pencil"></i>'); ?>
                    &nbsp;
                    <?php echo build_toolbar('button',
                    ['class' => 'btn btn-danger btn-xs deldetail','title' => '删除节点','data-param' => $vo['id'],'data-url' => url('/v1/menus/index/deldetail')],
                    '<i class="fa fa-trash"></i>'); ?>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
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
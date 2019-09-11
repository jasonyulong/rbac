<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:69:"/opt/web/zs/apps/rbac/public/../application/v1/view/auth/tag/add.html";i:1556077502;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        
<div class="tag-content">
    <form action="<?php echo url('/v1/auth/tag/add'); ?>" class="form-horizontal dialog-form" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label"><span class="red-color">*</span>标签名称：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                               data-rule="required;name;"
                               data-msg-required="请填写标签名称"
                               data-tip="你可以用汉字、字母、数字">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label"><span class="red-color">*</span>标签描述：</label>
                    <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="desc" name="desc" rows="8"
                                  data-rule="required;name;" data-msg-required="请填写标签描述"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="td-align dialog-footer">
            <button class="btn btn-warning" onclick="javascript:parent.layer.closeAll();"> <i class="fa fa-close"></i> 取消</button>
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 确定提交</button>
        </div>
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
<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:89:"/opt/web/zs/apps/rbac/public/../application/v1/view/group/organization/batch_account.html";i:1556599664;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        
<div class="tag-content content">
    <form action="<?php echo url('/v1/group/organization/addaccount'); ?>" class="form-horizontal dialog-form" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
        <input type="hidden" name="user_id" value="<?php echo $params['user_id']; ?>">
        <input type="hidden" name="org_id" value="<?php echo $params['org_id']; ?>">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label  class="col-sm-3 control-label"><span class="red-color">*</span>平台：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" name="platform"  title="请选择">
                            <?php if(is_array($platformAccountArr) || $platformAccountArr instanceof \think\Collection || $platformAccountArr instanceof \think\Paginator): $i = 0; $__LIST__ = $platformAccountArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-3 control-label"><span class="red-color">*</span>帐号：</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="platform_account" rows="8"  data-rule="required;title;" placeholder="可填写多个帐号,以逗号、换行隔开"
                                  data-msg-required="请输入帐号"></textarea>
                    </div>
                </div>

                <div class="dialog-footer td-align">
                    <a class="btn btn-warning" href="javascript:parent.layer.closeAll();"> <i class="fa fa-close"></i> 取消</a>
                    <button class="btn btn-primary" type="submit"> <i class="fa fa-save"></i> 确定</button>
                </div>
            </div>
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
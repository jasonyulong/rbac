<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:78:"/opt/web/zs/apps/rbac/public/../application/v1/view/group/department/copy.html";i:1555393495;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        
<div class="dialog-content">
    <form action="<?php echo url('/v1/group/department/copy'); ?>" class="form-horizontal dialog-form" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
        <div class="row">
            <div class="col-md-9">

                <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                <input type="hidden" name="under" value="<?php echo $info['under']; ?>">

                <div class="form-group">
                    <label for="pid" class="col-sm-3 control-label">父级部门：</label>
                    <div class="col-sm-9">
                        <select class="form-control"  id="pid" name="pid"  data-msg-required="请选择">
                            <option value="0">请选择</option>
                            <?php if(is_array($organization) || $organization instanceof \think\Collection || $organization instanceof \think\Paginator): $i = 0; $__LIST__ = $organization;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['id']; ?>"
                                <?php if($info['pid'] == $vo['id']): ?>selected="selected"<?php endif; ?>
                                ><?php echo $vo['title']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label"><span class="red-color">*</span>部门名称：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="title" name="title" value="<?php echo $info['title']; ?>"
                               data-rule="required;title;"
                               data-msg-required="请填写部门名称"
                               data-tip="你可以用汉字、字母、数字">
                    </div>
                </div>

                <div class="form-group">
                    <label for="pid" class="col-sm-3 control-label"><span class="red-color">*</span>负责人：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" title="" id="manage_uid" name="manage_uid"  data-msg-required="请选择"
                                data-rule="required;manage_uid;"
                                data-msg-required="必选项">
                            <option value="">请选择</option>
                            <?php if(is_array($saleUser) || $saleUser instanceof \think\Collection || $saleUser instanceof \think\Paginator): $i = 0; $__LIST__ = $saleUser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $key; ?>"
                            <?php if($info['manage_uid'] == $key): ?>selected="selected"<?php endif; ?>
                            ><?php echo $vo; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label"><span class="red-color">*</span>权重：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="weigh" name="weigh" value="<?php echo $info['weigh']; ?>"
                               data-rule="required;weigh;"
                               data-msg-required="请填写权重"
                               data-tip="数字">
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
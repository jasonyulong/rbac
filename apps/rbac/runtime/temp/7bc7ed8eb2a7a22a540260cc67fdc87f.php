<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:79:"/opt/web/zs/apps/rbac/public/../application/v1/view/group/organization/add.html";i:1554986348;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <form action="<?php echo url('/v1/group/organization/add'); ?>" class="form-horizontal dialog-form" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
        <input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="user_id" class="col-sm-3 control-label"><span class="red-color">*</span>姓名：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick"  id="user_id" name="user_id"
                                data-msg-required="请选择" data-rule="required;user_id;"
                                data-actions-box="true" data-live-search="true"  title="请选择">
                            <option value="">请选择</option>
                            <?php if(is_array($saleUser) || $saleUser instanceof \think\Collection || $saleUser instanceof \think\Paginator): $i = 0; $__LIST__ = $saleUser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>


                <!--<div class="form-group">
                    <label  class="col-sm-3 control-label"><span class="red-color">*</span>账号属性：</label>
                    <div class="col-sm-3">
                        <select class="form-control selectpicker show-tick" id="platform">
                            <option value="">平台</option>
                            <option value="">ebay</option>
                            <option value="">wish</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <select class="selectpicker show-tick form-control" id="platform_account_id" name="platform_account_id"
                                data-actions-box="true" data-live-search="true" multiple="multiple" title="账号">
                            <option value="">ebay</option>
                            <option value="">wish</option>
                        </select>
                    </div>

                </div>-->

                <!--<div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-md-offset-7 col-sm-2 one-delete">
                        <a class="btn btn-danger btn-sm" href="javascript:;">一键删除<i class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="td-align dialog-footer">
            <a class="btn btn-warning" href="javascript:parent.layer.closeAll();"> <i class="fa fa-close"></i> 取消</a>
            <button class="btn btn-primary" type="Submit"> <i class="fa fa-save"></i> 确定提交</button>
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
<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:87:"/opt/web/zs/apps/rbac/public/../application/v1/view/group/organization/add_account.html";i:1556599664;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        <input type="hidden" id="td-platform-account" data-all="<?php echo base64_encode(json_encode($platformAccountArr)); ?>">
        <input type="hidden" id="bind-account" data-all="<?php echo base64_encode(json_encode($bindAccount)); ?>">
        <input type="hidden" name="user_id" value="<?php echo $params['user_id']; ?>">
        <input type="hidden" name="org_id" value="<?php echo $params['org_id']; ?>">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label  class="col-sm-3 control-label"><span class="red-color">*</span>平台：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" name="platform" id="platform-select" title="请选择">
                            <?php if(is_array($platformAccountArr) || $platformAccountArr instanceof \think\Collection || $platformAccountArr instanceof \think\Paginator): $i = 0; $__LIST__ = $platformAccountArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-3 control-label"><span class="red-color">*</span>帐号：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" name="platform_account" id="select-ebay_account"  title="请选择"></select>
                    </div>
                </div>


                <div class="form-group" id="store">
                    <label  class="col-sm-3 control-label">仓库：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" name="store_id">
                            <option value="0">请选择</option>
                            <?php if(is_array($storeArr) || $storeArr instanceof \think\Collection || $storeArr instanceof \think\Paginator): $i = 0; $__LIST__ = $storeArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $key; ?>"><?php echo $v; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>


                <div class="form-group" id="locations">
                    <label  class="col-sm-3 control-label">location：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" name="locations[]" multiple="multiple" data-actions-box="true" title="请选择">
                            <?php if(is_array($locationArr) || $locationArr instanceof \think\Collection || $locationArr instanceof \think\Paginator): $i = 0; $__LIST__ = $locationArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="sales_label">
                    <label  class="col-sm-3 control-label">销售标签：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" multiple="multiple" name="sales_label[]" data-actions-box="true" title="请选择">
                            <?php if(is_array($saleArr) || $saleArr instanceof \think\Collection || $saleArr instanceof \think\Paginator): $i = 0; $__LIST__ = $saleArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
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
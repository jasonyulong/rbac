<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:72:"/opt/web/zs/apps/rbac/public/../application/v1/view/menus/index/add.html";i:1556509685;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
        
<style>
    .btn-search-icon {margin-left: 203px;margin-top: -57px;}
    .col-xs-8 {margin-top: 50px;}
    #giveUpBtn {margin-left: 20px;}
</style>
<div class="dialog-content">
    <form class="form-horizontal ajax-form" action="" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">标题：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $menuInfo['title']; ?>" placeholder="标题">
                    </div>
                </div>
                <div class="form-group">
                    <label for="moduleid" class="col-sm-3 control-label">所属系统：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="moduleid" value="<?php echo $allowSystem[$moduleid]; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="parentMenu" class="col-sm-3 control-label">父类：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" id="parentMenu" name="parentMenu" data-actions-box="true" data-live-search="true">
                            <option value="0">无</option>
                            <?php if(is_array($parentMenu) || $parentMenu instanceof \think\Collection || $parentMenu instanceof \think\Paginator): if( count($parentMenu)==0 ) : echo "" ;else: foreach($parentMenu as $kk=>$val): ?>
                                <option value="<?php echo $val['id']; ?>" <?php if($menuInfo['pid'] == $val['id']): ?>selected<?php elseif(in_array($val['id'], $granChild)): ?>disabled="disabled"<?php endif; ?>><?php echo $val['title']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-sm-3 control-label">菜单类型：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" id="type" name="type">
                            <option value="0" <?php if($menuInfo['type'] == '0'): ?>selected<?php endif; ?>>普通菜单</option>
                            <option value="1" <?php if($menuInfo['type'] == '1'): ?>selected<?php endif; ?>>特殊菜单</option>
                            <option value="2" <?php if($menuInfo['type'] == '2'): ?>selected<?php endif; ?>>节点</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="send_job" class="col-sm-3 control-label">通知授权：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" id="send_job" name="send_job" data-live-search="true">
                            <option value="">--岗位--</option>
                            <?php if(!(empty($userJob) || (($userJob instanceof \think\Collection || $userJob instanceof \think\Paginator ) && $userJob->isEmpty()))): if(is_array($userJob) || $userJob instanceof \think\Collection || $userJob instanceof \think\Paginator): if( count($userJob)==0 ) : echo "" ;else: foreach($userJob as $kk=>$jobs): ?>
                                    <option value="<?php echo $jobs['id']; ?>"><?php echo $jobs['title']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status0" class="col-sm-3 control-label">状态：</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            &nbsp; &nbsp;&nbsp;
                            <input type="radio"  id="status0" name="status" value="0" <?php if($menuInfo['status'] == '0'): ?>checked<?php endif; ?>> 禁用
                            &nbsp; &nbsp;&nbsp; &nbsp;
                            <input type="radio"  id="status1" name="status" value="1" <?php if($menuInfo['status'] != '0'): ?>checked<?php endif; ?>> 正常
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="url" class="col-sm-3 control-label">请求地址：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="url" name="url" value="<?php echo $menuInfo['url']; ?>" placeholder="链接地址">
                    </div>
                </div>
                <div class="form-group">
                    <label for="icon" class="col-sm-3 control-label">图标：</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="icon" name="icon" value="<?php echo isset($menuInfo['icon'])?$menuInfo['icon']: 'fa fa-chevron-right'; ?>" placeholder="图标">
                        <a href="javascript:;" class="btn btn-default btn-search-icon">Search icon</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">权重：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $menuInfo['weigh']; ?>" placeholder="权重">
                    </div>
                </div>
                <div class="form-group">
                    <label for="remark" class="col-sm-3 control-label">备注：</label>
                    <div class="col-sm-9">
                    <textarea class="form-control" id="remark" name="remark" placeholder="说点什么···"><?php echo $menuInfo['remark']; ?></textarea>
                    </div>
                </div>
                <input type="hidden" name="menu_id" value="<?php echo $menuid; ?>">
                <input type="hidden" name="module" value="<?php echo $moduleid; ?>">
            </div>
        </div>
        <div class="col-xs-offset-4 col-xs-8">
            <button type="button" class="btn btn-primary saveMenus" data-url="<?php echo url('/v1/menus/index/edit'); ?>">保存</button>
            <button type="button" class="btn btn-default" id="giveUpBtn">取消</button>
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
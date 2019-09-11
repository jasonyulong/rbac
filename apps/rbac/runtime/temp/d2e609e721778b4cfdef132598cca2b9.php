<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:79:"/opt/web/zs/apps/rbac/public/../application/v1/view/menus/index/editdetail.html";i:1555919735;s:60:"/opt/web/zs/apps/rbac/application/v1/view/layout/dialog.html";i:1554790531;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    .col-xs-8 {margin-top: 50px;}
    #giveUpBtn {margin-left: 20px;}
</style>
<div class="dialog-content">
    <form class="form-horizontal ajax-form" autocomplete="off">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">标题：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $detailInfo['title']; ?>" placeholder="标题名称">
                    </div>
                </div>
                <div class="form-group">
                    <label for="condition" class="col-sm-3 control-label">节点因子：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="condition" id="condition" value="<?php echo $detailInfo['condition']; ?>" placeholder="节点因子" <?php if($detailInfo['type'] != '1'): ?>readonly<?php endif; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">权重：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="weight" id="weight" value="<?php echo $detailInfo['weigh']; ?>" placeholder="权重">
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
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="detaileType" class="col-sm-3 control-label">类型：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" id="detaileType" name="type">
                            <option value="0" <?php if($detailInfo['type'] == '0'): ?>selected<?php endif; ?>>页面</option>
                            <option value="1" <?php if($detailInfo['type'] == '1'): ?>selected<?php endif; ?>>节点</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="url" class="col-sm-3 control-label">请求地址：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="url" id="url" value="<?php echo $detailInfo['url']; ?>" placeholder="请求地址" <?php if($detailInfo['type'] == '1'): ?>readonly<?php endif; ?>>
                    </div>
                </div>
                <input type="hidden" name="menuid" id="menuid" value="<?php echo $menuid; ?>">
                <input type="hidden" name="detailid" id="detailid" value="<?php echo $detailid; ?>">
                <div class="form-group">
                    <label for="special" class="col-sm-3 control-label">是否特殊：</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker show-tick" id="special" name="special">
                            <option value="0" <?php if($detailInfo['is_special'] == '0'): ?>selected<?php endif; ?>>不特殊</option>
                            <option value="1" <?php if($detailInfo['is_special'] == '1'): ?>selected<?php endif; ?>>特殊</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status0" class="col-sm-3 control-label">状态：</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            &nbsp; &nbsp;&nbsp;
                             <input type="radio"  id="status0" name="status" value="0" <?php if($detailInfo['status'] == '0'): ?>checked<?php endif; ?>> 禁用
                            &nbsp; &nbsp;&nbsp; &nbsp;
                            <input type="radio"  id="status1" name="status" value="1" <?php if($detailInfo['status'] != '0'): ?>checked<?php endif; ?>> 正常
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-offset-4 col-xs-8">
            <button type="button" class="btn btn-primary saveMenuDetail" data-url="<?php echo url('/v1/menus/index/editdetail'); ?>">保存</button>
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